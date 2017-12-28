//mysql_connect.h

#include <iostream>
#include <mysql.h>
using namespace std;

#define HOST		"10.60.102.252"
#define USERNAME	"G1551265"
#define PASSWORD	"G1551265"
#define DATABASE	"G1551265"

int save_nasid(string id)
{
	MYSQL	 *mysql;

	string str = "INSERT INTO nas_user VALUES ('"+id+"')";

	if ((mysql = mysql_init(NULL)) == NULL)
	{
		cout << "mysql_init failed" << endl;
		return -1;
	}

	if (mysql_real_connect(mysql, HOST, USERNAME, PASSWORD, DATABASE, 0, NULL, 0) == NULL)
	{
		cout << "mysql_real_connect failed(" << mysql_error(mysql) << ")" << endl;
		return -1;
	}

	mysql_set_character_set(mysql, "gbk"); 

	if (mysql_query(mysql, str.c_str()))
	{
		cout << "mysql_query failed(" << mysql_error(mysql) << ")" << endl;
		return -1;
	}

	mysql_close(mysql);

	return 0;
}
