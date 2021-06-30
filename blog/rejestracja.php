<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="mystyle.css" />

    <title>Formularz rejestracji</title>

</head>
<body class="container">

 <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">A ty co opowiesz?</a>
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
      <!-- Formularz rejestracja -->
    <h1 class="display-4" >Rejstracja</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="form-group">
            <label for="loginInput">Login:</label>
            <input id="loginInput"  class="form-control" type="text" name="login" />
        </div>
        <div class="form-group">
            <label for="hasloInput">Hasło:</label>
            <input id="hasloInput" class="form-control" type="password" name="haslo" />
        </div>
        <div class="form-group">
            <label for="emailInput">Email:</label>
            <input id="emailInput" class="form-control" type="text" name="email" />
        </div>
        <input type="submit" class="btn btn-success" name="submit" value="Register"
        <p>    Masz już konto? <a href="logowanie.php">Zaloguj się!</a>
    </form>

    <?php
    if (isset($_POST['submit'])) {

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

        // Pobieramy pobieramy dane z formularza do zmienych
        $login	= $_POST['login'];
        // Zabezpieczamy hasło
        $haslo	= sha1($_POST['haslo']);
        $email	= $_POST['email'];

        // Sprawdzamy czy hasło, login i email nie są puste
        if (empty($login) || empty($haslo) || empty($email)) {
            echo '<p class="red">Login, hasło i email są wymagane</p>';

        } else {
            $isLoginTaken = false;
            $isEmailTaken = false;
            // Sprawdzamy czy użytkownik z taki loginem już istnieje
            $result = $mysqli->query("SELECT login from uzytkownicy WHERE login = '{$login}' LIMIT 1");
            if ($result->num_rows == 1) {
                $isLoginTaken = true;
            }
            // Sprawdzamy czy użytkownik z takim emailem już nie istnieje
            $result = $mysqli->query("SELECT email from uzytkownicy WHERE email = '{$email}' LIMIT 1");
            if ($result->num_rows == 1) {
                $isEmailTaken = true;
            }

            if ($isLoginTaken && $isEmailTaken) {
                echo '<p class="red">Konto już istnieje!</p>';
            } elseif($isLoginTaken) {
                echo '<p class="red">Nazwa użytkownika jest zajęta!</p>';
            } elseif ($isEmailTaken) {
                echo '<p class="red">Adres email jest zajęty!</p>';
            } else {
                // Jeżeli nie ma błędu to dodajemy użytkownika
                $query = "INSERT INTO `uzytkownicy`(`login`, `haslo`, `email`) VALUES ('".$login."', '".$haslo."', '".$email."')";

                if ($mysqli->query($query)) {
                    // Jeżeli brak błędów to idziemy do logowania
                    header('Location: index.php');
                } else {
                    // Jeśli coś poszło nie to wyśiwetlamy błąd
                    echo "<p class='red' '>Błąd podczas dodawania użytkownika: {$mysqli->connect_error}</p>";
                }
                $mysqli->close();
            }

        }
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
