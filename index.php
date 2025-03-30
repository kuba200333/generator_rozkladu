<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator rozkładu</title>
    <style>
        *{
            background-color: #3F3F3F;
            color: white;
        }
        table{
            border: 1px solid white;
            border-collapse: collapse;
        }
        td{
            border: 1px solid white;
            border-collapse: collapse;
            height: 50px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <h1> Generator rozkładu jazdy</h1>

    <table>
        <tr><td style="text-align:center">lp.</td><td style="text-align:center">Trasa</td></tr>
        <?php
            $polaczenie = mysqli_connect("localhost", "root", "", "rozklad");
            $sql="SELECT * FROM `trasy` order by nazwa_trasy asc";
            $send=mysqli_query($polaczenie, $sql);
            $x=1;
            while($row=mysqli_fetch_array($send)){
                echo "<tr><td>".$x++."</td><td style='text-align:left;'><a href='rozklad.php?id_trasy=".$row[0]."'>".$row[1]."</a></td></tr>";
            }
        ?>
    </table>
</body>
</html>
