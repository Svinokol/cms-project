<?php
/**
 * Created by PhpStorm.
 * User: efim
 * Date: 07.02.14
 * Time: 23:44
 */

namespace registration
{
    class Registration
    {
        public function __construct($mysql)
        {
            $configController = new \ConfigController(__DIR__);
            $configController->setValue("template_name","Clear");
            $configController->setValue("template_main","main.tpl");
            $moduleController = new \ModuleController(__DIR__);
            $templateController = new \TemplateController(new \Template($configController->getValue("template_name"),__DIR__));
            $this->core = new \Core($mysql,$configController,$moduleController,$templateController);
            $this->error = "";
        }

        private $core;

        private function post()
        {
            if(isset($_POST["registration_submit"]))
            {
                try
                {

                    $fname = trim(htmlspecialchars(stripslashes($_POST["fname"])));

                    $lname = trim(htmlspecialchars(stripslashes($_POST["lname"])));
                    $email = strtolower(trim(htmlspecialchars(stripslashes($_POST["email"]))));
                    $password = sha1($this->core->getConfigParam("unique_salt").trim(htmlspecialchars(stripslashes($_POST["password"]))));
                    $avatar = "";
                    if(isset($_FILES['avatar'])){
                        $avatar = $this->core->addFile($_FILES['avatar']);
                    }
                    //echo($_POST['avatar']['name']);
                    $query="INSERT INTO Users (email,fname,lname,photo,permission,pass,user_hash,ip) VALUES ('".$email."','".$fname."','".$lname."','".$avatar."',5,'".$password."','','".$_SERVER["REMOTE_ADDR"]."');";
                    $this->core->queryToDataBase($query);
                    $this->core->setFileFromTemplate("success.tpl");
                }catch (\Exception $ex)
                {
                    $this->error = $ex->getMessage();
                }
            }
        }

        private $error;


        public function main()
        {
            $this->post();
            if(strlen($this->error)!=0)
            {
                $this->core->addCascade("{error_msg}",$this->error);
                $this->core->addCascade("{error}",1);
            }
            else
            {
                $this->core->addCascade("{error}",0);
            }
            return $this->core->init();
        }

    }
    function main(\IDataBase $mysql)
    {
        $reg = new Registration($mysql);
        return $reg->main();
    }
}

?>