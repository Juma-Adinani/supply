<?php
include './utils/Utils.php';
session_start();
session_destroy();

Util::redirectTo('login.php');
