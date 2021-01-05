<?php
    /*
        Un formulaire de réservation de salle (reservation-form.php)
        Ce formulaire contient les informations suivantes : 
            titre, description, date de début, date de fin.
    */
    $title = 'réservation: formulaire';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Réservation de salle</h1>
        <p>Le blahblah habituel...</p>
        <!-- à envoyer en POST, car le descriptif peut-être long... -->
        <form method="POST">
            <label for="title">Titre:</label>
            <input type="text" name="title" id="" /><br />

            <label for="datetime">datetime</label>
            <input type="datetime" name="datetime" id=""/><br />
            
            <label for=""></label>
            <input type="datetime-local" name="" id=""/><br />
            
            <label for="description">Desciption:</label>
            <textarea name="descrition" id="" cols="30" rows="10"></textarea>
            

            <input type="submit" value="Valider">
            <input type="submit" value="Annuler">
        </form>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>