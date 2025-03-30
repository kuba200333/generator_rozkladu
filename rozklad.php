
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['typ'] = @$_POST['typ'];
}

$selected_typ = isset($_SESSION['typ']) ? $_SESSION['typ'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozkład</title>
    <style>
        *{
            font-size: 15px;
            background-color: white;
            color: black;
            margin: 0;
            padding: 0;

        }
        body{
            padding: 10px;
        }
        table{
            border-collapse: collapse; 
            width: 20%;
        }
        td, th{
            border: 1px solid black;
            padding: 2px;
        }
        tr{
            height: 1px;
        }
        tr:hover{
            background-color: coral;
        }
        table input, table select{
            text-align: center;
            border: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

        }
        #postoj{
            font-weight: bold;
        }
   

    </style>
</head>
<body>
    <a href="index.php">Powrót do menu</a><br><br>
    <form action="" method="POST">
        Wybierz typ pociągu: &nbsp
        <?php
            $polaczenie=mysqli_connect("localhost","root","","stacje");
            $zapytanie="SELECT * FROM typ_pociagow";
            $wyslij=mysqli_query($polaczenie,$zapytanie);

            echo "<select name='typ'>";
            echo "<option>".""."</option>";
            while ($row=mysqli_fetch_array($wyslij)){
                echo "<option>".$row['skrot']."</option>";
            }
            echo "</select><br>";
        ?>
        
        Wpisz numer pociagu: &nbsp<input type="number" name="nr_poc"><br>
        Wybierz godzinę odjazdu: &nbsp<input onchange="this.form.submit()" type="time" name="czas"><br><br>
    </form>

    <?php 
    $trasa=$_GET['id_trasy'];
    
    $polaczenie=mysqli_connect("localhost","root","","rozklad");
    $zapytanie1="SELECT st.nazwa_stacji FROM trasy tr inner join stacje st on st.id_stacji=tr.id_stacji_poczatkowej inner join stacje st2 on st2.id_stacji=tr.id_stacji_koncowej where id_trasy=$trasa;";
    $wyslij1=mysqli_query($polaczenie,$zapytanie1);      

    while ($row1=mysqli_fetch_array($wyslij1)){
        $st_pocz=$row1['nazwa_stacji'];
    }

    $zapytanie2="SELECT st2.nazwa_stacji FROM trasy tr inner join stacje st on st.id_stacji=tr.id_stacji_poczatkowej inner join stacje st2 on st2.id_stacji=tr.id_stacji_koncowej where id_trasy=$trasa;";
    $wyslij2=mysqli_query($polaczenie,$zapytanie2);      

    while ($row2=mysqli_fetch_array($wyslij2)){
        $st_konc=$row2['nazwa_stacji'];
    }
    $polaczenie=mysqli_connect("localhost","root","","stacje");
   

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        $_SESSION["postoje"] = [];
        $_SESSION["typy"] = [];
        $_SESSION["typ"] = [];
        $_SESSION["nr_poc"] = [];

    }
    if (isset($_POST["czas"])) {
        $_SESSION["typ"] =$_POST['typ'];
        $_SESSION["nr_poc"] = $_POST['nr_poc'];

    }
    if(isset($_POST['typ'])){
        echo"<b>";
          Print_r(@$_SESSION['typ']);
        echo " ";
        Print_r(@$_SESSION['nr_poc']);
        echo"</b>";
    }
  
    echo" <b>Relacja: ".$st_pocz." - ".$st_konc."</b>";
    
    $polaczenie=mysqli_connect("localhost","root","","rozklad");
    #$zapytanie3="SELECT s.id_stacji AS id_stacji, s.nazwa_stacji AS nazwa_stacji, ts.id_typu_stacji as id_typ_st, ts.skrot_typu_stacji AS typ, sn.kolejnosc as kolejnosc, s.uwagi AS Uwagi, SEC_TO_TIME(SUM(TIME_TO_SEC(ck.czas_przejazdu))) AS czas, ck.predkosc AS predkosc FROM stacje_na_trasie sn JOIN stacje s ON sn.id_stacji = s.id_stacji JOIN typy_stacji ts ON s.typ_stacji_id = ts.id_typu_stacji LEFT JOIN czasy_kursowania ck ON sn.id_trasy = ck.id_trasy AND sn.id_stacji = ck.id_stacji_początkowej WHERE sn.id_trasy = $trasa GROUP BY s.id_stacji, s.nazwa_stacji, ts.nazwa_typu_stacji, s.uwagi ORDER BY sn.kolejnosc;";
    $zapytanie3="SELECT s.id_stacji AS id_stacji, s.nazwa_stacji AS nazwa_stacji, ts.id_typu_stacji AS id_typ_st, ts.skrot_typu_stacji AS typ, sn.kolejnosc AS kolejnosc, s.uwagi AS Uwagi, SEC_TO_TIME(SUM(TIME_TO_SEC(ck.czas_przejazdu))) AS czas, ps.predkosc AS predkosc FROM stacje_na_trasie sn JOIN stacje s ON sn.id_stacji = s.id_stacji JOIN typy_stacji ts ON s.typ_stacji_id = ts.id_typu_stacji LEFT JOIN czasy_kursowania ck ON sn.id_trasy = ck.id_trasy AND sn.id_stacji = ck.id_stacji_początkowej LEFT JOIN predkosci_stacje ps ON sn.id_stacji = ps.id_stacji_początkowej AND ck.id_stacji_końcowej = ps.id_stacji_końcowej WHERE sn.id_trasy = $trasa GROUP BY s.id_stacji, s.nazwa_stacji, ts.id_typu_stacji, ts.skrot_typu_stacji, sn.kolejnosc, s.uwagi ORDER BY sn.kolejnosc;";
    #echo $zapytanie3;
    $wyslij3=mysqli_query($polaczenie,$zapytanie3);
    /*echo "Godzina odjazdu: &nbsp".@$_POST['czas'];*/
    echo "<form action='' method='POST'>"."<table>";
    echo "<tr style='text-align: center'>"."".""."<th colspan='2'>"."Stacja"."</th>"."<th>Vmax</th>"/*."Typ <br> post."*/."<th>"."Godzina"."</th>".
    "<th>"."Czas <br> post. "."</th>"./*"<th>"."Odjazd"."</th>".*/"</tr>";
    
    $postojDefault = "00:00:30";
    $typDefault = "ph";
    if (isset($_POST["czas"])) {
        $_SESSION["czas"] = $_POST["czas"];
    }
    $godzina = (int)strtotime(@$_SESSION["czas"]);
    $i = 0;
    while ($row3=mysqli_fetch_array($wyslij3)){
        if (!isset($_POST["postoj".$row3['id_stacji']])) {
            $_SESSION["postoje"][$i] = $postojDefault;
        }else {
            $_SESSION["postoje"][$i] = $_POST["postoj".$row3["id_stacji"]];
        }


        if (!isset($_POST["typPostoj".$row3['id_stacji']])) {
            $_SESSION["typy"][$i] = $typDefault;
        }else {
            $_SESSION["typy"][$i] = $_POST["typPostoj".$row3["id_stacji"]];
        }


        $temp = (int)strtotime("00:00");
        $delay = (int)strtotime($row3["czas"]);
        $postoj=(int)strtotime($_SESSION["postoje"][$i])-$temp;
        if ($row3["id_typ_st"]==3 or $row3["id_typ_st"]==4 or $row3["kolejnosc"]=="1" or $row3["kolejnosc"]==mysqli_num_rows($wyslij3) or empty($_SESSION["typy"][$i])) {
            $postoj=0;
        }
        
        if (empty($_SESSION["typy"][$i])&&($row3["id_typ_st"]==1 || $row3["id_typ_st"]==2 || $row3["kolejnosc"]==1 || $row3["kolejnosc"]==mysqli_num_rows($wyslij3))) {
            $postoj = 0; // Czas w sekundach
        } 

        $czas = $delay - $temp;

        


        $odjazd = date("H:i", $godzina+$postoj);
        $przyjazd= date("H:i", $godzina);

        echo "<tr>"."<td colspan='2'><b>".$row3['nazwa_stacji']."</b>&nbsp".$row3['typ'];
        $zapytanie4="SELECT * FROM postoje";
        $wyslij4=mysqli_query($polaczenie,$zapytanie4);
        echo "&nbsp<select id='postoj' onchange='this.form.submit()' name='typPostoj".$row3["id_stacji"]."'><option>".""."</option>";
        while ($row4=mysqli_fetch_array($wyslij4)){
            if($row3['id_typ_st']==3 or $row3['id_typ_st']==4 or $row3["kolejnosc"]=="1" or $row3["kolejnosc"]==mysqli_num_rows($wyslij3) ){
                
            }
                else{
                if ($row4['typ_postoj']==$_SESSION["typy"][$i]) {
                    echo "<option selected>".$row4['typ_postoj']."</option>";
                }else {
                    echo "<option>".$row4['typ_postoj']."</option>";
                }
            }
            
        }
        echo "</select><br>";
        echo"<br>".$row3['Uwagi']."</td>"."";
      

        echo "<td style='text-align: center'>".$row3['predkosc']."</td>";
        /*echo"<td style='text-align: center'>";
        $zapytanie4="SELECT * FROM postoje";
        $wyslij4=mysqli_query($polaczenie,$zapytanie4);
        echo "<select onchange='this.form.submit()' name='typPostoj".$row3["id_stacji"]."'><option>".""."</option>";
        while ($row4=mysqli_fetch_array($wyslij4)){
            if($row3['id_typ_st']==3 or $row3['id_typ_st']==4 or $row3["kolejnosc"]=="1" or $row3["kolejnosc"]==mysqli_num_rows($wyslij3) ){
                
            }
                else{
                if ($row4['typ_postoj']==$_SESSION["typy"][$i]) {
                    echo "<option selected>".$row4['typ_postoj']."</option>";
                }else {
                    echo "<option>".$row4['typ_postoj']."</option>";
                }
            }
            
        }
        echo "</select><br>";

        echo "</td>";*/
        

        echo"<td style='text-align: center'>";
        if ($row3["kolejnosc"]=="1") {
            echo "|<br>";
            echo $odjazd;
        }else if($row3["kolejnosc"]==mysqli_num_rows($wyslij3)) {
            echo $przyjazd;
            echo "<br>|";

        }else{
            if($row3["id_typ_st"]==3 or $row3["id_typ_st"]==4 or empty($_SESSION["typy"][$i])){
                echo "|<br>";
                echo $odjazd;
            }else{
                echo $przyjazd;
                echo "<br>";
                echo $odjazd; 
            }

        }
        echo"<td style='text-align: center'>";
        if ($row3["id_typ_st"]==3 or $row3["id_typ_st"]==4 or $row3["kolejnosc"]=="1" or $row3["kolejnosc"]==mysqli_num_rows($wyslij3) or empty($_SESSION["typy"][$i])) {
            echo "|";
        }else {
            echo "<input onchange='this.form.submit()' type='text' name='postoj".$row3['id_stacji']."' style='width: 60px' value='".$_SESSION["postoje"][$i]."'";
        }
        echo "</td>";
       /* echo "</td>"."<td style='text-align: center'>";

        if ($row3["kolejnosc"]==mysqli_num_rows($wyslij3)) {
            echo "|";
        }else {
            echo $odjazd;
        }
*/
        echo "</td>"."</tr>";

        $godzina+=$postoj+$czas;
        $i++;
    }
    echo "</form>"."</table>";
?>

<script>
    // Save scroll position in localStorage before the page is unloaded
    window.onbeforeunload = function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    };

    // Restore scroll position when the page loads
    window.onload = function() {
        if (localStorage.getItem('scrollPosition') !== null) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        }
    };
</script>
</body>
</html>