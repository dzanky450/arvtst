<?php
require 'start.php';

if (isset($_GET['id'])){
    $deletePage = $db->prepare("DELETE FROM tabmsg WHERE id = :id");
    $deletePage->execute(['id' => $_GET['id']]);
}
header ('Location: index.php');

?>