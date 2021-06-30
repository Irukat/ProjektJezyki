<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="mystyle.css" />

    <title>Artykuły</title>
</head>
<body class="container">
<?php
// Sprawdzamy czy użytkownik jest zalogowany
$islogged = !empty($_SESSION['uzytkownik']);

// Sprawdzamy czy użytkownik nie wcisnął przyciska "Wyloguj", sprawdzamy czy istnieje parametr logout w url
if (isset($_GET['logout'])) {
    // Jeśli tak to usuwamy użytkownika z sesji
    unset($_SESSION['uzytkownik']);
    // Ładujemy na nowo plik index.php
    header('Location: index.php');
}
// Wyświetlamy treść dostępną do zalogowanych użytkowników
if (isset($_SESSION['uzytkownik'])) {
    $uzytkownik = $_SESSION['uzytkownik'];
}

// Jeśli jest zalogowany wyświetlamy menu z przyciskiem dodaj nowy wpis oraz wyloguj
if ($islogged) {
        echo '<p id="nav">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#"><i class="bi bi-chat-square"></i>   A ty co opowiesz?</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php"></i> Strona główna</a>

            <li class="nav-item">
              <a class="nav-link" href="wpis.php""><i class="bi bi-pencil-square"></i></i> Dodaj wpis</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?logout=1"><i class="bi bi-box-arrow-right"></i></i> Wyolguj</a>
            </li>

          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="bi bi-search"></i>Search</button>
          </form>

        </div>
        </nav>
        </p>';

    } else {
      echo'<p id="nav">
      <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="#"><i class="bi bi-chat-square"></i>   A ty co opowiesz?</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php"></i> Strona główna</a>

          <li class="nav-item">
            <a class="nav-link" href="logowanie.php"><i class="bi bi-box-arrow-in-right"></i></i>Zaloguj</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="bi bi-search"></i>Search</button>
        </form>
      </div>
      </nav>
      </p>';

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


    // Zmienna decydująca o tym, czy użytkownik może edytować artykuł
    $can_edit = false;
    // Pobieramy wszystkie wpisy
    $result = $mysqli->query("SELECT id, tytul, zawartosc, loginid FROM wpisy");
    $wpisy = $result->fetch_all();
    foreach ($wpisy as $post) {
        $tytul = $post[1];
        $zawartosc = $post[2];
        $loginid = $post[3];
        $admin = 'admin';
        // jeżeli id zalogowanego użytkownika równa się id autora wpisu, to dajemy mu uprawnienia do edycji
        if (isset($uzytkownik) && $loginid === $uzytkownik['id']) {
            $can_edit = true;

        };
        if (isset($uzytkownik) && $admin === $uzytkownik['login']) {
            $can_edit = true;
        };


        // Jeśli jest autorem to dodajemy również przycisk do edycji i usunięcia
        if ($can_edit) {
            $buttons = '
                      <div class=" gap-2 d-md-flex justify-content-md-end">
                                <a href="wpis.php?id='.$post[0].'">
                               <button type="button" class="btn btn-primary">Edytuj</button>
                               </a>
                               <a href="usunwpis.php?id='.$post[0].'">
                               <button type="button" class="btn btn-danger me-md-2 d-md-flex">Usuń</button>
                                     </a>
        						 </div>';
        } else {
            $buttons = '';
        };
        //Wyświetlamy nazwę autora we wpisie
        $query = "SELECT `login` FROM `uzytkownicy` WHERE `id` = ".$loginid;
        $result = $mysqli->query($query);
        $result = $result->fetch_assoc();
        $nazwa = $result["login"];

        // Wyświetlamy wpis
        echo '

        <h2 class="display-4">'.$tytul.' </h2>
        <p class="lead">'.$zawartosc.'</p>

        <blockquote class="blockquote text-right">
        <p class="mb-0"></p>
        <footer class="blockquote-footer">'.$nazwa.'</footer>
        '.$buttons.'
        </blockquote>
      ';
        $can_edit = false;
    }
    ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
