<?php

session_start();

require_once('../assets/php/lib.php');

echo '<a href="./g_user.php">Gérer les utilisateurs</a>';
echo '<br>';
echo '<a href="./g_trajet.php">Gérer les trajets</a>';




?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    
  <canvas id="graphique"></canvas>

  
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
