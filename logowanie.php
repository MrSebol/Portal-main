<?php
session_start();

$db = new mysqli('localhost', 'root', '', 'profile');
if ($db->connect_error) {
    die("Błąd połączenia z bazą danych: " . $db->connect_error);
}

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    $sql = "SELECT * FROM user WHERE email='$email' AND password='$haslo'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['login_user'] = $email;
        header("location: profile.php"); 
    } else {
        $error = "Nieprawidłowy email lub hasło";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz logowania</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="loginForm">
        <h2>Logowanie</h2>
        <form action="" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
            <label for="haslo">Hasło:</label><br>
            <input type="password" id="haslo" name="haslo"><br>
            <input type="submit" name="submit" value="Zaloguj">
        </form>
        <?php if(isset($error)) { echo $error; } ?>
    </div>
</body>
</html>