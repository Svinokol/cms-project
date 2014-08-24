<?php
    include_once("../options/Core.php");

    class Install
    {
        public function Install()
        {
            $this->configController = new ConfigController("../");
            $this->moduleController = new ModuleController("../");
            $this->templateController = new TemplateController(new Template("Clear","."));
            if($this->configController->getValue("mysql_server")!="mysql_server"){
                $this->mysql = new Mysql(
                    $this->configController->getValue("mysql_server"),
                    $this->configController->getValue("mysql_user"),
                    $this->configController->getValue("mysql_password"),
                    $this->configController->getValue("mysql_db_name")
                );
            }
        }

        private $configController;
        private $moduleController;
        private $templateController;
        private $mysql;
        private function unique_salt() 
        {  
            return substr(sha1(mt_rand()),0,22);
        } 

        private function post()
        {
            
            if(!isset($_POST["command"]))return;
            switch($_POST["command"])
                    {
                        case "0":
                                $name = $_POST["name"];
                                $email = $_POST["email"];
                                $mysql_server = $_POST["mysql_server"];
                                $mysql_db_name = $_POST["mysql_db_name"];
                                $mysql_user = $_POST["mysql_user"];
                                $mysql_password =$_POST["mysql_password"];

                            $this->configController->setValue("title",$name);
                            $this->configController->setValue("admin_email",$email);
                            $this->configController->setValue("mysql_server",$mysql_server);
                            $this->configController->setValue("mysql_db_name",$mysql_db_name);
                            $this->configController->setValue("mysql_user",$mysql_user);
                            $this->configController->setValue("mysql_password",$mysql_password);
                            $this->configController->setValue("unique_salt",$this->unique_salt());
                            $this->configController->setValue("template_name","Clear");
                            $this->configController->setValue("template_main","main.tpl");
                            $this->configController->save();
                                $this->mysql = new Mysql(
                                    $this->configController->getValue("mysql_server"),
                                    $this->configController->getValue("mysql_user"),
                                    $this->configController->getValue("mysql_password"),
                                    $this->configController->getValue("mysql_db_name")
                                );

                                echo("Настройки сохранены...");                              
                                break;
                        case "1":
                                $query = "DROP TABLE IF EXISTS Users;";
                                $this->mysql->query($query);
                                echo("Подготовка...");                          
                                break;
                        case "2":
                                $query = "CREATE TABLE Users(
                                    id INT(10) AUTO_INCREMENT,
                                    email VARCHAR(100) NOT NULL UNIQUE KEY,
                                    bdate DATE,
                                    fname VARCHAR(100) NOT NULL,
                                    lname VARCHAR(100) NOT NULL,
                                    photo VARCHAR(200),
                                    permission INT(10) NOT NULL,
                                    pass VARCHAR(200) NOT NULL,
                                    user_hash VARCHAR(200) NOT NULL,
                                    ip VARCHAR(200) NOT NULL,
                                    PRIMARY KEY(id)
                                );";
                                $this->mysql->query($query);
                                echo("Создание таблицы пользователей...");                       
                                break;


                    } 
                               
                   
        }

        public function main()
        {
            try
            {
                
                if(isset($_POST["command"]))
                {
                    $this->post();
                }
                else
                {
                    echo $this->templateController->getContent("main.tpl");
                }                                
                
            }
            catch(Exception $ex)
            {
                echo("Произошла ошибка!");
                echo($ex->getMessage());
            }
            
        }
    }
   
    try{
        $install = new Install();
        $install->main();
    }catch(Exception $ex){
        echo($ex->getMessage());
    }
    
?>
