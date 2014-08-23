<?php
    class UploadFile{

        function UploadFile(){
            $this->upload_url = $_SERVER['DOCUMENT_ROOT']."/files";
            
            $arr = scandir($this->upload_url);            
                foreach($arr as $key => $value)
                {                    
                        if(is_dir($this->upload_url."/".$value))
                        {
                            array_push($this->allowed,$value);
                            //echo($value);
                        }                        
                                   
                }
        }

        private $upload_url;

        private $allowed = array();

        public function upload(File $file){
            $extension = pathinfo($file->getName(), PATHINFO_EXTENSION);
            if(!in_array(strtolower($extension), $this->allowed))
            {
                throw new Exception("Ошибка загрузки файла!!Неверное расширение!".strtolower($extension));
            }
            //написать обработчик ошибок
            $name = md5($file->getName());
            $url = "/".strtolower($extension)."/".$name.".".strtolower($extension);
            if(!move_uploaded_file($file->getTmpName(), $this->upload_url.$url))
            {
               throw new Exception("Ошибка загрузки файла!!"); 
            }
            return "/files".$url;
        }

    }
?>
