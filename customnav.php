<nav class="cstm">

<?php

if($_SERVER['PHP_SELF'] == "/profil.php"){
    echo '<a href="./index.php"><div id="backarrow"></div></a>';
    echo '<p>Profil</p>';
    echo '<a href="./parametre.php"><div id="threepoint"></div></a>';
} else {
    echo '<a href="javascript:history.back()"><div id="backarrow"></div></a>';
    echo '<p>';
    echo ucfirst(substr($_SERVER['PHP_SELF'], 1, -4));
    echo '</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';
}

?>

</nav>
