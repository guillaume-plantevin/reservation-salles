<?php
    class Events {
        private $pdo;
        public $lengthEvents = [];
        public $eventsForTheWeek = [];

        public function __construct() {
            $this->pdo = new PDO('mysql:host=localhost;dbname=reservationsalles', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        /**
         * Retourne un array avec tous les événements compris entre deux dates
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetween(DateTime $start, DateTime $end): array {
            $sql = "SELECT 
                    reservations.id, reservations.titre, reservations.debut, reservations.fin, utilisateurs.login 
                    FROM reservations JOIN utilisateurs 
                    WHERE debut BETWEEN '{$start->format('Y-m-d 08:00:00')}' AND '{$end->format('Y-m-d 19:00:00')}'
                    AND utilisateurs.id = reservations.id_utilisateur
            ";
            $stmt = $this->pdo->query($sql);

            $results = $stmt->fetchAll();

            return $results;
        }

        /**
         * Retourne un array avec tous les événements compris entre deux dates, INDEXÉ PAR JOUR
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetweenByDay(DateTime $start, DateTime $end): array {
            $events = $this->getEventsBetween($start, $end);
            $days = [];
            foreach ($events as $event) {
                $date = explode(' ', $event['debut'])[0];

                if (!isset($days[$date])) {
                    $days[$date] = [$event];
                } 
                else {
                    $days[$date][] = [$event];
                }
            }

            return $days;
        }

        /**
         * Retourne un array avec tous les événements compris entre deux dates, INDEXÉ PAR JOUR
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetweenByDayTime(DateTime $start, DateTime $end): array {
            $events = $this->getEventsBetween($start, $end);
            $days = [];

            foreach ($events as $event) {
                $day[$event['debut']] = $event;
                $diff = new Events;
                $length = $diff->timeLength($event['debut'], $event['fin']);
                $day[$event['debut']]['length'] = $length;
                $dateStart = new DateTime($event['debut']);
                $dateDay = $dateStart->format('N');
                $timeHour = $dateStart->format('G');
                $case = ($timeHour - 7) . '-' . $dateDay;
                $day[$event['debut']]['case'] = $case;
                $lengthEvents[$case] = $length;
            }

            return $day;
        }

        /**
         * prend deux 'Y-m-d H:i:s' en entrée et renvoie la durée en heures
         * @param string $start
         * @param string $end
         * @return int
         */
        public function timeLength(string $start, string $end): int {
            $tempOne = new DateTime($start);
            $tempTwo = new DateTime($end);
            
            $length = date_diff($tempOne, $tempTwo);

            return $length->h;
        }

        /**
         * 
         * retourne toutes les informations sur un événement choisi
         * @param int $id
         */
        // public function getEvent(int $id): array {
        //     $sql = "SELECT 
        //             reservations.id, reservations.titre, reservations.description, reservations.debut, reservations.fin, utilisateurs.login 
        //             FROM reservations JOIN utilisateurs 
        //             WHERE reservations.id = :id";
        //     $stmt = $this->pdo->prepare($sql);
        //     $stmt->execute([':id' => $id]);
        //     $results = $stmt->fetch(PDO::FETCH_ASSOC);
        //     return $results;
        // }

        /**
         * pour la page reservation.php
         * retourne toutes les informations  sous la forme d'un array associatif sur un événement choisi
         * @param int $id
         * @return array 
         */
        public function getEventById(int $id): array {
            $sql = "SELECT 
                    reservations.id, reservations.titre, reservations.description, reservations.debut, reservations.fin, utilisateurs.login 
                    FROM reservations JOIN utilisateurs 
                    WHERE reservations.id = :id
                    AND utilisateurs.id = reservations.id_utilisateur";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            return $results;
        }
    }