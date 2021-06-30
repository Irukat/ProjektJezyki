<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="mystyle.css" />

    <title>Formularz wpisu</title>
</head>
<body>
<?php
if (!empty($_SESSION['uzytkownik'])) {
    // Sprawdzamy czy użytkownik nie wcisnął przyciska "Wyloguj", sprawdzamy czy istnieje parametr logout w url
    if (isset($_GET['logout'])) {
        // Jeśli tak to usuwamy użytkownika z sesji
        unset($_SESSION['uzytkownik']);
        // Ładujemy na nowo plik index.php
        header('Location: index.php');
    }

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

    $uzytkownik = $_SESSION['uzytkownik'];
    if (isset($_POST['submit'])) {
        // Pobieramy pobieramy dane z formularza do zmienych
        $wpisid = $_POST['wpisid'];
        $tytul	 = $_POST['tytul'];
        $zawartosc = $_POST['zawartosc'];
        $loginid = $uzytkownik['id'];

        if (!empty($wpisid)) {
                    // Jeżeli mamy podane id wpisy to je nadpisujemy
                    $sql = "UPDATE wpisy SET tytul='{$tytul}', zawartosc='{$zawartosc}' WHERE id='{$wpisid}';";
                } else {
                    // Dadajemy wpis do bazy
                    $sql = "INSERT INTO `wpisy`(`id`, `tytul`, `zawartosc`, `loginid`) VALUES (NULL, '".$tytul."', '".$zawartosc."', '".$loginid."')";
                  }
        if ($mysqli->query($sql)) {
            // Jeżeli brak błędów to idziemy do strony głównej
            header('Location: index.php');
        } else {
            // Jeśli coś poszło nie to wyśiwetlamy błąd?
            echo "<p class='red' '>Błąd podczas dodawania ogłoszenia: {$mysqli->connect_error}</p>";
        }

    } else {
      // Jeśli mamy podane id (edycja) pobieramy dane wpisu
       if (isset($_GET['id'])) {
           $wpisid = $_GET['id'];
           $result = $mysqli->query("SELECT * FROM wpisy WHERE id='{$wpisid}' LIMIT 1");
           $wpis = $result->fetch_array();

           $tytul = $wpis['tytul'];
           $zawartosc = $wpis['zawartosc'];
       } else {
           $wpisid = $tytul = $zawartosc = '';
       }

        // Wyświetlamy menu i formularz, wypełniamy danymi jeśli edytujemy wpis
        echo ' <p id="nav">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#"><i class="bi bi-chat-square"></i>    A ty co opowiesz?</a>
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
      </p>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="submit-form container" action="wpis.php" method="post">
                <input class="form-control" name="wpisid" type="hidden" value="'.$wpisid.'"/>
                <div class="form-group col-md-11">
                    <label for="tytul">Nagłówek:</label>
                    <input class=" form-control" id="tytul" type="text" name="tytul" value="'.$tytul.'"/>
                </div>
                <div class="form-group col-md-11">
                    <label for="zawartosct">Tekst:</label>
                    <textarea class="form-control" name="zawartosc">'.$zawartosc.'</textarea>
                </div>
                <div class="col-md-10">
                    <input type="submit" name="submit" class="btn btn-success" value="Zapisz" />
                </div>
            </form>
        </div>
    </div>
</div>
        ';
    }
} else {
    // Jeżeli użytkownik nie jest zalogowany wysyłamy go do logowania
    require_once __DIR__. '\logowanie.php';
}
?>
</body>
</html>
