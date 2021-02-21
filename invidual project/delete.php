<?php
include './class/New.php';
//get id to delete
$id = NULL;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
//call ckass news
$newObject = new News();
//query delete
if($newObject->delete($id,'news')) {
    header('Location: index.php');
} else {
    header('Location: index.php');
}
?>