<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "member_crud";
    //Database myphp name: _________
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Test connecting . . .
        echo "Database Connected successfully";
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>