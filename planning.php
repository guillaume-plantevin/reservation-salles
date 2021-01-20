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
    session_start();

    // ex de $_GET
    // ?day=22&month=02&year=2021
    require_once('functions/functions.php');
    require_once('pdo.php');
    require_once('class/week.php');
    require_once('class/events.php');

    date_default_timezone_set ('Europe/Paris');

    $title = 'planning';

    $eventsFromDB = new Events();
    $tableCell = [];
    $currentEvent = [];

    $actWeek = new Week($_GET['day'] ?? null, $_GET['month'] ?? null, $_GET['year'] ?? null);
    $startingDayWeek = $actWeek->getStartingDay();
    $end = (clone $startingDayWeek)->modify('+ 5 days - 1 second');

    $events = $eventsFromDB->getEventsBetweenByDayTime($startingDayWeek, $end);
    // DEBUG
    // print_r_pre($events, '[34]-> $events');
    foreach ($events as $k => $event) {
        $tableCell[$event['case']] = $event['length'];
    }
    // DEBUG
    // var_dump_pre($tableCell, '40: tableCell');

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
        <table class="table table-hover calendar__table">
            <colgroup>
                <col style="background-color:#ddd;">
                <col span="5">
                <col span="2" style="background-color:#ddd;">
            </colgroup>
            <?php 
                // CONSTRUCT THE TABLE
                // ROWS
                for ($y = 0; $y < 12; ++$y) {
                    echo '<tr>', "\n";
                    // COLUMNS
                    for ($x = 0; $x < 8; ++$x) {
                        $coordinate = $y . '-' . $x;
                        $cellLength = null;

                        // SET RULES
                        if ($y == 0 && $x == 0)
                            echo '<th>Horaires</th>';
                        // SET RULES: DAYS
                        elseif ($y == 0 && $x > 0) {
                            $daysNumber = $actWeek->mondaysDate + $x - 1;
                            echo '<th>' . $actWeek->getWeekDays($x - 1) . ' ' . $daysNumber .  '</th>';
                        }
                        // SET RULES: HOURS
                        elseif ($y > 0 && $x == 0) {
                            $tempHour = 7 + $y;
                            if ($tempHour < 10) {
                                $hour = '0' . $tempHour . ':00';
                            }
                            else {
                                $hour = $tempHour . ':00';
                            }
                            echo '<th>' . $hour . '</th>';
                        }
                        // GET DATA
                        else {
                            // FIND ROWSPAN, IF EXISTS
                            foreach($tableCell as $key => $value) {
                                if ($coordinate === $key) {
                                    $cellLength = $value;
                                }
                            }
                            // FIND EVENT, IF EXISTS
                            foreach ($events as $k => $event) {
                                if ($coordinate == $event['case']) {
                                    $currentEvent = $event;
                                }
                            }
                            // 
                            if (isset($cellLength) && $cellLength !== FALSE) {
                                echo '<td rowspan="'. $cellLength . '"';
                                echo ' style="color:white;text-shadow: 1px 1px 1px black; background-color:' . randomHsla() . '">';
                                echo "<a href=\"reservation.php?id=" . $currentEvent['id'] . '" class=table_link>';
                                echo '<span class="name_creator"><strong>' . $currentEvent['login'] . '</strong></span>', ',<br />';
                                echo $currentEvent['titre'], '<br />';
                                echo '</a>';
                                echo '</td>';
                                
                                // LOGICAL PART: SET THE LOWER ROW(S) IN THE 'MIRROR' ARRAY
                                $tempY = $y + 1;
                                while ($cellLength > 1) {
                                    $tableCell[$tempY . '-' . $x] = FALSE;
                                    $tempY++;
                                    $cellLength--;
                                }
                            }
                            else {
                                // BELOW CELL WITH ROWSPAN: ECHO NOTHING
                                if (isset($tableCell[$coordinate])) {
                                    ;
                                }
                                // EMPTY CELLS
                                else {
                                    echo '<td></td>';
                                }
                            }
                        }
                    }
                    echo '</tr>', "\n";
                }
            ?>
        </table>
    </main>
    <?php require_once('templates/footer.php') ?>
    </body>
</html>