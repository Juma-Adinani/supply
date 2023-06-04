<?php

class DatabaseDataSeeder
{
    public static function insertData()
    {
        $db = mysqli_connect('localhost', 'root', '', 'supply_chain_db');

        $data = [
            ['Adidas', 'Mkuu', 'Admin', '001', 1, 'admin@supply.com', password_hash('admin123', PASSWORD_DEFAULT)],
            ['John', 'Doe', 'Smith', '0712345678', 2, 'johndoe@gmail.com', password_hash('manager123', PASSWORD_DEFAULT)]
        ];

        foreach ($data as $row) {

            $firstname = $db->real_escape_string($row[0]);
            $middlename = $db->real_escape_string($row[1]);
            $lastname = $db->real_escape_string($row[2]);
            $phone = $db->real_escape_string($row[3]);
            $role_id = $db->real_escape_string($row[4]);
            $email = $db->real_escape_string($row[5]);
            $password = $db->real_escape_string($row[6]);

            $sql = "INSERT INTO users (firstname, middlename, lastname, phone, role_id, email, password) 
            VALUES ('$firstname', '$middlename', '$lastname', '$phone', '$role_id', '$email', '$password')";

            if ($db->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

        $db->close();
    }
}
