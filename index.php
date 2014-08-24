<?php
    include_once("options/Core.php");
    class Index
    {
        public function Index()
        {
            //ini_set("output_buffering", "On");
            $configController = new ConfigController(__DIR__);
            $moduleController = new ModuleController(__DIR__);
            $this->mysql = new Mysql(
                $configController->getValue("mysql_server"),
                $configController->getValue("mysql_user"),
                $configController->getValue("mysql_password"),
                $configController->getValue("mysql_db_name")
            );
            $templateController = new TemplateController(new Template($configController->getValue("template_name"),__DIR__));
            $this->core = new Core($this->mysql,$configController,$moduleController,$templateController);
            $this->core->addCascade("{title}",$configController->getValue("title"));
            $this->core->addCascade("{template}","/templates/".$configController->getValue("template_name"));
            $this->core->addCascade("{headers}",'
            <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
            <script src="https://code.jquery.com/jquery.js"></script>
            ');
            $function =  function ($text,$args)
            {
                if(isset($args["on"]))
                {
                    if($args["on"]==0)
                    {
                        return "";
                    }
                }
                return $text;
            };
            $this->core->setMask("visible",$function);
            $function =  function ($text,$args)
            {
                if(isset($args["user"])&&(isset($args["access"])))
                {
                    $user = intval($args["user"]);
                    $access = intval($args["access"]);
                    if($user>$access)
                    {
                        return "";
                    }
                }
                return $text;
            };
            $this->core->setMask("group",$function);
        }
        private $mysql;
        private $core;

        private function get()
        {

            if(isset($_GET['go']))
            {
                $go = $_GET['go'];
            }
            else
            {
                $go = $this->core->getConfigParam('home_page');
            }
            $modules = $this->core->getModulesArray();
            if(isset($modules["{".$go."}"]))
            {
                $module = $modules["{".$go."}"];
                $this->core->addCascade("{content}",$module->getHtml($this->mysql));
            }
            else
            {
                $this->core->addCascade("{content}","Ошибка 404:Такой страницы не существует!");

            }



        }

        private function post()
        {

        }

        public function main()
        {
            $this->get();
            $this->post();
            $html = $this->core->init();
            echo $html;
        }
    }
    try
    {
        $index = new Index();
        $index->main();
    }
    catch (Exception $ex)
    {
        echo($ex->getMessage());
    }

?>
