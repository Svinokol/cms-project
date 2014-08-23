<?php
    class ModuleController{

        function ModuleController($dir)
        {
           $this->addFromLocalPath($dir);
        }

        private $array = array();

        public function addFromLocalPath($dir)
        {          
            $dir = $dir.'/modules/';
            if(is_dir($dir)){
                $arr = scandir($dir);            
                foreach($arr as $key => $value)
                {
                    try
                    {
                        
                        if(is_dir($dir.$value)&&($value!=".")&&($value!=".."))
                        {
                            $this->array["{".$value."}"] = new Module($dir.$value);
                        }       
                                   
                    }
                    catch(Exception $ex)
                    {
                        throw $ex;
                    }
                }
            }
        }

        public function addModule($name,Module $module)
        {
            $this->array[$name] = $module;
        }

        public function getModule($name)
        {
            return $this->array[$name];
        }
          
        public function getArray(){
            return $this->array;
        }
    }
?>