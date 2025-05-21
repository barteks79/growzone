<?php
    $isEmail = isset($_POST['email']);
    $isPassword = isset($_POST['password']);

    if (!$isEmail || !$isPassword) {
        $errosParams = "?";

        if (!$isEmail) $errosParams .= "email=error&";
        if (!$isPassword) $errosParams .= "password=error";

        header("Location: ./index.php$errorParams");
        exit;
    }
?>