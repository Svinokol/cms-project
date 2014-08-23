<?php    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include_once("../core.php");    
    
    class Admin{

        public function Admin(){            
            $this->template = new Template("Clear");
            $this->core = new Core($this->template);
        }

        private $core;

        private $template;

        public function main(){
            try{                
                $html = $this->core->init();
                echo $html;
            }catch(Exception $ex){
                echo($ex->getMessage());
            }
        }
    }
    $admin = new Admin();
    $admin->main();
?>
