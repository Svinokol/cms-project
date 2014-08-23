<?php
    
    class ConfigController{

        private $array;

        private $config = array();
   

        private function intialize(){
            $url = $this->url.'/options/config.php';
            $text = file_get_contents($url);
            $text = base64_decode($text);                                  
            $this->array = @unserialize($text);
            if(!is_array($this->array))
            {
                $this->array = array();
            }
        }
        private $url;
        function ConfigController($url){
            $this->url = $url;
            $this->intialize();
        }

        public function setValue($key,$value)
        {
            $this->array[$key] = $value;
        }

        public function getValue($key)
        {
            $result = "";
            if(isset($this->array[$key]))
            {
                $result = $this->array[$key];
            }
            else
            {
                $result = $key;
            }
            return $result;
        }

        public function save()
        {
            $url = $this->url.'/options/config.php';
            $text = serialize($this->array);
            $text = base64_encode($text);
            file_put_contents($url,$text);
        }

        public function getArray()
        {
           return $this->array; 
        }

    }

?>