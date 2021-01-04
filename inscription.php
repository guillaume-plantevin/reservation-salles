<?php 
    /*
        Une page contenant un formulaire d’inscription (inscription.php) :
        Le formulaire doit contenir l’ensemble des champs présents 
        dans la table “utilisateurs” (sauf “id”) ainsi qu’une confirmation de mot de passe. 
        Dès qu’un utilisateur remplit ce formulaire, 
        les données sont insérées dans la base de données 
        et l’utilisateur est redirigé vers la page de connexion.
    */
    $title = 'inscription';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Inscription</h1>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>