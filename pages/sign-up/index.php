<?php
session_start();
// require_once("conect.php");

?>
<!-- STRONA -->
<?php

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['password']) && isset($_POST['email'])) {

$pass = $_POST['password'];
$mail = $_POST['email'];


$result = $db_o->query("SELECT * FROM users WHERE email = '$mail'")->fetch_row();

if(isset($_POST['checkBox']) && $_POST['checkBox']){

    if ($pass === $_POST['passwordRepeat']) {

        if (!$result){
            
            $hasloHaszowane = password_hash($pass, PASSWORD_BCRYPT);

            $stmt = $db_o->prepare("INSERT INTO users VALUES (NULL, ?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "Użytkownik dodany pomyślnie!";
            } else {
                echo "<p>Błąd serwera!</p>"; //LESIAK DODAJ KOMUNIKAT :)
            }
            $stmt->close();

            
            // if(isset($_POST['submit'])) {
            //     echo '<script>window.location.href = "index.php"</script>';
            //     exit();
            // } Przekierowanie powrotowe, do dokończenia
        }
        else{
            echo "<p>Ten email jest już użyty!</p>"; //LESIAK DODAJ KOMUNIKAT :)
        }
    }
    else{
        echo "<p>Hasła nie są te same!</p>"; //LESIAK DODAJ KOMUNIKAT :)
    }
}
else{
    echo "<p>Odznaczenie jest obowiązkowe!</p>"; //LESIAK DODAJ KOMUNIKAT :)
}

mysqli_close($db_p);
$db_o->close();
}

?>