#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <signal.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <errno.h>
#include <iostream>
using namespace std;

#define flag 0
#define cout if(flag == 1) cout << "[" << __FUNCTION__ << "()," << __FILE__ << "," << __LINE__ << "] " 

void set_keepalive(int fd);
int Writen(int fd,const void* vptr, int n);
int Client(const string& remote);  // remote: 12.34.56.78:90
int Server(const string& local);   // local : 12.34.56.78:90
void * trans(void *arg);
void daemon_init();

int main(int argc, char** argv)
{
	if (argc != 3)
	{
		cout << "usage : " << argv[0] << " localip:port remoteip:port" << endl;
		exit(-1);
	}
	int nRet;
	string local = argv[1];
	string remote = argv[2];

	daemon_init();

	int listenfd = Server(local);

	int connfd, clientfd;
	while (1)
	{
		connfd = accept(listenfd, (struct sockaddr*)NULL, NULL);
		if (connfd < 0)
		{
			cout << "accept() error," << strerror(errno) << endl;
			exit(errno);
		}
		clientfd = Client(remote);
		if (clientfd == -1)
		{
			close(connfd);
			continue;
		}
		set_keepalive(connfd);
		set_keepalive(clientfd);

		if (clientfd > 0)
		{
			if (fork() == 0)
			{
				cout << getpid() << " child start." << endl;
				pthread_t p1, p2;
				int conn[2];
				int conn_[2];
				conn[0] = connfd; conn[1] = clientfd;
				conn_[0] = clientfd; conn_[1] = connfd;
				pthread_create(&p1, NULL, trans, (void*)conn);

				pthread_create(&p2, NULL, trans, (void*)conn_);

				pthread_join(p2, NULL);
				pthread_join(p1, NULL);
				cout << getpid() << " child normally exit." << endl;
				exit(0); // child exit
			}

			close(connfd);
			close(clientfd);
		}
	}

}

void set_keepalive(int fd)
{
	int val = 1;
	int nRet = setsockopt(fd, SOL_SOCKET, SO_KEEPALIVE, &val, sizeof(val));
	if (nRet < 0)
	{
		cout << "setsockopt(fd,SOL_SOCKET,SOL_KEEPALIVE,&val,sizeof(val)) error," << strerror(errno) << endl;
		return;
	}

	//val = 60;
	//nRet = setsockopt(fd, IPPROTO_TCP, TCP_KEEPALIVE, &val, sizeof(val));
	//if (nRet < 0)
	//{
	//	cout << "setsockopt(fd,IPPROTO_TCP,TCP_KEEPALIVE,&val,sizeof(val)) error," << strerror(errno) << endl;
	//	return;
	//}

	return;
}

void * trans(void *arg)
{
	int connfd1, connfd2;
	connfd1 = ((int*)arg)[0];
	connfd2 = ((int*)arg)[1];
	cout << "connfd1=" << connfd1 << ", connfd2=" << connfd2 << endl;

	int nRead, nWrite;
	char buf[10240] = { 0 };
	while (1)
	{
		cout << getpid() << " before read() ";
		nRead = read(connfd1, buf, sizeof(buf));
		cout << getpid() << " read() return: " << nRead << endl;
		if (nRead < 0)
		{
			if (errno == EINTR) continue;
			cout << getpid() << " read() error," << strerror(errno) << endl;
			break;
		}
		if (nRead == 0)
		{ // remote close
			break;
		}

		nWrite = Writen(connfd2, buf, nRead);
		cout << getpid() << " Writen() return: " << nWrite << endl;
		if (nWrite < 0 || nWrite != nRead)
		{
			cout << getpid() << " Writen() error." << endl;
			break;
		}
	}
	close(connfd1);
	close(connfd2);

	exit(0);
	//pthread_exit(NULL);
}

int Client(const string& remote)
{
	int clientfd, nRet;
	clientfd = socket(AF_INET, SOCK_STREAM, 0);
	if (clientfd < 0)
	{
		cout << "socket() error," << strerror(errno) << endl;
		return -1;
	}
	struct sockaddr_in addr;
	bzero(&addr, sizeof(addr));

	int pos;
	string remoteip, remoteport;
	if ((pos = remote.find(':')) != string::npos)
	{
		remoteip = remote.substr(0, pos);
		remoteport = remote.substr(pos + 1);
	}
	addr.sin_family = AF_INET;
	addr.sin_port = htons(atoi(remoteport.c_str()));
	if (inet_pton(AF_INET, remoteip.c_str(), &addr.sin_addr) <= 0)
	{
		cout << "inet_pton() error," << strerror(errno) << endl;
		return -1;
	}

	if (connect(clientfd, (struct sockaddr*)&addr, sizeof(addr)) < 0)
	{
		cout << "connect() error," << strerror(errno) << endl;
		return -1;
	}

	return clientfd;
}

int Server(const string& local)
{
	string localip, localport;
	int pos;

	if ((pos = local.find(':')) != string::npos)
	{
		localip = local.substr(0, pos);
		localport = local.substr(pos + 1);
		cout << "localip[" << localip << "],localport[" << localport << "]" << endl;
	}
	int listenfd;
	listenfd = socket(AF_INET, SOCK_STREAM, 0);
	if (listenfd < 0)
	{
		cout << "socket() error," << strerror(errno) << endl;
		exit(errno);
	}
	struct sockaddr_in srvaddr;
	bzero(&srvaddr, sizeof(srvaddr));
	srvaddr.sin_family = AF_INET;
	srvaddr.sin_port = htons(atoi(localport.c_str()));

	int nRet = inet_pton(AF_INET, localip.c_str(), &srvaddr.sin_addr);
	if (nRet < 0)
	{
		cout << "inet_pton() error," << strerror(errno) << endl;
		exit(errno);
	}

	int val = 1;
	nRet = setsockopt(listenfd, SOL_SOCKET, SO_REUSEADDR, &val, sizeof(val));
	if (nRet < 0)
	{
		cout << "setsockopt() error," << strerror(errno) << endl;
		exit(errno);
	}

	nRet = bind(listenfd, (struct sockaddr*)&srvaddr, sizeof(srvaddr));
	if (nRet < 0)
	{
		cout << "bind() error," << strerror(errno) << endl;
		exit(errno);
	}
	nRet = listen(listenfd, 10);
	if (nRet < 0)
	{
		cout << "listen() error," << strerror(errno) << endl;
		exit(errno);
	}

	return listenfd;
}

void daemon_init()
{
	if (fork() != 0)
	{
		exit(0);
	}
	if (fork() != 0)
	{
		exit(0);
	}

	for (int i = 1; i <= 64; i++)
	{
		signal(i, SIG_IGN);
	}

	setsid();
	umask(0);
}

int Writen(int fd, const void* vptr, int n)
{
	int nleft;
	int nwritten;
	const char *ptr;
	ptr = (char*)vptr;
	nleft = n;

	while (nleft > 0)
	{
		if ((nwritten = write(fd, ptr, nleft)) <= 0)
		{
			if (errno == EINTR)
				nwritten = 0;
			else
				return -1;
		}
		nleft -= nwritten;
		ptr += nwritten;
	}

	return n;
}