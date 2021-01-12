<?php
    class Week {
        public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        public $day;
        public $month;
        public $year;
        public $hourStart = 8;
        public $hourEnd = 18;

        /**
         * initialise la date sur le jour actif de la semaine en cours, si les paramètres ne sont pas donnés
         * @param int $day
         * @param int $month
         * @param int $year
         */
        public function __construct(?int $day = null, ?int $month = null, ?int $year = null) {
            // date_default_timezone_set('Europe/Paris');

            if ($day === null || $day < 1 || $day > 31) {
                $day = intval(date('j'));
            }
            if ($month === null || $month < 1 || $month > 12) {
                $month = intval(date('m'));
            }
            if ($year === null) {
                $year = intval(date('Y'));
            }
        }
        /**
         * retourne le mois en toutes lettres
         * @return string
         */
        public function toString(): string {
            return $this->months[$this->month];
        }
        /**
         * retourne l'array des jours de la semaine
         * @return array
         */
        public function getWeekDay(): array {
            return $this->days;
        }

        /**
         * retourne le numéro du dernier Lundi si on est un autre jour
         * 
         */
        public function getMonday() {
            $input = new DateTime('now');
            $activeDay = (clone $input)->format('N');
            
            if ($activeDay === '1') {
                print_r_pre($input, '91: $input');
                return $input;
            }
            else {
                $output =  new DateTime();
                return $output->modify('last monday');
            }
        }
    }