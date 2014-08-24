<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include_once("Module.php");
    include_once("IDataBase.php");
    include_once("Mysql.php");
    include_once("Template.php");
    include_once("ModuleController.php");
    include_once("ConfigController.php");
    include_once("TemplateController.php");
    include_once("File.php");
    include_once("UploadFile.php");
    include_once("IUser.php");
    include_once("User.php");

    class Core{        

        public function __construct(IDataBase $database,
                                    ConfigController $configController,
                                    ModuleController $moduleController,
                                    TemplateController $templateController)
        {                   
            $this->cascades = array();
            $this->masks = array();
            $this->configController = $configController;
            $this->mysql = $database;
            $this->moduleController = $moduleController;
            $this->templateController = $templateController;
            $this->load_template = $this->configController->getValue("template_main");
        }

        private $cascades;

        private $moduleController;

        private $templateController;

        private $configController;

        private $mysql;

        private $load_template;

        private $masks;

        public function setCookie($name,$value,$time,$host)
        {

        }

        public function setMysql($mysql){
            $this->mysql = $mysql;
        }

        public function getUser($id)
        {
            $res = $this->queryToDataBase("SELECT * FROM Users WHERE id=".$id.";");
            if($res->num_rows!=0)
            {
                $row = $res->fetch_assoc();
                return new User($row["fname"],$row["lname"],$row["email"],$row["id"],$row["bdate"],$row["permission"],$row["photo"]);
            }
            return null;
        }

        public function getCurrentUser()
        {
            //echo($_COOKIE["id"]);
            if(isset($_COOKIE["id"]))
            {
                $id = intval($_COOKIE["id"]);
                $hash = htmlspecialchars(stripslashes($_COOKIE["hash"]));
                $res = $this->queryToDataBase("SELECT * FROM Users WHERE id=".$id." AND user_hash='".$hash."';");

                if($res->num_rows!=0)
                {
                    $row = $res->fetch_assoc();

                    if($row["ip"]==$_SERVER['REMOTE_ADDR'])
                    {

                        return new User($row["fname"],$row["lname"],$row["email"],$row["id"],$row["bdate"],$row["permission"],$row["photo"]);
                    }
                }

            }
            setcookie("id", "", time() + 3600*24*30*12);
            setcookie("hash", "", time() + 3600*24*30*12);
            $user = new User(
                    "ГОСТЬ",
                    "",
                    "",
                    "-1",
                    "",
                    "5",
                    ""
                );

            return $user;

        }

        public function generateCode($length=6)
        {

            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

            $code = "";

            $clen = strlen($chars) - 1;
            while (strlen($code) < $length) {

                $code .= $chars[mt_rand(0,$clen)];
            }

            return $code;

        }

        public function getModulesArray()
        {
            return $this->moduleController->getArray();
        }

        public function setFileFromTemplate($name)
        {
            $this->load_template = $this->configController->getValue($name);
        }

        public function getHtmlFromTemplate($name)
        {
            return $this->templateController->getContent($name);
        }

        public function queryToDataBase($query)
        {
            return $this->mysql->query($query);
        } 

        public function saveConfig()
        {
            $this->configController->save();
        }

        public function addConfigParam($key,$value)
        {
            $this->configController->setValue($key,$value);
        }

        public function getConfigParam($key)
        {
            return $this->configController->getValue($key);
        }

        public function addCascade($name,$value)
        {
            $this->cascades[$name] = $value;
        }

        public function addFile($filePostData)
        {
            $file = new File($filePostData['name'],$filePostData['tmp_name'],$filePostData['type'],$filePostData['error'],$filePostData['size']);
            $upload = new UploadFile();
            return $upload->upload($file);
        }

        public function setMask($name,$function)
        {
            $this->masks[$name] = $function;
        }

        private function getMask($name)
        {
            return $this->masks[$name];
        }

        private function replaceHtml($html)
        {
            $modules = $this->moduleController->getArray();
            //$mask = "/\[nocode\]([\s\S]*)\[\/nocode\]/ius";
            //$values = preg_split($mask,$html);
            $mask = "/\{[a-z_0-9]+\}/i";
            $values = array();
            $offset = 0;
            while(preg_match($mask,$html,$values,PREG_OFFSET_CAPTURE,$offset) != 0)
            {

                foreach($values as $key => $value)
                {
                    if(isset($modules[$value[0]]))
                    {
                        $html = str_replace($value[0],$this->replaceHtml($modules[$value[0]]->getHtml($this->mysql)),$html);
                    }
                    if(isset($this->cascades[$value[0]]))
                    {
                        $html = str_replace($value[0],$this->replaceHtml($this->cascades[$value[0]]),$html);
                    }

                    $offset = $value[1]+ strlen($value[0]);
                }
            }
            $mask = "/\[([a-z_0-9]*)\:([a-z_,=0-9]*)\]([\s\S]*)\[\/\\1\]/ius";
            $values = array();
            $offset = 0;
            while(preg_match($mask,$html,$values,PREG_OFFSET_CAPTURE,$offset) != 0)
            {
                    $pattern = $values[0][0];
                    $name = $values[1][0];
                    $parameters = $this->getArgsForPattern($values[2][0]);
                    $text = $values[3][0];
                    if(isset($this->masks[$name]))
                    {
                        $function = $this->getMask($name);
                        $html = str_replace($pattern,$this->replaceHtml($function($text,$parameters)),$html);
                    }
                    $offset = $values[0][1]+ strlen($values[0][0]);
            }
            return $html;
        }

        private function getArgsForPattern($text)
        {
            $result = array();
            $paramenters = preg_split("/[,]/",$text);
            foreach($paramenters as $value)
            {
                $arr = preg_split("/[=]/",$value);
                $result[$arr[0]]=$arr[1];
            }
            return $result;
        }

        public function init()
        {
            $html = $this->templateController->getContent($this->load_template);
            $html = $this->replaceHtml($html);
            return $html;
        }
              
    }

?>
