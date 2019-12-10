<?php

    class ValidationSession
    {
        private $errorContainer = '<span class="error" style="display: block;color: red;margin-top: 5px;">{error}</span>';

        private $cache = [];

        public function __construct($identifier = 'validation')
        {
            $this->cache = (isset($_SESSION[$identifier])) ? $_SESSION[$identifier] : [];
        }

        public function getErrors($field)
        {
            if(!array_key_exists($field, $this->cache)){
                return '';
            }

            if(array_key_exists('error', $this->cache[$field]) and $this->cache[$field]['error'] != ''){
                return str_replace('{error}', $this->cache[$field]['error'], $this->errorContainer);
            }

            return '';
        }

        public function getValue($field)
        {
            if(array_key_exists($field, $this->cache) and $this->cache[$field]['data'] != ''){
                return ' value = ' . $this->cache[$field]['data'];
            }

            return '';
        }

        public function setErrorContainer($container)
        {
            $this->errorContainer = $container;

            return true;
        }
    }