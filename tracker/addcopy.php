<?php
require 'copystart.php';
$think = $_GET['lang'];
//EN tab
if (!empty($_POST) && $think == 'en'){
    $text    = !empty($_POST['textarea']) ? htmlentities($_POST['textarea']) : "";
    $insertPage = $db->prepare("
        INSERT INTO eng (txt)
        VALUES (:txt)
    ");
    $insertPage->execute([
        'txt'    => nl2br($text),
    ]);
    header('location: copy.php');
}
//SK tab
else{
    $text    = !empty($_POST['textarea']) ? htmlentities($_POST['textarea']) : "";
    $insertPage = $db->prepare("
        INSERT INTO sk (txt)
        VALUES (:txt)
    ");
    $insertPage->execute([
        'txt'    => nl2br($text),
    ]);
    header('location: copy.php?lang=sk');
}
?>