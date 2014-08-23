<?php
    
    
    class Mysql implements IDataBase{

        public function Mysql($server,$user,$password,$dbname){   

            $this->mysqli = new mysqli($server, $user, $password, $dbname);
            if ($this->mysqli->connect_error) {
                throw new Exception('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
            }
        }

        private $mysqli;
        
        public function query($query){
           $result = $this->mysqli->query($query);
           if(!$result)
           {
               throw new ErrorException("Ошибка: ".$this->mysqli->error);
           }
           return $result;
        }

    }
?>
