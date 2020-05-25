<?php
require 'start.php';

$editnote    = !empty($_POST['editnote']) ? htmlentities($_POST['editnote']) : "";
$name        = !empty($_POST['editname']) ? htmlentities($_POST['editname']) : "";
$company        = !empty($_POST['editcompany']) ? htmlentities($_POST['editcompany']) : "";
$country        = !empty($_POST['editcountry']) ? htmlentities($_POST['editcountry']) : "";
$id          = !empty($_GET['id']) ? htmlentities($_GET['id']) : "";

$sql = "UPDATE tabmsg SET note=?, name=?, company=?, country=? WHERE id=?";
$stmt= $db->prepare($sql);
$stmt->execute([$editnote, $name, $company, $country, $id]);

header ('Location: index.php');

?>