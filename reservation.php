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
    require_once('class/week.php');
    require_once('class/events.php');

    $title = 'reservation';

    // DEBUG
    // var_dump_pre($_GET, '$_GET');

    if (isset($_GET['id'])) {
        $event = new Events;
        $eventInfos = $event->getEventById($_GET['id']);
        
        // DEBUG
        print_r_pre($eventInfos, '$eventInfos');
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
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
                echo '<p class="error">Cette partie du site où vous pourrez voir une réservation de salle, ne sera visible qu\'une fois connecté</p>';
            else :
        ?>
            <article class="reservation">
                <p>Réservation réalisée par: <?= $eventInfos['login']; ?>,
                </p>
                <p>titre: <span class="reservationTitre">"<?= $eventInfos['titre']; ?>"</span>
                </p>
                <p>description: <?= $eventInfos['description']; ?>
                </p>

            </article>

        <?php endif; ?>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>