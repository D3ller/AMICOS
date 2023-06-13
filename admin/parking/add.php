<?php

session_start();




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
    <form action='vadd.php' method='post'>
        <input type='text' name='name' placeholder='name'>
        <input type='text' name='lat' placeholder='lat'>
        <input type='text' name='lng' placeholder='lng'>
        <input type='submit' value='submit'>
</body>
</html>