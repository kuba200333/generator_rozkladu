<?php
// Konfiguracja połączenia z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rozklad";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Połączenie nieudane: " . mysqli_connect_error());
}

// Pobieranie wartości z parametrów URL lub ustawienie domyślnych
$idStacjiPocz = isset($_GET['id_stacji_początkowej']) ? $_GET['id_stacji_początkowej'] : '';
$idStacjiKonc = isset($_GET['id_stacji_końcowej']) ? $_GET['id_stacji_końcowej'] : '';
$idTrasy = isset($_GET['id_trasy']) ? $_GET['id_trasy'] : '';

// Sprawdzenie, czy przycisk "Następny" został naciśnięty
if (isset($_GET['next'])) {
    $idStacjiPocz++;
    $idStacjiKonc++;
}

// Sprawdzenie, czy przycisk "Odwróć" został naciśnięty
if (isset($_GET['reverse'])) {
    $temp = $idStacjiPocz;
    $idStacjiPocz = $idStacjiKonc;
    $idStacjiKonc = $temp;
}

// Tworzymy zapytanie z połączeniami do tabel `stacje`, `trasy` oraz `stacje_na_trasie`, aby sortować według kolejności
$sql = "
    SELECT 
        czasy_kursowania.id_czasu,
        trasy.nazwa_trasy,
        stacje_poczatkowa.nazwa_stacji AS stacja_poczatkowa,
        stacje_koncowa.nazwa_stacji AS stacja_koncowa,
        czasy_kursowania.czas_przejazdu
    FROM czasy_kursowania
    LEFT JOIN trasy ON czasy_kursowania.id_trasy = trasy.id_trasy
    LEFT JOIN stacje AS stacje_poczatkowa ON czasy_kursowania.id_stacji_początkowej = stacje_poczatkowa.id_stacji
    LEFT JOIN stacje AS stacje_koncowa ON czasy_kursowania.id_stacji_końcowej = stacje_koncowa.id_stacji
    LEFT JOIN stacje_na_trasie ON czasy_kursowania.id_trasy = stacje_na_trasie.id_trasy 
        AND czasy_kursowania.id_stacji_początkowej = stacje_na_trasie.id_stacji
    WHERE 1=1
";

if ($idStacjiPocz) {
    $sql .= " AND czasy_kursowania.id_stacji_początkowej = " . intval($idStacjiPocz);
}
if ($idStacjiKonc) {
    $sql .= " AND czasy_kursowania.id_stacji_końcowej = " . intval($idStacjiKonc);
}
if ($idTrasy) {
    $sql .= " AND czasy_kursowania.id_trasy = " . intval($idTrasy);
}

$sql .= " ORDER BY stacje_na_trasie.kolejnosc ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Podgląd i edycja czasu przejazdu</title>
    <style>
        table{
            border-collapse: collapse;
        }
        td{
            padding: 2px;
        }
    </style>
</head>
<body>
    <h2>Filtruj trasy</h2>
    <form method="GET">
        <label for="id_stacji_początkowej">ID Stacji Początkowej:</label>
        <input type="number" name="id_stacji_początkowej" id="id_stacji_początkowej" value="<?php echo htmlspecialchars($idStacjiPocz); ?>">
        
        <label for="id_stacji_końcowej">ID Stacji Końcowej:</label>
        <input type="number" name="id_stacji_końcowej" id="id_stacji_końcowej" value="<?php echo htmlspecialchars($idStacjiKonc); ?>">
        
        <label for="id_trasy">ID Trasy:</label>
        <input type="number" name="id_trasy" id="id_trasy" value="<?php echo htmlspecialchars($idTrasy); ?>">

        <button type="submit">Filtruj</button>
        <button type="submit" name="next" value="1">Następny</button>
        <button type="submit" name="reverse" value="1">Odwróć</button>
    </form>

    <h2>Lista tras i czasów przejazdu</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nazwa Trasy</th>
            <th>Stacja Początkowa</th>
            <th>Stacja Końcowa</th>
            <th>Czas Przejazdu</th>
            <th>Akcja</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($result)): ?>
            <tr>
                <form method="POST" action="update.php">
                    <td><?php echo $row['id_czasu']; ?></td>
                    <td><?php echo htmlspecialchars($row['nazwa_trasy']); ?></td>
                    <td><?php echo htmlspecialchars($row['stacja_poczatkowa']); ?></td>
                    <td><?php echo htmlspecialchars($row['stacja_koncowa']); ?></td>
                    <td>
                        <input type="text" name="czas_przejazdu" value="<?php echo date('H:i:s', strtotime($row['czas_przejazdu'])); ?>" pattern="\d{2}:\d{2}:\d{2}">
                        <input type="hidden" name="id_czasu" value="<?php echo $row['id_czasu']; ?>">
                    </td>
                    <td><button type="submit">Zapisz</button></td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
mysqli_close($conn);
?>
