<?php
	if(!mysql_connect("10.60.102.252", "G1551265", "G1551265"))
	{
		die('oops connection problem ! --> '.mysql_error());
	}
	if(!mysql_select_db("G1551265"))
	{
		die('oops database selection problem ! --> '.mysql_error());
	}
?>