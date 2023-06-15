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
    


<main>

    <img src="https://portfolio.karibsen.fr/assets/img/rosetext.svg" alt="Logo">

    <h1>Dashboard :</h1>

    <div class="block1">
        <div class="nbutil-admin">
            <?php

            $dbh = connect();

            $sql = "SELECT COUNT(*) AS nombre_utilisateurs FROM profil";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $nombreUtilisateurs = $row['nombre_utilisateurs'];

            echo "<p>Nombre d'utilisateurs :</p>";
            echo "<p>".$nombreUtilisateurs." utilisateurs</p>";

            ?>


        </div>

        <div class="co2-admin">

        <?php

        $sql = "SELECT SUM(co2) AS co2 FROM trajet";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $co2 = $row['co2'];
        echo "<p>CO2 économisé :</p>";
        echo "<p>".$co2." kg</p"
        ?>            
        </div>
    </div>
    </div>

    <div class="block2">

    <h3>Nombre de trajets réalisés :</h3>
    <canvas id="nomnbretrajet"></canvas>


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
        <div id="derniers-trajet-admin">

            <?php

            $sql = "SELECT * FROM trajet ORDER BY `id` DESC LIMIT 2";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Derniers trajets :</h3>";


            echo '<div class="trajet-pack-admin">';
            while ($row = $result->fetch_assoc()) {

                $sql = "SELECT * FROM profil WHERE id = ?";
                $stmt2 = $dbh->prepare($sql);
                $stmt2->bind_param("i", $row['conducteur_id']);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();

                echo '<div class="trajet-indiv-admin">';
                echo "<p>".$row['date']." - ".$row['co2']." kg</p>";
                echo $row2['prenom']." ".$row2['nom'];
                echo '</div>';   
            }
            echo '</div>';

            ?>

        </div>

        <div id="link">
            <a href="./g_user.php">Gérer les utilisateurs</a>
            <a href="./g_trajet.php">Gérer les trajets</a>
            <a href="./g_parking.php">Gérer les parkings</a>
        </div>
    </div>

</main>

</body>
</html>

<body>