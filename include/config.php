<?php

$hostname = "localhost";
$db_name = "dblogin";
$username = "root";
$password = "root";
//$connection = mysql_connect($hostname,$username,$password) or
//die ("please make sure the config information is correct");
//
//mysql_select_db($db_name)
//or die ("please make sure the config information is correct");
//

try {

    $pdo = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $e) {
    echo $e->getMessage();
}

?>
