<?php
function connection() 
{ 
    $mysql_server = "localhost"; 
    $mysql_admin = "root"; 
    $mysql_pass = ""; 
    $mysql_db = "TreeDataBase"; 
    @mysql_connect($mysql_server, $mysql_admin, $mysql_pass) 
    or die('Brak połączenia z serwerem MySQL.'); 
    @mysql_select_db($mysql_db) 
    or die('Błąd wyboru bazy danych.'); 
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
}
?>
