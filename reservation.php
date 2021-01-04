<?
    /*
        Une page permettant de voir une réservation (reservation.php)
        Cette page affiche le nom du créateur, 
        le titre de l’événement, la description, l’heure de début et de fin. 
        Pour savoir quel évènement afficher, 
        vous devez récupérer l’id de l’événement en utilisant la méthode get. 
        (ex : http://localhost/reservationsalles/evenement/?id=1​) 
        Seuls les personnes connectées peuvent accéder aux événements.
    */
    $title = 'réservation';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Réservation</h1>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>