<?php
if(!mysql_connect("localhost","root","mda3307851"))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("nasdb"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>