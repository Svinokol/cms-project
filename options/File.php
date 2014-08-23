<?php
    class File
    {
        function File($name,$tmp_name,$type,$error,$size)
        {
            $this->name = $name;
            $this->tmp_name = $tmp_name;
            $this->type = $type;
            $this->error = $error;
            $this->size = $size;
        }

        private $name;

        private $tmp_name;

        private $type;

        private $error;

        private $size;

        public function getName()
        {
            return $this->name;
        }

        public function getTmpName()
        {
            return $this->tmp_name;
        }

        public function getType()
        {
            return $this->type;
        }

        public function getError()
        {
            return $this->error;
        }

        public function getSize()
        {
            return $this->size;
        }
    }
?>

