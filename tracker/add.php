<?php
$servername = "mysql80.websupport.sk;port=3314";
$username = "content";
$password = "ZmenS1Heslo!";
$dbname = "content";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO tabmsg (name, company, country, added) 
                            VALUES (:name, :company, :country, :added)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':company', $company);
    $stmt->bindParam(':country', $country);
//better keep the date last @ line 13 and 14
    $date = new Datetime('now');
    $stmt->bindParam(':added', $date->format('Y-m-d H:i'));

// insert a row
    $name = $_POST["name"];
    $company = $_POST["company"];
    $added = $POST["added"];
    $country = $_POST["country"];
    $stmt->execute();


    header('location:index.php');
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;

?>