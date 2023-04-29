<?php
class DBCONNECT
{
    // Define the database connection constants
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'supply_chain_db';

    // Create a function to connect to the database
    public static function connect()
    {
        // Create a new mysqli object with SSL/TLS encryption enabled
        $mysqli = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME, null, MYSQLI_CLIENT_SSL);

        // Check if the connection was successful
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }

        // Return the mysqli object
        return $mysqli;
    }
}
