
<?php


if($_SERVER['PHP_SELF'] == "/profil.php"){
    echo '<nav class="cstm" style="background: #ffab02; margin-bottom: 0">';
    echo '<a href="./index.php"><div id="backarrow"></div></a>';
    echo '<p>Profil</p>';
    echo '<a href="./parametre.php"><div id="threepoint"></div></a>';
} elseif($_SERVER['PHP_SELF'] == "/conditiongeneral.php"){
    echo '<nav class="cstm" style="background: #fe1269; margin-bottom: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="./parametre.php"><div id="backarrow"></div></a>';
    echo '<p>CGU</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';

} elseif($_SERVER['PHP_SELF'] == "/parametre.php"){
    echo '<nav class="cstm" style="background: #ffab02; margin-bottom: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="/profil.php"><div id="backarrow"></div></a>';
    echo '<p>';
    echo ucfirst(substr($_SERVER['PHP_SELF'], 1, -4));
    echo '</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';
} elseif($_SERVER['PHP_SELF'] == "/parkings.php") {
    echo '<nav class="cstm" style="background: #b7e1cb; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="./index.php"><div id="backarrow"></div></a>';
    echo '<div id="parkings"></div>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';
} elseif($_SERVER['PHP_SELF'] == '/historique.php' || $_SERVER['PHP_SELF'] == '/statistique.php') {
    echo '<nav class="cstm" style="background: #ff6d13; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="/profil.php"><div id="backarrow"></div></a>';
    echo '<p>';
    echo ucfirst(substr($_SERVER['PHP_SELF'], 1, -4));
    echo '</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';

} elseif($_SERVER['PHP_SELF'] == "/edit.php"){
    echo '<nav class="cstm" style="background: #ffab02; margin-bottom: 0;">';
    echo '<a href="./profil.php"><div id="backarrow"></div></a>';
    echo '<p>Editer le profil</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';

}
 elseif($_SERVER['PHP_SELF'] == '/pdc.php') {
    echo '<nav class="cstm" style="background: #fe1269; margin-bottom: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="./parametre.php"><div id="backarrow"></div></a>';
    echo '<p>PDC</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';

} elseif($_SERVER['PHP_SELF'] == '/mentions.php') {
    echo '<nav class="cstm" style="background: #fe1269; margin-bottom: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="./parametre.php"><div id="backarrow"></div></a>';
    echo '<p>Mentions légales</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';

} elseif($_SERVER['PHP_SELF'] == '/cookie.php') {
    echo '<nav class="cstm" style="background: #fe1269; margin-bottom: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">';
    echo '<a href="./parametre.php"><div id="backarrow"></div></a>';
    echo '<p>Cookies</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';



} else {
    echo '<a href="javascript:history.back()"><div id="backarrow"></div></a>';
    echo '<p>';
    echo ucfirst(substr($_SERVER['PHP_SELF'], 1, -4));
    echo '</p>';
    echo '<div style="opacity: 0; visibility: hide" id="threepoint"></div>';
}



?>

</nav>
