<?php
session_start();

$id = $_GET['id'];


require_once '../../assets/php/lib.php';

if(!isset($id)) {
$_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
header('Location: ../g_parking.php');
exit();
}

$dbh = connect();

$sql = "SELECT * FROM parking WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$parking = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Ce parking n'existe pas";
    header('Location: ../g_parking.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="./vupdate.php" method="post">
        <input type="hidden" name="id" value="<?php echo $parking['id'] ?>">
        <input type="text" name="name" value="<?php echo $parking['name'] ?>">
        <input type="text" name="lat" value="<?php echo $parking['lat'] ?>">
        <input type="text" name="lng" value="<?php echo $parking['lng'] ?>">

        <input type="submit" value="Modifier">
    </form>
</body>
</html>