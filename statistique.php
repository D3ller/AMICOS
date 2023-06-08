<?php

session_start();

require_once('./assets/php/lib.php');

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){

} else {
    $_SESSION['error'] = 'Vous devez être connecté pour accéder à cette page.';
    header('Location: /connexion.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <title>Statistique</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php

    require_once('customnav.php');  

    $dbh = connect();

    $sql = "SELECT COUNT(*) AS total FROM trajet INNER JOIN passager ON trajet.conducteur_id = passager.user_id WHERE passager.user_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $_SESSION['AMIID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total'];
    
    echo "Vos avez réalise un total de ".$total." trajets.";


    $sql1 = "SELECT MONTH(date) AS mois, SUM(co2) AS total_co2 
    FROM trajet 
    WHERE conducteur_id = ? 
    GROUP BY mois";

$sql2 = "SELECT MONTH(t.date) AS mois, SUM(t.co2) AS total_co2 
    FROM trajet AS t
    INNER JOIN passager AS p ON t.id = p.trajet_id
    WHERE p.user_id = ?
    GROUP BY mois";

$stmt = $dbh->prepare($sql1);
$stmt->bind_param("i", $_SESSION['AMIID']);
$stmt->execute();
$result1 = $stmt->get_result();

$stmt = $dbh->prepare($sql2);
$stmt->bind_param("i", $_SESSION['AMIID']);
$stmt->execute();
$result2 = $stmt->get_result();

$labels = array();
$data = array();


setlocale(LC_TIME, 'fr_FR');

while ($row = $result1->fetch_assoc()) {
    $mois = $row['mois'];
    $totalCo2 = $row['total_co2'];

    $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

    $labels[] = ucfirst($moisNom);
    $data[] = $totalCo2;
}

while ($row = $result2->fetch_assoc()) {
    $mois = $row['mois'];
    $totalCo2 = $row['total_co2'];

    $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

    $index = array_search($moisNom, $labels);
    if ($index !== false) {
        $data[$index] += $totalCo2;
    } else {
        $labels[] = ucfirst($moisNom);
        $data[] = $totalCo2;
    }
}


?>
<canvas id="co2"></canvas>


<script>
    var ctx = document.getElementById('co2').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Total CO2 (en kg)',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: '#ffab02',
                borderColor: '#ffab02',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php

$sql1 = "SELECT MONTH(date) AS mois, SUM(km) AS total_km 
FROM trajet 
WHERE conducteur_id = ? 
GROUP BY mois";

$sql2 = "SELECT MONTH(t.date) AS mois, SUM(t.km) AS total_km
FROM trajet AS t
INNER JOIN passager AS p ON t.id = p.trajet_id
WHERE p.user_id = ?
GROUP BY mois";

$stmt = $dbh->prepare($sql1);
$stmt->bind_param("i", $_SESSION['AMIID']);
$stmt->execute();
$result1 = $stmt->get_result();

$stmt = $dbh->prepare($sql2);
$stmt->bind_param("i", $_SESSION['AMIID']);
$stmt->execute();
$result2 = $stmt->get_result();

$labels = array();
$data = array();


setlocale(LC_TIME, 'fr_FR');

while ($row = $result1->fetch_assoc()) {
$mois = $row['mois'];
$totalCo2 = $row['total_km'];

$moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

$labels[] = ucfirst($moisNom);
$data[] = $totalCo2;
}

while ($row = $result2->fetch_assoc()) {
$mois = $row['mois'];
$totalCo2 = $row['total_km'];

$moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

$index = array_search($moisNom, $labels);
if ($index !== false) {
    $data[$index] += $totalCo2;
} else {
    $labels[] = ucfirst($moisNom);
    $data[] = $totalCo2;
}
}


?>
<canvas id="km"></canvas>


<script>
var ctx = document.getElementById('km').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Total KM (en km)',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: '#ff6d13',
            borderColor: '#ff6d13',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


</body>
</html>