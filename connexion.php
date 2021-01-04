<?php 
    /*
        Une page contenant un formulaire de connexion (connexion.php) :
        Le formulaire doit avoir deux inputs : 
        “login” et “password”. 
        Lorsque le formulaire est validé, 
        s’il existe un utilisateur en bdd correspondant à ces informations, 
        alors l’utilisateur devient connecté 
        et une (ou plusieurs) variables de session sont créées.
    */
    $title = 'connexion';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body>
        <?php require_once('templates/header.php') ?>
        <main class="container">
        <h1>Connexion</h1>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>