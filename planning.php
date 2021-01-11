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

    require_once('functions/functions.php');
    require_once('pdo.php');
    require_once('class/week.php');

    $title = 'planning';

    // date_default_timezone_set('Europe/Paris');

    // $script_tz = date_default_timezone_get();
    // if (strcmp($script_tz, ini_get('date.timezone'))){
    //     echo 'Script timezone differs from ini-set timezone.';
    // } else {
    //     echo 'Script timezone and ini-set timezone match.';
    // }

    $activeWeek = new Week();
    echo '<br />';
    $test = (clone $activeWeek)->getMonday();
    var_dump_pre($test, '33: $test');


?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body>
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Planning</h1>
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th><?= $activeWeek->getMonth(); ?>
                    </th>
                    <th class="days">Lundi</th>
                    <th class="days">Mardi</th>
                    <th class="days">Mercredi</th>
                    <th class="days">Jeudi</th>
                    <th class="days">Vendredi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="hours">8:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">9:00</th>
                    <td>
                        <form action="reservation.php" method="GET">
                            <input type="hidden" name="id" value='' />
                            <input type="submit" value='détails' />
                        </form>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">10:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">11:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">12:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">13:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">14:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">15:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">16:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">17:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th class="hours">18:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>