<nav class="cstm">

<?php

if($_SERVER['PHP_SELF'] == "/profil.php"){
    echo '<a href="./index.php"><div id="backarrow"></div></a>';
    echo '<p>Profil</p>';
    echo '<a href="./parametre.php"><div id="threepoint"></div></a>';
} else {
    echo '<a href="javascript:history.back()"><div id="backarrow"></div></a>';
    //page title
    echo '<p>';
    echo $_SERVER['PHP_SELF'];
    echo '</p>';
}

?>

</nav>
