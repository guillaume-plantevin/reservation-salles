<?php 
    /*
        Une page contenant un formulaire d’inscription (inscription.php) :
        Le formulaire doit contenir l’ensemble des champs présents 
        dans la table “utilisateurs” (sauf “id”) ainsi qu’une confirmation de mot de passe. 
        Dès qu’un utilisateur remplit ce formulaire, 
        les données sont insérées dans la base de données 
        et l’utilisateur est redirigé vers la page de connexion.
    */
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    // CANCEL -> goto deconnexion.php, -> init $_SESSION
    if (isset($_POST['cancel'])) {
        header('Location: deconnexion.php');
    }

    if (isset($_POST['submit']))  {
        // NO LOGIN
        if (empty($_POST['login'])) {
            $_SESSION['error'] = 'Vous devez choisir un login.';
            header('Location: inscription.php');
            return;
        }
        // NO PASSWORD
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = 'Vous devez choisir un mot de passe.';
            header('Location: inscription.php');
            return;
        }
        // NO PASSWORD CONFIRM
        elseif (empty($_POST['passwordConfirm'])) {
            $_SESSION['error'] = 'Vous devez répéter votre mot de passe.';
            header('Location: inscription.php');
            return;
        }
        // DIFFERENT PASS & CONFIRM
        elseif ($_POST['password'] !== $_POST['passwordConfirm']) {
            $_SESSION['error'] = 'Votre mot de passe et sa confirmation ne sont pas similaires.';
            header('Location: inscription.php');
            return;
        }
        // EVERYTHING'S  OK, CONTINUE
        else {
            $loginLength = strlen($_POST['login']);
			$passwordLength = strlen($_POST['password']);

			// LOGIN TOO LONG
			if ($loginLength > 255) {
				$_SESSION['error'] = "Votre login est trop long: Veuillez en choisir un plus court.";
				header('location: inscription.php');
               	return;
			}
			// PASSWORD TOO LONG
			elseif ($passwordLength > 255) {
				$_SESSION['error'] = "Votre mot de passe est trop long: Veuillez en choisir un plus court.";
				header('location: inscription.php');
               	return;
            }
            else {
                $qry = "SELECT * FROM utilisateurs WHERE login = :login";
    
                $stmt = $pdo->prepare($qry);
                $stmt->execute( array( ':login' => htmlentities( $_POST['login'] ) ) );
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // LOGIN ALREADY EXISTS
                if (!empty($row)) {
                    $_SESSION['error'] = 'Votre login est déjà utilisé par un autre utilisateur, veuillez en choisir un autre.';
                    header('Location: inscription.php');
                    return;
                }
                // INSERT INTO DB
                else {
                    $rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                    
                    // sanitizing input query
                    $stmt = $pdo->prepare($rgt);
        
                    $stmt->execute([
                        ':login' => htmlentities($_POST['login']), 
                        ':password' => password_hash( htmlentities( $_POST['password']), PASSWORD_DEFAULT)
                    ]);
    
                    $_SESSION['success'] = 'Votre profil a été créé avec succès!';
                    // GOTO
                    // header('Location: connexion.php');
                    header('Location: inscription.php');

                    return;
                }
            }
        }
    }
    $title = 'inscription';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Inscription</h1>
        <p>Pour pouvoir réserver une salle, vous devez tout d'abord créer un compte sur notre site.</p>
        <?php 
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
            ?>

            <form action="inscription.php" method="POST">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" /><br />

                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" /><br />

                <label for="passwordConfirm">Confirmation du mot de passe:</label>
                <input type="password" name="passwordConfirm" /><br />

                <input type="submit" id="submitButton" name="submit" value="Inscription" />
                <input type='submit' name='cancel' value='annuler' />
            </form>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>