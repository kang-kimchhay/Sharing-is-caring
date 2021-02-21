<?php
include 'Database.php';
class User extends Database{

}

$newObject = new Database();
$value=['dara','u08',];
$fill=("name,user_code");

// for execute insert
$result = $newObject->insert('users',$value,$fill);
print($result);
?>