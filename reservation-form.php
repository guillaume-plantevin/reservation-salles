<?php
    /*
        Un formulaire de réservation de salle (reservation-form.php)
        Ce formulaire contient les informations suivantes : 
            titre, description, date de début, date de fin.
    */
    session_start();
    
    // DEBUG
    // $one = '<br />';
    // $two = $one . $one;

    require_once('pdo.php');
    require_once('functions/functions.php');
    require_once('class/events.php');

    $title = 'Formulaire de réservation';

    // DEBUG
    print_r_pre($_SESSION, '19: $_SESSION:');
    echo breakingLine();
    var_dump_pre($_POST, '21: $_POST:');
    echo breakingLine();

    if (isset($_POST['cancel'])) {
        header('Location: deconnexion.php');
        return;
    }
    // POST-FORM SUBMIT
    if ( isset($_POST['submit'])) {
        // NO TITLE
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'Vous devez entrer un titre pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // TOO LONG TITLE
        elseif (strlen($_POST['title'] > 255)) {
            $_SESSION['error'] = 'Votre titre est trop long.';
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
        // > 65,535 chars
        // TOO LONG DESCRIPTION
        elseif (strlen($_POST['description']) > 65535) {
            $_SESSION['error'] = 'Votre description est trop longue.';
            header('Location: reservation-form.php');
            return;
        }
        // OK, CONTINUE (VALIDATING INPUTS: DATE AND TIME)
        else {
            $dateArray = explode('-', $_POST['date']);
            $startTimeArray = explode(':', $_POST['startTime']);
            $endTimeArray = explode(':', $_POST['endTime']);

            $dateFormatted =implode('/',$dateArray);

            $timestamp = strtotime($_POST['date']);
            $dayOfWeek = date('N', $timestamp);

            $timestampNow = time();
            $dateTime = $_POST['date'] . ' ' .$_POST['startTime'] . ':00';
            $resDateTime = strtotime($dateTime);

            // IF WEEK-END
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                $_SESSION['error'] = 'Vous ne pouvez pas faire de réservation durant les week-ends.';
                header('Location: reservation-form.php');
                return;
            }
            // CHECK DATE IS WELL FORMATED
            // $dateMYD = $dateArray[1] . $dateArray[2] . $dateArray[0]; 
            elseif (!checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
                $_SESSION['error'] = 'Il y  erreur dans le formatage de votre jour de réservation.';
                header('Location: reservation-form.php');
                return;

            }
            // IF ENDING BEFORE STARTING
            elseif ($endTimeArray[0] <= $startTimeArray[0]) {
                $_SESSION['error'] = 'Votre réservation finit avant son heure de début.';
                header('Location: reservation-form.php');
                return;
            }
            // BAD STARTING HOUR {
            elseif (intval($startTimeArray[0]) < 8 || intval($startTimeArray[0]) > 18) {
                $_SESSION['error'] = 'Votre heure de début n\'est pas valide.';
                header('Location: reservation-form.php');
                return;
            }
            // BAD ENDING HOUR {
            elseif (intval($endTimeArray[0]) > 19) {
                $_SESSION['error'] = 'Votre heure de fin n\'est pas valide.';
                header('Location: reservation-form.php');
                return;
            }
            // USER INPUTS MINUTES OTHER THAN 00
            elseif ($endTimeArray[1] != '00' || $startTimeArray[1] != '00') {
                $_SESSION['error'] = 'Votre horaire n\'est pas valide.';
                header('Location: reservation-form.php');
                return;
            }
            // ANTIDATING
            elseif ($resDateTime <= $timestampNow) {
                $_SESSION['error'] = 'Vous ne pouvez pas antidater votre réservation';
                header('Location: reservation-form.php');
                return;
            }
            // OK, CONTINUE 
            else {
                /**
                 * ON VERRA!
                 * utiliser des timestamps, ça devrait être plus simple de savoir
                 */
                $dateStart = $_POST['date'] . ' ' . $_POST['startTime'] . ':00';
                $dateEnd = $_POST['date'] . ' ' . $_POST['endTime'] . ':00';
                // var_dump_pre($_POST['date'], '$_POST[date]');

                $start = new DateTime($_POST['date'], new DateTimeZone('Europe/Paris'));
                $end = (clone $start)->modify('+1 day - 1 second');

                $events = new Events();
                $eventsForDay = $events->getEventsBetweenByDay($start, $end);

                // print_r_pre($eventsForDay, '$eventsForDay');
                // le jour ne sert à rien donc il faut que j'ai un array juste indexé par un index

                foreach ($eventsForDay as $k => $v) {
                    print_r_pre($k, '$k');
                    print_r_pre($v, '$v');
                }
                if (!empty($eventsForDay)) {
                    echo 'NOT EMPTY<br> ';

                }


                
                // $sql = "SELECT * FROM reservations WHERE debut BETWEEN :debut AND :fin";
                // echo $sql;
                // $verify = $pdo->prepare($sql);
                // $verify->execute([
                //     ':debut' => $dateStart,
                //     ':fin' => $dateEnd
                // ]);
                // $results = $verify->fetch(PDO::FETCH_ASSOC);
                // DEBUG
                // var_dump_pre($results, '$results');
                // if (!empty($results)) {
                //     $_SESSION['error'] = 'Il existe déjà une réservation dans le planning entre votre heure de début et votre heure de fin.';
                //     header('Location: reservation-form.php');
                //     return;
                // }



                // $insert = "INSERT INTO reservations 
                //     (titre, description, debut, fin, id_utilisateur) 
                //     VALUES (:title, :description, :debut, :fin, :id_user)";

                // // DEBUG
                // echo $insert . '<br>';

                // $stmt = $pdo->prepare($insert);

                // $stmt->execute([
                //     ':title'=> htmlentities($_POST['title']),
                //     ':description'=> htmlentities($_POST['description']), 
                //     ':debut'=> $dateStart, 
                //     ':fin'=> $dateEnd, 
                //     ':id_user'=> $_SESSION['id']
                // ]);
                    
    
                // $_SESSION['success']= 'Votre réservation a bien été enregistré. Vous pouvez dès maintenant la voir sur le planning.';
            }
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
            <p>Pour pouvoir faire une réservation, vous devez respecter quelques consignes: </p>
            <ul>
                <li>Vous ne pouvez pas antidater une réservation,</li>
                <li>elles sont ouvertes du Lundi au Vendredi inclus, </li>
                <li>elles doivent débuter entre 08:00 et 18:00 inclus</li>
                <li>et ne peuvent finir après 19:00, </li>
                <li>Les réservations ne se font que par heures rondes: par exemple 16:00 et non pas 16:30 ou 16:59.</li>
            </ul>
            <p>
                Si vous ne respectez pas ces règles, votre réservation ne pourra pas être validée et un message vous indiquera quelle correction devra être apportée.
            </p>
            <form method="POST">
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" placeholder="Entrez votre titre ici"/><br />

                <label for="date">date:</label>
                <input type="date" name="date" id="date"/><br />

                <label for="timeStart">heure de début:<br /><small>de 8:00 à 19:00</small></label>
                <input type="time" id="timeStart" name="startTime" min="08:00" max="19:00" /><br />

                <label for="timeEnd">heure de fin:<br /><small>de 9:00 à 19:00</small></label>    
                <input type="time" id="timeEnd" name="endTime" min="09:00" max="19:00" /> <br />

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