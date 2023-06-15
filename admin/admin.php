<?php

session_start();

require_once('../assets/php/lib.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Administration</title>
</head>
<body>
    
</body>

<main>

    <img src="https://portfolio.karibsen.fr/assets/img/rosetext.svg" alt="Logo">

    <h1>Dashboard :</h1>

    <div class="block1">
        <div class="nbutil-admin">

        </div>

        <div class="co2-admin">
            
        </div>
    </div>

    <div class="block2">

    <h3>Nombre de trajets réalisés :</h3>
    <canvas id="nomnbretrajet"></canvas>

    
        <?php
        $dbh = connect();

        ?>

        <?php


        $sql = "SELECT DATE(`date`) AS jour, COUNT(*) AS nombre_trajets FROM trajet GROUP BY jour";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $jours = array();
        $nombreTrajets = array();
        while ($row = $result->fetch_assoc()) {
            $jours[] = $row['jour'];
            $nombreTrajets[] = $row['nombre_trajets'];
        }
        ?>

        <script>
            var donnees = {
                labels: <?php echo json_encode($jours); ?>,
                datasets: [{
                    label: 'Nombre de Trajets',
                    data: <?php echo json_encode($nombreTrajets); ?>,
                    backgroundColor: 'rgba(0, 0, 255, 0.5)',
                    borderColor: 'rgba(0, 0, 255, 1)',
                    borderWidth: 1,
                }]
            };

            var options = {
                responsive: false, // Désactive la mise à l'échelle automatique
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            };

            var ctx = document.getElementById('nomnbretrajet').getContext('2d');
            var graphique = new Chart(ctx, {
                type: 'bar',
                data: donnees,
                options: options
            });
        </script>

    </div>

    <div class="block3">
        <div class="derniers-trajet-admin">

        </div>

        <div>
            <a href="./g_user.php">Gérer les utilisateurs</a>
            <a href="./g_trajet.php">Gérer les trajets</a>
            <a href="./g_parking.php">Gérer les parkings</a>
        </div>
    </div>

</main>

</html>

<body>