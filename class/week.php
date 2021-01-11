<?php
    class Week {
        public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        public $day;
        public $dayNumb;
        public $month;
        public $monthNumb;
        public $year;

        /**
         * initialise la date sur le jour actif de la semaine en cours
         * @param int $day
         * @param int $month
         * @param int $year
         */
        public function __construct(?int $day = null, ?int $month = null, ?int $year = null) {
            if ($day === null || $day < 1 || $day > 31) {
                $day = intval(date('j'));
            }
            if ($month === null || $month < 1 || $month > 12) {
                $month = intval(date('m'));
            }
            if ($year === null) {
                $year = intval(date('Y'));
            }

            date_default_timezone_set('Europe/Paris');

            $this->day = $this->days[date('N') - 1];
            $this->dayNumb = intval(date('j'));

            $this->month = $this->months[date('n') - 1];
            $this->monthNumb = (date('n'));

            $this->year = intval(date('Y'));

            echo $this->day . ' ' . $this->dayNumb . ' / ' . $this->month . ' / ' . $this->year;
        }

        /**
         * retourne le jour en toutes lettres (ex: Lundi)
         * @return string
         */
        public function getDay(): string {
            return $this->day;
        }

        /**
         * retourne le jour en toutes lettres (ex: Lundi)
         * @return string
         */
        public function getDayNumb(): string {
            return $this->dayNumb;
        }

        /**
         * retourne le mois en toutes lettres (ex: Mars)
         * @return string
         */
        public function getMonth(): string {
            return $this->month;
        }

        /**
         * retourne le mois en chiffre (ex: Mars -> 3)
         * @return int
         */
        public function getMonthNumb(): int {
            return $this->monthNumb;
        }

        /**
         * retourne l'année (ex: 2021)
         * @return int
         */
        public function getYear(): int {
            return $this->year;
        }
        /**
         * retourne le numéro du dernier Lundi si on est un autre jour
         * 
         */
        public function getMonday() {
            $input = new DateTime('now');
            $activeDay = (clone $input)->format('N');
            if ($activeDay === 1) {
                print_r_pre($input, '$input');
                return $input;
            }
            else {
                $output =  new DateTime();
                return $output->modify('last monday');
            }

        }
    }