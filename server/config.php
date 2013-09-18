<?php
header('Access-Control-Allow-Origin: *');

/*openlog("debug_Log", LOG_PID | LOG_PERROR, LOG_AUTH);

syslog(LOG_WARNING, "Test 1.");*/

$dbName='fakeName';
$dbUser='fakeUserName';
$dbPwd='fakePassword';

$con = mysql_connect("localhost",$dbUser,$dbPwd);
if (!$con)
{
        die('Could not connect: ' . mysql_error());
}

// Set the active mySQL database
$db_selected =mysql_select_db($dbName, $con);
if (!$db_selected) {
  die ("Can\'t use db : " . mysql_error());
}

?>