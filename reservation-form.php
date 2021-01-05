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
        header('Location: reservation-form.php');
        return;
    }
    if ( isset($_POST['submit'])) {
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'Vous devez entrer un titre pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        elseif (empty($_POST['date'])) {
            $_SESSION['error'] = 'Vous devez choisir un jour pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        elseif (empty($_POST['startTime'])) {
            $_SESSION['error'] = 'Vous devez choisir une heure de début pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        elseif (empty($_POST['endTime'])) {
            $_SESSION['error'] = 'Vous devez choisir une heure de fin pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        elseif (empty($_POST['description'])) {
            $_SESSION['error'] = 'Vous devez écrire une description pour votre réservation.';
            header('Location: reservation-form.php');
            return;
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
            <form method="POST">
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" placeholder="Entrez votre titre ici"/><br />

                <!-- <label for="datetime">datetime:</label>
                <input type="datetime" name="datetime" id="datetime"/><br />
                
                <label for="dtLocal">datetime-local:</label>
                <input type="datetime-local" name="dtLocal" id="dtLocal"/><br /> -->

                <label for="date">date:</label>
                <input type="date" name="date" id="date"/><br />

                <label for="timeStart">
                    heure de début:<br />
                    <small>de 8:00 à 19:00</small>
                </label>
                <!-- <small>de 8:00 à 19:00</small> -->
                <input type="time" id="timeStart" name="startTime" min="08:00" max="19:00" /><br />


                <label for="timeEnd">
                    heure de fin:<br />
                        <small>de 9:00 à 20:00</small>
                </label>    
                <!-- <small>Office hours are 9am to 6pm</small> -->
                <input type="time" id="timeEnd" name="endTime" min="09:00" max="20:00" /> <br />


                <label for="description">Desciption:</label>
                <textarea name="description" id="description" cols="30" rows="10" maxlength="65535"></textarea/><br />
                

                <input type="submit" name='submit' value="Valider">
                <input type="submit" name='cancel' value="Annuler">
            </form>
            <?php
                endif;
            ?>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>