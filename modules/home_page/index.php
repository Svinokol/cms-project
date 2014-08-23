<?php
namespace home_page
{
    function main($mysql)
    {


            $configController = new \ConfigController(__DIR__);
            $moduleController = new \ModuleController(__DIR__);

            //echo(__DIR__);
            if($configController->getValue("install")=="install")
            {
                include_once("install.php");
                $function = new \ReflectionFunction('install\main');
                $function->invoke($configController);
            }
            $templateController = new \TemplateController(new \Template($configController->getValue("template_name"),__DIR__));
            $core = new \Core($mysql,$configController,$moduleController,$templateController);
            return $core->init();
    }
}
?>
