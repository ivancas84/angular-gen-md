<?php

require_once("GenerateFileEntity.php");


class Gen_ShowHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-show.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->string .= "<!-- app-" . $this->getEntity()->getName("xx-yy") . "-search [display$]=\"display\$\"></app-" . $this->getEntity()->getName("xx-yy") . "-search -->
<app-" . $this->getEntity()->getName("xx-yy") . "-table [data$]=\"data$\"></app-" . $this->getEntity()->getName("xx-yy") . "-table>
";

  }
}
