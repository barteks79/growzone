<?php session_start(); ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

    // walidacja danych (czy są uzupełnione)
    $is_email = isset($_POST['email']);
    $is_password = isset($_POST['password']);

    if (!$is_email || !$is_password) {
        $error_params = "?";

        if (!$is_email) $error_params .= "email=empty&";
        if (!$is_password) $error_params .= "password=empty";

        header("Location: ./index.php$error_params");
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = [
        "email" => "test@gmail.com",
        "password" => "32de32nsadyu2jsnadjkhas-sdad2@E3"
    ];

    // walidacja usera
    if (!$user) {
        header("Location: ./index.php?email=notfound");
        exit;
    }

    $hashed_password = $user['password'];
    $is_password_correct = password_verify($password, $hashed_password);
    
    if (!$is_password_correct) {
        header("Location: ./index.php?password=incorrect");
        exit;
    }

    $_SESSION['user'] = $user;
    header("Location: ../home/index.php");
    exit;
?>