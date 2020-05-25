<?php
require 'start.php';

$note    = !empty($_POST['note']) ? htmlentities($_POST['note']) : "";
$id    = !empty($_GET['id']) ? htmlentities($_GET['id']) : "";

$sql = "UPDATE tabmsg SET note=? WHERE id=?";
$stmt= $db->prepare($sql);
$stmt->execute([$note, $id]);

header ('Location: index.php');

?>