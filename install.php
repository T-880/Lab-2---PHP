<?php

// Anslut till MySQL-servern
$db = new mysqli("localhost", "root", "", "");

// Kontrollera anslutningen
if ($db->connect_error) {
    die("Anslutningen misslyckades: " . $db->connect_error);
}

// Skapa databasen
$sql = "CREATE DATABASE IF NOT EXISTS bucketlist
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci";

if ($db->query($sql) === TRUE) {
    echo "Databasen bucketlist har skapats.<br>";
} else {
    die("Fel vid skapande av databas: " . $db->error);
}

// Välj databasen
$db->select_db("bucketlist");

// Skapa tabellen
$sql = "CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    priority INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($db->query($sql) === TRUE) {
    echo "Tabellen items har skapats.";
} else {
    die("Fel vid skapande av tabell: " . $db->error);
}

// Stäng anslutningen
$db->close();

?>