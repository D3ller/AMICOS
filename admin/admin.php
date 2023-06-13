<?php

session_start();

require_once('../assets/php/lib.php');

echo '<a href="./g_user.php">Gérer les utilisateurs</a>';
echo '<br>';
echo '<a href="./g_trajet.php">Gérer les trajets</a>';
echo '<br>';
echo '<a href="./g_parking.php">Gérer les parkings</a>';




?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    
  <canvas id="graphique"></canvas>
  <canvas id="co2"></canvas>
  <canvas id="nomnbretrajet"></canvas>





  
  <?php
$dbh = connect();

$sql = "SELECT `groups`, COUNT(*) AS num_rows FROM profil GROUP BY `groups`";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$groupes = array();
while ($row = $result->fetch_assoc()) {
    $groupes[$row['groups']] = $row['num_rows'];
}

?>

<script>
  var donnees = {
    labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
    datasets: [{
      label: 'Différents groupes',
      data: [
        <?php
        for ($i = 'A'; $i <= 'G'; $i++) {
            echo isset($groupes[$i]) ? $groupes[$i] : 0;
            if ($i !== 'G') {
                echo ', ';
            }
        }
        ?>
      ],
      backgroundColor: 'rgba(0, 0, 255, 0.5)',
      borderColor: 'rgba(0, 0, 255, 1)',
      borderWidth: 1
    }]
  };

  var options = {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  };

  var ctx = document.getElementById('graphique').getContext('2d');
  var graphique = new Chart(ctx, {
    type: 'bar',
    data: donnees,
    options: options
  });
</script>

<?php

$sql = "SELECT `date`, `co2` FROM trajet ORDER BY `date` DESC LIMIT 5";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$dates = array();
$co2Values = array();
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $co2Values[] = $row['co2'];
}
?>

<script>
    var donnees = {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: 'CO2 utilisé au cours des 5 derniers trajets',
            data: <?php echo json_encode($co2Values); ?>,
            backgroundColor: 'rgba(0, 0, 255, 0.5)',
            borderColor: 'rgba(0, 0, 255, 1)',
            borderWidth: 1
        }]
    };

    var options = {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var ctx = document.getElementById('co2').getContext('2d');
    var graphique = new Chart(ctx, {
        type: 'bar',
        data: donnees,
        options: options
    });
</script>

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
            borderWidth: 1
        }]
    };

    var options = {
        responsive: true,
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