<?php
session_start();
require_once './lib.php';
$dbh = connect();

ini_set('display_errors', 0);

$id = $_GET['id'];
$type = $_GET['type'];

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])) {
    header('Location: /connexion.php');
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Veuillez vous connectez pour accéder à la page</p>
    </div>';
    exit();
}

if(!isset($id) || !isset($type)) {
    header('Location: /mesreservations.php');
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Vous devez sélectionner un trajet à annuler</p>
    </div>';
    exit();
}

if($type == "conducteur") {
    $sql = "SELECT * FROM trajet WHERE id = ? AND conducteur_id = ? AND date > NOW()";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION['AMIID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $trajet = $result->fetch_assoc();

    if($result->num_rows == 0) {
        header('Location: /mesreservations.php');
        $_SESSION['error'] = '<div class="errorred">
        <div class="errorunderred">
            <div class="errorredcaracter">
            </div>
        
        </div>
        <h1>Erreur !</h1>
        <p>Vous ne pouvez pas annuler un trajet qui n\'existe pas ou qui est passé
        </p>
        </div>';
        exit();
    }

    $sql = "DELETE FROM trajet WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $sql = "SELECT * FROM passager INNER JOIN profil ON user_id = profil.id WHERE trajet_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sqlconducteur = "SELECT * FROM profil WHERE id = ?";
    $stmtconducteur = $dbh->prepare($sqlconducteur);
    $stmtconducteur->bind_param("i", $_SESSION['AMIID']);
    $stmtconducteur->execute();
    $resultconducteur = $stmtconducteur->get_result();
    $conducteur = $resultconducteur->fetch_assoc();

    $prenomnom = $conducteur['prenom'].' '.$conducteur['nom'];

    while($row = $result->fetch_assoc()) {


        $to = $row['email'];
        $subject = "Annulation de votre trajet";
    
        $from = 'sae202@amicos.fr';
        $fromName = 'SAE202';
    
        $message = '<html><body>';
        $message .= '<h1>Le conducteur '.$prenomnom.' vient d\'annulée votre trajet</h1>';
        $message .= '<p>Nous sommes désolée d\'apprendre que votre trajet à été annulé entre'.$trajet['lieu_depart'].' et '.$trajet['lieu_arrivee'].' le '.$trajet['date'].'</p>';
        $message .= '</body></html>';
    
        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        $headers .= "Organization: 2480\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
        $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
        $headers .= 'Reply-to: no-reply@mmi-troyes.fr';
    
    $send = mail($to, $subject, $message, $headers);

    }

    $sql = "DELETE FROM passager WHERE trajet_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['error'] = '<div class="errorred ">
    <div class="errorunderred valided">
        <div class="errorredcaracter validedcaracter">
        </div>
    
    </div>
    <h1>Validé !</h1>
    <p>Votre trajet a bien été annulé, les passagers ont été prévenus
    </p>
    </div>';
    header('Location: /mesreservations.php');
    exit();





} elseif($type == "user") {

    $sql = "SELECT * FROM passager WHERE trajet_id = ? AND user_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION['AMIID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $trajet = $result->fetch_assoc();

    if($result->num_rows == 0) {
        header('Location: /mesreservations.php');
        $_SESSION['error'] = '<div class="errorred">
        <div class="errorunderred">
            <div class="errorredcaracter">
            </div>
        
        </div>
        <h1>Erreur !</h1>
        <p>Vous ne pouvez pas annuler un trajet qui n\'existe pas ou qui est passé
        </p>
        </div>';
        exit();
    }

    $sql = "SELECT * FROM trajet WHERE id = ? AND date > NOW()";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $trajet = $result->fetch_assoc();

    if($result->num_rows == 0) {
        header('Location: /mesreservations.php');
        $_SESSION['error'] = '<div class="errorred">
        <div class="errorunderred">
            <div class="errorredcaracter">
            </div>
        
        </div>
        <h1>Erreur !</h1>
        <p>Vous ne pouvez pas annuler un trajet qui n\'existe pas ou qui est passé
        </p>
        </div>';
        exit();
    }

    $sql = "DELETE FROM passager WHERE trajet_id = ? AND user_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION['AMIID']);
    $stmt->execute();

    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred valided">
        <div class="errorredcaracter validedcaracter">
        </div>
    
    </div>
    <h1>Validé !</h1>
    <p> Votre réservation a bien été annulée
    </p>
    </div>';
    header('Location: /mesreservations.php');
    exit();

} else {
    header('Location: /mesreservations.php');
    $_SESSION['error'] = "Vous devez sélectionner un trajet pour l'annuler";
    exit();
}

