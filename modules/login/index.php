<?php
/**
 * Created by PhpStorm.
 * User: efim
 * Date: 04.02.14
 * Time: 13:53
 */
namespace login
{

    class Login
    {
        public function __construct($mysql)
        {
            $configController = new \ConfigController(__DIR__);
            $moduleController = new \ModuleController(__DIR__);
            if($configController->getValue("install")=="install")
            {
                include_once("install.php");
                $function = new \ReflectionFunction('install\main');
                $function->invoke($configController);
            }
            $templateController = new \TemplateController(new \Template($configController->getValue("template_name"),__DIR__));
            $this->core = new \Core($mysql,$configController,$moduleController,$templateController);
            $this->core->addCascade("{template}",'modules/'.basename(__DIR__)."/templates/".$configController->getValue("template_name"));

        }

        private $core;

        private $error;



        private function post()
        {
            if(isset($_POST['login_submit']))
            {
                try{
                    $email = strtolower(trim(htmlspecialchars(stripslashes($_POST['email']))));
                    $password = sha1($this->core->getConfigParam("unique_salt").trim(htmlspecialchars(stripslashes($_POST['password']))));
                    $res = $this->core->queryToDataBase("SELECT * FROM Users WHERE pass='".$password."' AND email='".$email."';");
                    if($res->num_rows!=0)
                    {
                        $row = $res->fetch_assoc();
                        setcookie("id", $row["id"], time()+60*60*24*30);
                        $hash = md5($this->core->generateCode(22));
                        setcookie("hash", $hash, time()+60*60*24*30);
                        $this->core->queryToDataBase("UPDATE Users SET user_hash='".$hash."',ip='".$_SERVER["REMOTE_ADDR"]."' WHERE id=".$row["id"].";");
                        $res->free();
                        if(isset($_SERVER['HTTP_REFERER']))
                        {
                            header("Location:".$_SERVER['HTTP_REFERER']);
                        }
                        else
                        {
                            header("Location:".$_SERVER['SERVER_NAME']);
                        }

                    }
                    else
                    {
                        $this->error = "Введена неправильная пара логин и пароль!";
                    }

                }
                catch (\Exception $ex)
                {
                    $this->error = $ex->getMessage();
                }
            }
        }

        private function get()
        {
            if(isset($_GET['logout']))
            {
                if($_GET['logout']=="true")
                {
                    setcookie("id", "", time() + 3600*24*30*12);
                    setcookie("hash", "", time() + 3600*24*30*12);
                    if(isset($_SERVER['HTTP_REFERER']))
                    {
                        header("Location:".$_SERVER['HTTP_REFERER']);
                    }
                    else
                    {
                        header("Location:".$_SERVER['SERVER_NAME']);
                    }
                }
            }
        }

        public function init()
        {
            $this->error = "";
            $this->get();
            if(isset($_POST['login_submit']))
            {
                $this->post();
            }
            else
            {

                $user = $this->core->getCurrentUser();
                if($user->getId()!=-1)
                {
                    $this->core->addCascade("{user}",$user->getAccessLevel());
                    $this->core->addCascade("{photo}",$user->getPhoto());
                    $this->core->addCascade("{fname}",$user->getFirstName());
                    $this->core->addCascade("{lname}",$user->getLastName());
                    $this->core->setFileFromTemplate("profile.tpl");
                }
            }

            $this->core->addCascade("{error_msg}",$this->error);
            if(strlen($this->error)!=0)
            {
                $this->core->addCascade("{error_msg}",$this->error);
                $this->core->addCascade("{error}",1);
            }
            else
            {
                $this->core->addCascade("{error}",0);
            }
            $result = $this->core->init();
            return $result;

        }

    }

    function main($mysql)
    {
        $login = new Login($mysql);
        return $login->init();
    }


}
?>