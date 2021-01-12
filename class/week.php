<?php
    class Week {
        public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        
        // BOOL
        public $currentIsMonday;
        // STRING
        public $currentDayString;
        public $monthString;
        // INT
        public $currentDay;
        public $currentDate;
        public $mondaysDate;
        public $day;
        public $month;
        public $year;


        /**
         * week constructor: initialise tous les attributs
         * @param int $day
         * @param int $month, le mois compris entre 1 et 12
         * @param int $year, L'année
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
            $dateString =$year  . '-' . $month . '-' . $day; 
            $makeDate = new DateTimeImmutable($dateString);
            $this->currentDay = intval($makeDate->format('N'));

            // VERIFY IF CURRENT DAY IS MONDAY
            if ($this->currentDay === 1) {
                $this->mondaysDate = $day;
                $this->currentIsMonday = TRUE;
            } else {
                $getMondayDate = $makeDate->modify('last Monday');
                $this->mondaysDate = intval($getMondayDate->format('j'));
                $this->currentIsMonday = FALSE;
            }
            // SET OTHER ATTRIBUTES
            $this->currentDate = $dateString;
            $this->day = $day; 
            $this->month = $month;
            $this->year= $year;
            $this->currentDayString = $this->days[$this->currentDay - 1];
            $this->monthString = $this->months[$this->month - 1];
        }

        /**
         * retourne le mois  en toutes lettres et l'année (ex: Mars 2018)
         * @return string
         */
        public function monthToString(): string {
            return $this->months[$this->month - 1] . ' ' . $this->year;
        }

        /**
         * Retourne le nom du jour en toutes lettres
         * @param int $index
         * @return string
         */
        public function getWeekDays(int $index): string {
            return $this->days[$index];
        }

        /**
         * renvoie la semaine suivante
         * @return Week
         */
        public function nextWeek(): Week {
            $temp = new DateTimeImmutable($this->currentDate);
            $temp2 = $temp->modify('next monday');

            $day = $temp2->format('j');
            $month = $temp2->format('n');
            $year = $temp2->format('Y');

            return new Week($day, $month, $year);
        }

        /**
         * renvoie la semaine précédente
         * @return Week
         */
        public function previousWeek(): Week {
            $tempDate = new DateTimeImmutable($this->currentDate);
            $dayName = $tempDate->format('l');
            $tempDate2 = $tempDate->modify('previous ' . $dayName);

            $day = $tempDate2->format('j');
            $month = $tempDate2->format('n');
            $year = $tempDate2->format('Y');

            return new Week($day, $month, $year);
        }

        /**
         * retourne un objet DateTime pour faire la recherche d'événements
         * @return DateTime
         */
        public function getStartingDay(): DateTime {
            return new DateTime("{$this->year}-{$this->month}-{$this->mondaysDate}");
        }
    }