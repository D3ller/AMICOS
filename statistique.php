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
    <link type='text/css' rel='stylesheet' href='/assets/css/statistique.css'>
    <title>Statistique</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php

    require_once('customnav.php');  

    $dbh = connect();

    $sql = "SELECT 
    (SELECT COUNT(*) FROM trajet WHERE conducteur_id = ? AND date < CURRENT_DATE()) AS occurrences_trajet,
    (SELECT COUNT(*) FROM passager WHERE user_id = ?) AS occurrences_passager,
    (SELECT COUNT(*) FROM trajet WHERE conducteur_id = ? AND date < CURRENT_DATE()) + (SELECT COUNT(*) FROM passager WHERE user_id = ?) AS total_occurrences;";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("iiii", $_SESSION['AMIID'], $_SESSION['AMIID'], $_SESSION['AMIID'], $_SESSION['AMIID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total_occurrences'];
    
    echo "<p id='stats'>Vous avez réalise un total de ".$total." trajets.</p>";


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
    
    $co2ByMonth = array();
    
    setlocale(LC_TIME, 'fr_FR');
    
    while ($row = $result1->fetch_assoc()) {
        $mois = $row['mois'];
        $totalCo2 = $row['total_co2'];
    
        $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));
    
        $co2ByMonth[$moisNom] = $totalCo2;
    }
    
    while ($row = $result2->fetch_assoc()) {
        $mois = $row['mois'];
        $totalCo2 = $row['total_co2'];
    
        $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));
    
        if (array_key_exists($moisNom, $co2ByMonth)) {
            $co2ByMonth[$moisNom] += $totalCo2;
        } else {
            $co2ByMonth[$moisNom] = $totalCo2;
        }
    }
    
    $labels = array_keys($co2ByMonth);
    $data = array_values($co2ByMonth);
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

$kmByMonth = array();

setlocale(LC_TIME, 'fr_FR');

while ($row = $result1->fetch_assoc()) {
    $mois = $row['mois'];
    $totalKm = $row['total_km'];

    $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

    $kmByMonth[$moisNom] = $totalKm;
}

while ($row = $result2->fetch_assoc()) {
    $mois = $row['mois'];
    $totalKm = $row['total_km'];

    $moisNom = strftime("%B", mktime(0, 0, 0, $mois, 1));

    if (array_key_exists($moisNom, $kmByMonth)) {
        $kmByMonth[$moisNom] += $totalKm;
    } else {
        $kmByMonth[$moisNom] = $totalKm;
    }
}

$labels = array_keys($kmByMonth);
$data = array_values($kmByMonth);
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