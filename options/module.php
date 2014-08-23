<?php
    class Module{

        private $name;

        private $version;

        private $index;

        private $options;

        private $about;

        private $install;

        private $icon;

        private $image;

        private $url;

        private $template;

        private $namespace;

        public $meta;

        public function Module($url){
            $this->url = $url;           
            $this->meta = array();
            $fp = fopen($url."/meta.info",'r');
            if($fp){
                while(!feof($fp)){
                    $text = fgets($fp,999);
                    $arr = explode(":",$text);
                    $this->meta[trim($arr[0])] = trim($arr[1]);
                    switch(trim($arr[0])){
                        case "template":
                                $this->template = trim($arr[1]);
                                break;
                        case "about":
                                $this->about = trim($arr[1]);
                                break;
                        case "name":
                                $this->name = trim($arr[1]);
                                break;
                        case "version":
                                $this->version = trim($arr[1]);
                                break;
                        case "index":
                                $this->index = trim($arr[1]);
                                break;
                        case "options":
                                $this->options = trim($arr[1]);
                                break;
                        case "install":
                                $this->install = trim($arr[1]);
                                break;
                        case "icon":
                                $this->icon = trim($arr[1]);
                                break;
                        case "image":
                                $this->image = trim($arr[1]);
                                break; 
                        case "namespace":
                                $this->namespace = trim($arr[1]);
                                break;                        
                    }
                }
            }else{
                throw new Exception('Не удалось открыть модуль.');
            }
            

        }        

        public function getName(){
            return $this->name;
        }

        public function getVersion(){
            return $this->version;
        }

        public function getIndex(){
           return $this->index; 
        }

        public function getInstall(){
            return $this->install;            
        }

        public function getOptions(){
            return $this->options;
        }

        public function getHtml($mysql){
           include_once($this->url."/".$this->index);
           $function = new ReflectionFunction($this->namespace.'\main');
           return $function->invoke($mysql);
        }
    }
?>
