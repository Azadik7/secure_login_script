<?php

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start();

if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p'];
    if (login($email, $password, $mysqli) == true) {
        header("Location: ../protected_page.php");
        exit();
    } else {
        header('Location: ../login.php?error=1');
        exit();
    }
} else {
    header('Location: ../error.php?err=Could not process login');
    exit();
}