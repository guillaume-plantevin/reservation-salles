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
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Connexion';

    // REDIRECT TO DECONNEXION.PHP
    if (isset($_POST['cancel'])) {
        header("Location: deconnexion.php");
        return;
    }

    // FORM POST SEND
    if (isset($_POST['submit'])) {
        // NO LOGIN
        if (empty($_POST['login'])) {
            $_SESSION['error'] = 'Vous devez rentrer votre login pour vous connecter.';
            header('Location: connexion.php');
            return;
        }
        // NO PASSWORD
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = 'Vous devez rentrer votre mot de passe pour vous connecter.';
            header('Location: connexion.php');
            return;
        }
        // OK, CONTINUE -> ASK DB
        if ( isset($_POST['login']) && isset($_POST['password']) ) {
            $sql = "SELECT * FROM utilisateurs WHERE login = :login";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':login' => $_POST['login']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // NO RETURN FROM DB
            if (empty($row)) {
                $_SESSION['error'] = 'Ce Login n\'existe pas dans notre base de donnée.';
                header('Location: connexion.php');
                return;
            }
            // OK, CONTINUE
            else { 
                // VERIFY PASSWORD
                if (!password_verify($_POST['password'], $row['password'])) {
                    $_SESSION['error'] = 'Votre mot de passe n\'est pas similaire à celui enregistré lors de votre inscription.';
                    header('Location: connexion.php');
                    return;
                }
                // OK, CONTINUE
                else {
                    // DB's INFOS => $_SESSION
                    foreach($row as $k => $v) {
                        $_SESSION[$k] = $v;
                    }
                    // BOOL LOGGED
                    $_SESSION['logged'] = TRUE;
                    // CHARGING PASSWORD, NOT THE HASH
                    $_SESSION['password'] = htmlentities($_POST['password']);
    
                    // GOTO
                    header('location: profil.php');
                    return;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body class='container'>
        <?php require_once('templates/header.php') ?>
        <main>
            <h1>Connexion</h1>
            <?php 
                if ( isset($_SESSION['error']) ) 
                {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                elseif ( isset($_SESSION['success']) ) 
                {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
                }
            ?>
            <p>Pour vous connecter, il vous suffit de rentrer votre identifiant et votre mot de passe:</p>
            <form action="" method="post">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" /><br />
                
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" /><br />

                <input type="submit" id="submitButton" name="submit" value="Valider" />
                <input type='submit' name='cancel' value='annuler' />
            </form>
        </main>
        <?php require_once('templates/footer.php'); ?>
    </body>
</html>