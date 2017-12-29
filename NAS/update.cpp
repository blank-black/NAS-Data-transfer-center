//$1用户个数m
//$2:目录个数n
//$3-$(n+2):目录名
#include <iostream>
#include <cstdio>
#include <fstream>
#include <string>
#include <cstring>
#include <cstdlib>
using namespace std;

char dir[] = "/home/uploads/";
char userdir[] = "/home/vfm-admin/users/users.php";
char smbdir[] = "/etc/samba/smb.conf";

int main(int argc,char** argv)
{
	int m, n;
	m = atoi(argv[1]);
	n = atoi(argv[2]);
	string user[n], wlist[n], rlist[n], filename[n], space = " ", array = " => ", uploads[n];
	int i, j, k;
	for (i = 0; i < n; i++)
	{
		user[i] = "	valid users = root ";
		wlist[i] = "	write list = root ";
		rlist[i] = "	read list = root ";
		filename[i] = argv[i + 3];
		uploads[i] = "uploads/" + filename[i];
	}
	for (i = 0; i < n; i++)//遍历目录
	{
		for (j = 1; j <= m; j++)//遍历用户
		{
			char num[10];
			num[0]=j+'0';
			num[1]='\0';
			string temparray = space+space + num + array;
			fstream file(userdir);
			string line, name;
			while (!file.eof())
			{
				getline(file, line);
				if (line == temparray)
				{
					while (1)
					{
						string temp;
						getline(file, line);
						if (line == "  ),")
							break;
						if (line.find("'name'") != string::npos)
						{
							char tempname[30];
							int tempnum = 0, strnum = 0;
							for (k = 0; !(line[k] == '\'' && tempnum == 3); k++)
							{
								if (tempnum == 3)
								{
									tempname[strnum] = line[k];
									strnum++;
								}
								if (line[k] == '\'')
									tempnum++;
							}
							tempname[strnum] = '\0';
							name = tempname;
						}
						if (line.find(uploads[i]) != string::npos)
						{
							int tempnum = 0, strnum = 0;
							for (k = 0; !(line[k] == '\'' && tempnum == 3); k++)
							{
								if (tempnum == 3)
								{
									if (line[k] == '2')
										wlist[i] += name + " ";
									rlist[i] += name + " ";
									user[i] += name + " ";
									strnum++;
								}
								if (line[k] == '\'')
									tempnum++;
							}
						}
					}
				}
			}
			file.close();
		}
	}
	fstream file(smbdir);
	ofstream outfile("in2.txt", ios::out | ios::trunc);
	string line;
	i = 0;
	while (!file.eof())
	{
		string name = "[" + filename[i] + "]";
		getline(file, line);
		if (line.find(name) != string::npos)
		{
			for (j = 0; j < 7; j++)
			{
				outfile << line << endl;
				getline(file, line);
			}
			outfile << user[i] << endl;
			getline(file, line);
			outfile << wlist[i] << endl;
			getline(file, line);
			outfile << rlist[i] << endl;
			getline(file, line);
	
			i++;
		}
		outfile << line << endl;
	}
	outfile.close();
	file.close();
	ofstream outfile1("in.txt", ios::out | ios::trunc);
	fstream file1("in2.txt");
	while (!file1.eof())
	{
		getline(file1, line);
		outfile1 << line << endl;
	}
	outfile1.close();
	file1.close();
	system("rm -rf in2.txt");//删除中间文件
	system("rm -rf /etc/samba/smb.conf");
	system("mv in.txt /etc/samba/smb.conf");
//	system("echo \"`date +%Y.%m.%d--%H:%M:%S`   Root edit permissions.\">>/log/$1.log");
//	system("systemctl restart smb.service");

}