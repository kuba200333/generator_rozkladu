<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rozklad";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Połączenie nieudane: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCzasu = intval($_POST['id_czasu']);
    $czasPrzejazdu = $_POST['czas_przejazdu'];

    $sql = "UPDATE czasy_kursowania SET czas_przejazdu = '$czasPrzejazdu' WHERE id_czasu = $idCzasu";
    
    if (mysqli_query($conn, $sql)) {
        echo "Czas przejazdu zaktualizowany pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji: " . mysqli_error($conn);
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

mysqli_close($conn);
?>
