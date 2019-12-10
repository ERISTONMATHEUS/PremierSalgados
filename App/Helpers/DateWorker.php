<?php

    class DateWorker
    {
        private $dateToParse;

        private $realFormat = 'd/m/Y';

        private $dbFormat = 'Y-m-d';

        public function __construct($date, $format = 'd/m/Y')
        {
            $this->dateToParse = DateTime::createFromFormat($format ,$date);
        }

        public function toRealFormat()
        {
            return $this->dateToParse->format($this->realFormat);
        }

        public function toDbFormat()
        {
            return $this->dateToParse->format($this->dbFormat);
        }
    }