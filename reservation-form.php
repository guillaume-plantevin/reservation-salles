<?php
    /*
        Un formulaire de réservation de salle (reservation-form.php)
        Ce formulaire contient les informations suivantes : 
            titre, description, date de début, date de fin.
    */
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'réservation: formulaire';

    // DEBUG
    print_r_pre($_SESSION, '15: $_SESSION:');
    print_r_pre($_POST, '16: $_POST:');


    if ( isset($_POST['cancel']) ) {
        header('Location: deconnexion.php');
        return;
    }
    if ( isset($_POST['submit'])) {
        // NO TITLE
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'Vous devez entrer un titre pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // NO DATE
        elseif (empty($_POST['date'])) {
            $_SESSION['error'] = 'Vous devez choisir un jour pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // NO STARTING TIME
        elseif (empty($_POST['startTime'])) {
            $_SESSION['error'] = 'Vous devez choisir une heure de début pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // NO ENDING TIME
        elseif (empty($_POST['endTime'])) {
            $_SESSION['error'] = 'Vous devez choisir une heure de fin pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // NO DESCRIPTION
        elseif (empty($_POST['description'])) {
            $_SESSION['error'] = 'Vous devez écrire une description pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // OK, CONTINUE
        else {
            $dateArray = explode('-', $_POST['date']);
            $startTimeArray = explode(':', $_POST['startTime']);
            $endTimeArray = explode(':', $_POST['endTime']);

            // DEBUG
            var_dump_pre($dateArray, '61: $dateArray');
            var_dump_pre($startTimeArray, '62: $startTimeArray');
            var_dump_pre($endTimeArray, '63: $endTimeArray');
            
            // IF ANTEDATE
            if ($endTimeArray[0] <= $startTimeArray[0]) {
                $_SESSION['error'] = 'L\'heure de fin de votre réservation n\'est pas valide. Merci de faire les corrections nécessaires.';
                header('Location: reservation-form.php');
                return;
            }
            // USER INPUTS MINUTES OTHER THAN 00
            elseif ($endTimeArray[1] != '00' || $startTimeArray[1] != '00') {
                // CHANGER LE MSG , TOUT DE MEME...
                $_SESSION['error'] = 'Vous ne lisez pas ce que je vous écris, car vous êtes un con. <br />PAS DE MINUTES!';
                header('Location: reservation-form.php');
                return;
            }
            else {
                $timestampNow = time();
                $dateTime = $_POST['date'] . ' ' .$_POST['startTime'] . ':00';
                $resDateTime = strtotime($dateTime);

                // DEBUG
                print_r_pre($timestampNow, '77: $timestampNow: ');
                var_dump_pre($resDateTime, '88: $resDateTime');

                if ($resDateTime <= $timestampNow) {
                    $_SESSION['error'] = 'Vous avez fait une réservation dans le passé. Merci de faire les corrections nécessaires.';
                    header('Location: reservation-form.php');
                    return;
                }
            }
            // echo date();

            /*
            $insert = "INSERT INTO reservations 
                    (titre, description, debut, fin, id_utilisateur) 
                    VALUES (:title, :description, :debut, :fin, :id_user)";

            // DEBUG
            echo $insert. '<br>';
            
            $stmt = $pdo->prepare($insert);

            $dateStart = $_POST['date'] . ' ' . $_POST['startTime'] . ':00';
            $dateEnd = $_POST['date'] . ' ' . $_POST['endTime'] . ':00';

            $stmt->execute([
                ':title'=> htmlentities($_POST['title']),
                ':description'=> htmlentities($_POST['description']), 
                ':debut'=> $dateStart, 
                ':fin'=> $dateEnd, 
                ':id_user'=> $_SESSION['id']
            ]);
            */

            // $_SESSION['success']= 'Votre réservation a bien été enregistré. Vous pouvez dès maintenant la voir sur le planning.';
            
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
            <h1>Formulaire de réservation de salle</h1>
            <p>Le blahblah habituel...</p>
            <?php
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                elseif ( isset($_SESSION['success']) ) {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
                }
                if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
                    echo '<p class="error">Cette partie du site où vous pourrez réaliser une réservation de salle, ne sera visible qu\'une fois connecté</p>';
                else :
            ?>
            <!-- à envoyer en POST, car le descriptif peut-être long... -->
            <p>
                Attention: Les réservations ne se font que par heures complètes, 
                par exemple 16:00 et non pas 16:30. 
                Si vous choisissez une heure de début ou de fin ne respectant pas ce format, 
                votre réservation ne pourra pas être validée.
            </p>
            <form method="POST">
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" placeholder="Entrez votre titre ici"/><br />

                <label for="date">date:</label>
                <input type="date" name="date" id="date"/><br />

                <label for="timeStart">heure de début:<br /><small>de 8:00 à 19:00</small></label>
                <input type="time" id="timeStart" name="startTime" min="08:00" max="19:00" /><br />

                <label for="timeEnd">heure de fin:<br /><small>de 9:00 à 20:00</small></label>    
                <input type="time" id="timeEnd" name="endTime" min="09:00" max="20:00" /> <br />

                <label for="description">Desciption:</label> <br />
                <textarea name="description" id="description" cols="33" rows="10" maxlength="65535"></textarea/><br />

                <input type="submit" name='cancel' value="annuler">
                <input type="reset" name='reset' value="Réinitialiser">
                <input type="submit" name='submit' value="Valider">
            </form>
            <?php
                endif;
            ?>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>