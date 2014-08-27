<?php
/**
 * Created by PhpStorm.
 * User: efim
 * Date: 15.02.14
 * Time: 10:13
 */
namespace paint
{
    class Paint
    {
        function __construct(\IDataBase $database)
        {
            $moduleController = new \ModuleController(__DIR__);
            $configController = new \ConfigController(__DIR__);
            $configController->setValue("template_main","main.tpl");
            $configController->setValue("template_name","Clear");
            $templateController = new \TemplateController(new \Template($configController->getValue("template_name"),__DIR__));
            $this->core = new \Core($database,$configController,$moduleController,$templateController);

            $convertedPath = mb_convert_encoding($templateController->getPath(),
                'utf-8',
                'Windows-1251');
            $this->core->addCascade("{template}",basename($templateController->getPath()));
        }

        private $core;





        public function main()
        {

            return $this->core->init();
        }
    }
   function main(\IDataBase $mysql)
   {
        $paint = new Paint($mysql);
        return $paint->main();
   }
}

?>