<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    class Template
    {

        public function Template($name,$url)
        {
            $this->url = $url.'/templates';
            $this->name = $name;
        }

        private $name;

        private $version;

        private $url; 
        
        private $html;
        
        private $array = array();
        
        public function getName()
        {
            return $this->name;
        }   
        
        public function getArray()
        {
            return $this->array;
        }    

        public function getHtml($name)
        {                          
            $fp = fopen($this->url."/".$this->name.'/'.$name,'r');
            $html = "";          
            if($fp)
            {
                while(!feof($fp))
                {                    
                    $html = $html.fgets($fp,999);
                }
            }else
            {                
                throw new Exception("FILE NOT READ!");
            }
            return $html;
        }
        public function getAbsolutePath()
        {
            return $this->url.'/'.$this->name;
        }

    }

?>