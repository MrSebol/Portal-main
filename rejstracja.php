<?php
session_start();

$db = new mysqli('localhost', 'root', '', 'profile');
if ($db->connect_error) {
    die("Błąd połączenia z bazą danych: " . $db->connect_error);
}

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];

    $sql_user = "INSERT INTO user (email, password) VALUES ('$email', '$haslo')";

    if ($db->query($sql_user) === TRUE) {
     
        $last_id = $db->insert_id;
        
        
        $sql_profile = "INSERT INTO profile (ID, firstName, lastName, profilePhotoID, description) VALUES ('$last_id', '$imie', '$nazwisko', 0, '')";
        if ($db->query($sql_profile) === TRUE) {
          
            $_SESSION['login_user'] = $email;

            header("location: profile.php");
            exit(); 
        } else {
            $error = "Błąd podczas tworzenia profilu użytkownika: " . $db->error;
        }
    } else {
        $error = "Błąd podczas rejestracji użytkownika: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz rejestracji</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div id="registerForm">
        <h2>Rejestracja</h2>
        <form action="" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="haslo">Hasło:</label><br>
            <input type="password" id="haslo" name="haslo" required><br>
            <label for="imie">Imię:</label><br>
            <input type="text" id="imie" name="imie" required><br>
            <label for="nazwisko">Nazwisko:</label><br>
            <input type="text" id="nazwisko" name="nazwisko" required><br>
            <input type="submit" name="submit" value="Zarejestruj">
        </form>
        <?php if(isset($error)) { echo $error; } ?>
    </div>
</body>
</html>