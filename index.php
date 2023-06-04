<?php

require_once './seeders/seeder.php';

try {
    DatabaseDataSeeder::insertData();
    header("location:./homepage.php");
} catch (\Exception $e) {
    header("location:./homepage.php");
}
