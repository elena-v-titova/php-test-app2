<?php

require_once "vendor/autoload.php";
require_once "config.php";

try {
    $dbh = DBConnection::getDBConnection($dbHost, $dbName, $dbUser, $dbPassword);

    $table = "Product";
    $columns = "id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
        "name VARCHAR(256) NOT NULL, ".
        "quantity INT UNSIGNED NOT NULL, ".
        "price FLOAT NOT NULL ";

    $sql = "CREATE TABLE $table ($columns)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

} catch(PDOException $e) {
    echo $e->getMessage();
}

