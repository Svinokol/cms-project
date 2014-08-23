<?php

    class User implements IUser
    {
        
        private $first_name;

        private $last_name;

        private $email;

        private $id;

        private $bdate;

        private $access;

        private $photo;

        public function __construct($first_name,$last_name,$email,$id,$bdate,$access,$photo)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->email = $email;
            $this->id = $id;
            $this->bdate = $bdate;
            $this->access = $access;
            $this->photo = $photo;
        }

        public function getPhoto()
        {
            return $this->photo;
        }

        public function getFirstName()
        {
            return $this->first_name;
        }

        public function getLastName()
        {
            return $this->last_name;
        }

        public function getBdate()
        {
            return $this->bdate;
        }

        public function getAccessLevel()
        {
            return $this->access;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getEmail()
        {
            return $this->email;
        }
    }
?>
