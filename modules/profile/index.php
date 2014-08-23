<?php
/**
 * Created by PhpStorm.
 * User: efim
 * Date: 15.02.14
 * Time: 10:13
 */
namespace profile
{
    class Profile
    {
        function __construct(\IDataBase $database)
        {
            $moduleController = new \ModuleController(__DIR__);
            $configController = new \ConfigController(__DIR__);
            $configController->setValue("template_main","main.tpl");
            $configController->setValue("template_name","Clear");
            $templateController = new \TemplateController(new \Template($configController->getValue("template_name"),__DIR__));
            $this->core = new \Core($database,$configController,$moduleController,$templateController);
            $this->user = $this->core->getCurrentUser();
        }

        private $core;

        private $user;

        private function get()
        {
            if(isset($_GET["id"]))
            {
                $user = $this->core->getUser(intval($_GET["id"]));
                if($user!=null)
                {

                }
                else
                {

                }
            }
        }

        private  function  post()
        {

        }

        public function main()
        {
            $this->core->addCascade("{photo}",$this->user->getPhoto());
            $this->core->addCascade("{fname}",$this->user->getFirstName());
            $this->core->addCascade("{lname}",$this->user->getLastName());
            $this->core->addCascade("{email}",$this->user->getEmail());
            $this->core->addCascade("{id}",$this->user->getId());
            $this->core->addCascade("{bdate}",$this->user->getBdate());
            return $this->core->init();
        }
    }
   function main(\IDataBase $mysql)
   {
        $profile = new Profile($mysql);
        return $profile->main();
   }
}

?>