<?php
include './partials/_head_tag.php';
include './config/database_connection.php';
session_start();
include './controllers/AuthController.php';
include './controllers/DashboardController.php';
include './helpers/Helper.php';
include './utils/Utils.php';
