<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="mystyle.css" />

    <title>Strona logowania</title>

</head>
<body class="container">
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#"><i class="bi bi-chat-square"></i>   A ty co opowiesz?</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php"></i> Strona główna</a>
  </ul>

  </div>
  </nav>
<hr>
<hr>
<hr>
<div>
<h1 class="display-8">Zaloguj się</h1>

<!-- Formularz logowania -->
<form class="login-form" action="logowanie.php" method="post">
    <div class="form-group">
        <label for="loginInput">Login:</label>
        <input class="form-control" id="loginInput" type="text" name="login" /><br />
    </div>
    <div class="form-group">
        <label for="hasloInput">Hasło:</label>
        <input class="form-control" type="password" name="haslo" /><br />
    </div>
    <input type="submit" name="submit" class="btn btn-success" value="Login"
    <p>   Nie masz konta? <a href="rejestracja.php">Zarejstruj się</a>
</form>

<?php
// Sprawdzamy czy formularz został wysłany
if (isset($_POST['submit'])){

    // Dane do bazy danych
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password ='';
    $db_database ='blog';

    // Tworzymy i sprawdzamy nowe połączenie z bazą danych
    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);
    if($mysqli->connect_errno){
      die('Błąd połączenia z bazą danych');
    }

    // Pobieramy nazwe użytkownika i hasło
    $login = $_POST['login'];
    // zabezpieczamy hasło za pomocą sha1
    $haslo = sha1($_POST['haslo']);

    // Sprawdzamy czy w bazie istnieje użytkownik z takim loginem i hasłem
    $query = "SELECT id, login, email FROM uzytkownicy WHERE login LIKE '{$login}' AND haslo LIKE '{$haslo}' LIMIT 1";
    $result = $mysqli->query($query);

    if ($result->num_rows === 0) {
        echo '<p class="red">Zły login/hasło!</p>';
    } else {
        // Zapisujemy id użytkownika do sesji co pozwoli nam potem sprawdzić czy użytkownik jest zalogowany
        $uzytkownik = $result->fetch_array();
        $_SESSION['uzytkownik'] = $uzytkownik;
        header('Location: index.php');
    }
}
?>
</div>
</body>
</html>
