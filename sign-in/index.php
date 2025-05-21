<?php session_start(); ?>

<?php
    // walidacja danych (czy są uzupełnione)
    $isEmail = isset($_POST['email']);
    $isPassword = isset($_POST['password']);

    if (!$isEmail || !$isPassword) {
        $errosParams = "?";

        if (!$isEmail) $errosParams .= "email=empty&";
        if (!$isPassword) $errosParams .= "password=empty";

        header("Location: ./index.php$errorParams");
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

    $hashedPassword = $user['password'];
    $isPasswordCorrect = password_verify($password, $hashedPassword);
    
    if (!$isPasswordCorrect) {
        header("Location: ./index.php?password=incorrect");
        exit;
    }

    $_SESSION['user'] = $user;
    header("Location: ../home/index.php");
    exit;
?>