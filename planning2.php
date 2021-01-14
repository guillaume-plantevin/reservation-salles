<?php
    /*
        Une page permettant de voir le planning de la salle (planning.php) :
        Sur cette page on voit le planning de la semaine avec l’ensemble des réservations effectuées. 
        Le planning se présente sous la forme d’un tableau avec les jours de la semaine en cours. 
        Dans ce tableau, il y a en colonne les jours et les horaires en ligne. 
        Sur chaque réservation, il est écrit le nom de la personne 
        ayant réservé la salle ainsi que le titre. 
        Si un utilisateur clique sur une réservation, il est amené sur une page dédiée.

        Les réservations se font du lundi au vendredi et de 8h et 19h. 
        Les créneaux ont une durée fixe d’une heure.
    */
    // session_start();

    // ex de $_GET
    // ?day=22&month=02&year=2021
    require_once('functions/functions.php');
    require_once('pdo.php');
    require_once('class/week.php');
    require_once('class/events.php');

    date_default_timezone_set ('Europe/Paris');

    $title = 'planning';

    $eventsFromDB = new Events();
    $actWeek = new Week($_GET['day'] ?? null, $_GET['month'] ?? null, $_GET['year'] ?? null);
    $startingDayWeek = $actWeek->getStartingDay();
    $end = (clone $startingDayWeek)->modify('+ 5 days - 1 second');
    $events = $eventsFromDB->getEventsBetweenByDayTime($startingDayWeek, $end);
    // print_r_pre($events, '[41]-> $events');
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php'); ?>
    <body>
        <?php require_once('templates/header.php'); ?>
        <main>
        <div class="calendar__nav">            
            <a href="planning.php?day=<?= $actWeek->previousWeek()->day; ?>&month=<?= $actWeek->previousWeek()->month; ?>&year=<?= $actWeek->previousWeek()->year; ?>" class="btn btn-primary">&lt;</a>
            <h1>planning: <?= $actWeek->monthToString(); ?></h1>
            <a href="planning.php?day=<?= $actWeek->nextWeek()->day; ?>&month=<?= $actWeek->nextWeek()->month; ?>&year=<?= $actWeek->nextWeek()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
        <table class="calendar__table">
            <colgroup>
                <col style="background-color:#ddd;">
                <col span="5">
                <col span="2" style="background-color:#ddd;">
            </colgroup>
            <?php 
            // CONSTRUCT THE TABLE
            for ($i = 0; $i < 12; ++$i) {
                echo '<tr>', "\n";
                for ($j = 0; $j < 8; ++$j) {
                    if ($i == 0 && $j == 0)
                        echo '<th>Horaires</th>';
                    elseif ($i == 0 && $j > 0) {
                        $numbDay = $actWeek->mondaysDate + $j - 1;
                        echo '<th>' . $actWeek->getWeekDays($j - 1) . ' ' . $numbDay .  '</th>';
                    }
                    elseif ($j == 0 && $i > 0) {
                        $tempHour = 7 + $i;
                        if ($tempHour < 10) {
                            $hour = '0' . $tempHour . ':00';
                        }
                        else {
                            $hour = $tempHour . ':00';
                        }
                        echo '<th>' . $hour . '</th>';
                    }
                    else {
                        // CREATE DATES & TIMES TO PUT IN REGARD OF ARRAY FROM DB
                        $tempDay = $actWeek->mondaysDate + $j - 1;
                        $fullDayDate = $actWeek->year . '-' . '0' .$actWeek->month . '-' . $tempDay;
                        $hourFull = $hour . ':00';
                        $fullDayDateTime = $fullDayDate . ' ' . $hourFull;

                        echo '<td' ;
                        // rowspan -> nombre d'heures
                        foreach ($events as $k => $event) {
                            if ($k == $fullDayDateTime ) {
                                $diff = new Events;
                                $length = $diff->timeLength($event['debut'], $event['fin']);
                                if ($length > 1) {
                                    // echo ' rowspan=' . $length;
                                    echo '>';
                                    // merde, ça décale les cases en-dessous
                                    // echo $length, '<br>';
                                } else {
                                    echo '>';
                                }
                                echo '(' . $length . ') ';
                                echo $event['login'], '<br />';
                                echo $event['titre'], '<br />';
                                echo "<a href=\"reservation.php?id=" . $event['id'] . '">détails</a>';
                                // echo '</td>';
                            }
                        }
                        echo '>';
                        echo '</td>';
                    }
                }
            }
            ?>
        </table>
    </main>
    <?php require_once('templates/footer.php') ?>
    </body>
</html>