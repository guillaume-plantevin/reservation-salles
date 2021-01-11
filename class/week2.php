<?php
    class Week {
        public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        
        public $day;
        public $month;
        public $year;

        /**
         * Month constructor
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
            $this->day = $day; 
            $this->month = $month;
            $this->year= $year;
        }

        /**
         * retourne le mois en toutes lettres (ex: Mars 2018)
         * @return string
         */
        public function monthToString(): string {
            return $this->months[$this->month - 1] . ' ' . $this->year;
        }

        /**
         * Retourne le nom du jour
         * @param int $index
         * @return string
         */
        public function getWeekDays(int $index): string {
            return $this->days[$index];
        }

        // public function getStartingDay(): \DateTime {
        //     return new \DateTime("{$this->year}-{$this->month}-01");
        // }

        public function getMonday(): int {
            $inputDate = $this->year . '-' . $this->month . '-' . $this->day ;
            // DEBUG
            echo $inputDate;
            $input = new DateTime($inputDate);
            $activeDay = (clone $input)->format('N');
            
            if ($activeDay === '1') {
                print_r_pre($input, '59: $input');
                return intval($input->format('d'));
            }
            else {
                $output =  new DateTime();
                $output->modify('last monday');
                return intval($output->format('d'));
            }
        }


        /**
         * renvoie le mois suivant
         * @return Week
         */
        public function nextWeek(DateTime $date): Week {


            $day = $this->day+ 7;
            $month = $this->month;
            $year = $this->year;

            if ($month > 12) {
                $month = 1;
                $year += 1;
            }
            return new Week($day, $month, $year);
        }

        /**
         * renvoie le mois précédent
         * @return Week
         */
        public function previousWeek(DateTime $date): Week {


            $month = $this->month ;
            $year = $this->year;

            if ($month < 1) {
                $month = 12;
                $year -= 1;
            }
            return new Week($day, $month, $year);
        }
    }