<?php
session_start();

if (!empty($_SESSION['uzytkownik'])) {

  $db_host = 'localhost';
  $db_username = 'root';
  $db_password ='';
  $db_database ='blog';

  $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);
  if($mysqli->connect_errno){
    die('Błąd połączenia z bazą danych');
  }

    $uzytkownik = $_SESSION['uzytkownik'];
    if (empty($uzytkownik)) {

        require_once __DIR__ . '\logowanie.php';
    } elseif (isset($_GET['id'])) {

        $query = "DELETE FROM wpisy WHERE `id`='{$_GET['id']}';";

        if ($mysqli->query($query)) {
            header('Location: index.php');
        } else {
          echo "<p class='red'>Błąd podczas usuwania wpisy: {$mysqli->error}</p>";

        }
    } $mysqli->close();
}
