<?php

function connect_to_db(
    string $host = "localhost", 
    string $username = "root", 
    string $password = "", 
    string $dbname = "raintreetask"
): mysqli {
    // Create a new database connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $conn; // Return the database connection object
}
