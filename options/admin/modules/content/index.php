<?php    
    function main(IDataBase $db,Template $template){
        return $template->getHtml("sidebar.tpl");
    }
?>
