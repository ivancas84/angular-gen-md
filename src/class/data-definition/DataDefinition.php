<?php

require_once("GenerateFileEntity.php");

class ClassDataDefinition extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/class/data-definition/";
    $file = $entity->getName("xx-yy") . "-data-definition.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->string .= "import { _" . $this->entity->getName("XxYy") . "DataDefinition } from './_" . $this->entity->getName("xx-yy") . "-data-definition';

export class " . $this->entity->getName("XxYy") . "DataDefinition extends _" . $this->entity->getName("XxYy") . "DataDefinition { }
";
  }


}
