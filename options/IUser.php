<?php
    
    interface IUser{

        public function getId();

        public function getEmail();

        /**
            int getAccessLevel(); return int value
            1 - administrator
        **/

        public function getAccessLevel();
    }

?>