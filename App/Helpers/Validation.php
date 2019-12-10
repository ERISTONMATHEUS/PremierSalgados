<?php

    class Validation
    {
        /*
        * var The data to validade:
        */
        private $data = [];

        /*
        * var The rules to apply:
        */
        private $rules = [];

        /*
        * var Errors found during validation:
        */
        private $errors;

        private $cache = [];

        private $messages = [
            'required' => 'O campo deve ser preenchido!',
            'number'   => 'Preencha um valor numérico!',
            'price'    => 'Preencha no formato de dinheiro!',
            'date'     => 'Formato incorreto!',
        ];

        public function __construct($data, $rules)
        {
            $this->data = $data;
            $this->rules = $rules;
        }

        public function hasErrors()
        {
            return ($this->errors > 0);
        }

        public function getCache()
        {
            return $this->cache;
        }

        public function run()
        {
            if(empty($this->data) or empty($this->rules)){
                return true;
            }

            foreach($this->data as $name => $value){
                if(isset($this->rules[$name])){
                    $rules = explode(',', $this->rules[$name]);

                    foreach($rules as $rule){
                        if(!in_array('required', $rules) and $value === ''){

                            $this->cache[$name]['data']  = $value;

                            continue;
                        }elseif(!$this->$rule($value)){
                            $this->errors++;

                            $this->cache[$name]['error'] = $this->messages[$rule];
                            $this->cache[$name]['data']  = $value;

                            break;
                        }else{
                            $this->cache[$name]['data'] = $value;
                            continue;
                        }
                    }
                }
            }
        }

        public function saveCache()
        {
            $_SESSION['validation'] = $this->getCache();

            return true;
        }

        public function required($data)
        {
            return ($data != '');
        }

        public function number($data)
        {
            return is_numeric($data);
        }

        public function date($data)
        {
            return preg_match('#([0-9]{2})(\/)([0-9]{2})(\/)([0-9]{4})#' ,$data);
        }

        public function price($data)
        {
            return preg_match('#([0-9\.\,]{1,})#' ,$data);
        }
    }