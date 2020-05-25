<?php
require 'copystart.php';

$think = $_GET['lang'];
//SK tab
if (isset($_GET['id']) && $think == 'sk'){
    $deletePage = $db->prepare("DELETE FROM sk WHERE id = :id");
    $deletePage->execute(['id' => $_GET['id']]);
    header ('Location: copy.php?lang=sk');
}
//ENG tab
else{
    $deletePage = $db->prepare("DELETE FROM eng WHERE id = :id");
    $deletePage->execute(['id' => $_GET['id']]);
    header ('Location: copy.php');
}
?>