#include <iostream>
#include <netinet/in.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <fstream>
#include <sys/prctl.h>
#include <signal.h>
#include <stdarg.h>
#include <time.h>
#include <fcntl.h>
#include <arpa/inet.h>
#include <sys/wait.h>

using namespace std;
#define BUFSIZE 100
#define QUEUE 100
char ID[]="001";
char ip[]="192.168.2.230";
int port=2333;

struct sockaddr_in servaddr,cliaddr;
struct sockaddr_in server_sockaddr;

int init_socket(int j,int sock_cli)
{
	sock_cli = socket(AF_INET, SOCK_STREAM, 0);
	if (sock_cli == -1)
	{
		cout << "socket建立失败" << endl;
		return -1;
	}
	memset(&servaddr, 0, sizeof(servaddr));
	servaddr.sin_family = AF_INET;
	servaddr.sin_port = htons(port);
	servaddr.sin_addr.s_addr = server_sockaddr.sin_addr.s_addr;
	int flags = fcntl(sock_cli, F_GETFL, 0);
	fcntl(sock_cli, F_SETFL, flags | O_NONBLOCK);
	return 0;
}


int connect_server(int con_fd)
{
	//connect
	if (connect(con_fd, (struct sockaddr *) &server_sockaddr, sizeof(struct sockaddr)) == -1)
	{
		struct timeval tm;
		fd_set confd;
		tm.tv_sec = 10;
		tm.tv_usec = 0;
		FD_ZERO(&confd);
		FD_SET(con_fd, &confd);
		int sel = select(con_fd + 1, NULL, &confd, NULL, &tm);
		if (sel <= 0)
		{
			sleep(1);
			connect_server(con_fd);
		}
	}
	return 0;
}


void gettime(char TIME[][20],int j)
{
	time_t timep;
	struct tm *p;
	time(&timep);
	p = localtime(&timep);
	sprintf(TIME[j], "%d-%d-%d %d:%d:%d", (1900 + p->tm_year), (1 + p->tm_mon), p->tm_mday, p->tm_hour, p->tm_min,
	        p->tm_sec);
	TIME[j][0] = (1900 + p->tm_year) / 1000 + '0';
	TIME[j][1] = (1900 + p->tm_year) / 100 % 10 + '0';
	TIME[j][2] = (1900 + p->tm_year) / 10 % 10 + '0';
	TIME[j][3] = (1900 + p->tm_year) % 10 + '0';
	TIME[j][4] = '-';
	TIME[j][5] = (1 + p->tm_mon) / 10 + '0';
	TIME[j][6] = (1 + p->tm_mon) % 10 + '0';
	TIME[j][7] = '-';
	TIME[j][8] = p->tm_mday / 10 + '0';
	TIME[j][9] = p->tm_mday % 10 + '0';
	TIME[j][10] = ' ';
	TIME[j][11] = p->tm_hour / 10 + '0';
	TIME[j][12] = p->tm_hour % 10 + '0';
	TIME[j][13] = ':';
	TIME[j][14] = p->tm_min / 10 + '0';
	TIME[j][15] = p->tm_min % 10 + '0';
	TIME[j][16] = ':';
	TIME[j][17] = p->tm_sec / 10 + '0';
	TIME[j][18] = p->tm_sec % 10 + '0';
	TIME[j][19] = '\0';
}

int main(int argc ,char* argv[])
{
//	int pidd = fork();
//	if (pidd > 0)
//		return 0;
	server_sockaddr.sin_family = AF_INET;
	int i, j, k, n;
	server_sockaddr.sin_addr.s_addr = inet_addr(argv[1]);
	server_sockaddr.sin_port = htons(atoi(argv[2]));
	cliaddr.sin_family = AF_INET;
	cliaddr.sin_port = htons(port);  ///端口
	cliaddr.sin_addr.s_addr = inet_addr(ip);  ///ip

	char buf_send[10][BUFSIZE], buf_recv[BUFSIZE];
	char TIME[QUEUE][20];
	int sock_cli, client_status = 0, success = 0, fail = 0, child = 0;
	fd_set fdR;
	fd_set fdW;
	FD_ZERO(&fdR);
	FD_ZERO(&fdW);
	int exit_status;


	struct timeval tv;
	tv.tv_sec = 30;
	tv.tv_usec = 0;

	init_socket(i, sock_cli);
	connect_server(sock_cli);
	if (bind(sock_cli, (struct sockaddr *) &cliaddr, sizeof(cliaddr)) == -1)
	{
		perror("bind");
		exit(1);
	}

	if (fork() == 0)
	{
		int length = 0;
		while (1)
		{
			FD_SET(sock_cli, &fdR);
			FD_SET(sock_cli, &fdW);
			int ret = select(sock_cli + 1, &fdR, &fdW, NULL, &tv);
			if (ret > 0)
			{
				if (FD_ISSET(sock_cli, &fdR))
				{
					memset(buf_recv, 0, sizeof(buf_recv));
					int len = recv(sock_cli, buf_recv, sizeof(buf_recv), 0);
					if (client_status == 1)
					{
						if (buf_recv[0] == 'O' && buf_recv[1] == 'K')
						{
							gettime(TIME, i);
							cout << TIME[i] << "  sockfd" << sock_cli << "  收到OK  " << "  status:"
							     << client_status << endl;
							break;
						}
						else
						{
							cout << "recv failed!" << endl;
							exit(EXIT_FAILURE);
						}

					}

				}

				if (FD_ISSET(sock_cli, &fdW))
				{
					if (client_status == 0)
					{
						int len = send(sock_cli, &ID, sizeof(ID), 0);
						gettime(TIME, i);
						cout << TIME[i] << "  sockfd" << sock_cli << "  发送ID  "
						     << "  status:" << client_status << endl;
						if (len < sizeof(ID))
						{
							cout << "send failed!" << endl;
							exit(EXIT_FAILURE);
						}
						client_status++;
					}
				}
			}
			else if (ret <= 0)
				exit(EXIT_FAILURE);

		}

		///执行端口转发脚本
		char str[100] = "/home/port_trans.sh ";
		strcat(str, ip);
		strcat(str, " ");
		strcat(str, argv[1]);
		strcat(str, " ");
		char strport[10];
		sprintf(strport, "%d", port);  
		strcat(str, strport);
		strcat(str, " ");
		strcat(str, argv[2]);

		system(str);
		return 0;
	}
	else
		return 0;
}


