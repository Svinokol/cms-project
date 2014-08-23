<?php
    
    class TemplateController{

        function TemplateController(Template $template)
        {
            $this->template = $template;
            
        }
        
        private $array = array();      

        private $template;

        public function getPath()
        {
            return $this->template->getAbsolutePath();
        }

        public function selectTemplate($name)
        {
            $this->template = $this->array[$name];
        }

        public function getContent($name)
        {          
            $html = $this->template->getHtml($name);
            return $html;          
        }
    }

?>