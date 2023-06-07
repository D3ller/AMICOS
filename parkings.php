<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/parkings.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <title>Document</title>
</head>
<body>
    <?php

require_once 'customnav.php';

require_once './assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM parking";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$num_results = $result->num_rows;

if($num_results == 0) {
echo '<div id="noparkings">';
echo '<div id="badnews"></div>';
echo '<p id="noparking">Aucun parking disponible</p>';
echo '</div>';
exit();
} 

echo '<p id="pk">Parking disponible ('.$num_results.')</p>';
echo '<div id="parking">';

while($row = $result->fetch_assoc()) {


    echo '<div class="maps">';
    echo "<p class='title'>{$row['name']}</p>";
    echo '<a href="https://www.google.com/maps?q='.$row['lat'].','.$row['lng'].'"><div class="more"></div></a>';
    echo '</div>';

}

echo '</div>';





?>
</body>
</html>