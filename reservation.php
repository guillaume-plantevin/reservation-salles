<?php
    /*
        Une page permettant de voir une réservation (reservation.php)
        Cette page affiche le nom du créateur, 
        le titre de l’événement, la description, l’heure de début et de fin. 
        Pour savoir quel évènement afficher, 
        vous devez récupérer l’id de l’événement en utilisant la méthode get. 
        (ex : http://localhost/reservationsalles/evenement/?id=1​) 
        Seuls les personnes connectées peuvent accéder aux événements.
    */
    session_start();
    
    require_once('functions/functions.php');
    require_once('pdo.php');
    // require_once('class/week.php');
    require_once('class/events.php');

    $title = 'réservation';

    if (isset($_GET['id'])) {
        // GET INFOS FROM DB
        $event = new Events;
        $eventInfos = $event->getEventById($_GET['id']);

        // FORMAT DATE & TIME
        $timestampStart = strtotime($eventInfos['debut']);
        $timestampEnd = strtotime($eventInfos['fin']);
        $formated = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
    }
    else {
        $_SESSION['error'] = "Cette page n'a pas été accédé par le planning";
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Réservation</h1>
        <?php 
            if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
                echo '<p class="error">Cette partie du site où vous pourrez voir la réservation de salle sélectionnée, ne sera visible qu\'une fois connecté</p>';
            elseif (isset($_SESSION['error'])):
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            else :
        ?>
            <article class="reservation">
                <p><span class="info">Réservation réalisée par</span>: <span class="loginReserv"><?= $eventInfos['login']; ?></p>
                <p><span class="info">titre</span>: <span class="reservationTitre">"<?= $eventInfos['titre']; ?>"</span></p>
                <p><span class="info">description</span>:<br> 
                    <?= $eventInfos['description']; ?>
                </p>
                <p>Commence le <?= $formated->format($timestampStart); ?>, <br>
                    et finit le <?= $formated->format($timestampEnd); ?>.
                </p>
            </article>
        <?php endif; ?>
        </main>
        <?php require_once('templates/footer.php') ?>
    </body>
</html>