<?php

require_once("GenerateEntity.php");
require_once("class/controller/StructTools.php");


class Gen_declareOptions extends GenerateEntity {
 

  public function generate($entities = NULL) {
    switch($entities){
      case "unique_multiple": $this->entities = StructTools::getEntityRefBySubtypeSelectUniqueMultiple($this->entity); break;
      default: $this->entities = StructTools::getEntityRefBySubtypeSelect($this->entity); break;
    }

    if(!count($this->entities)) return;
    $this->start();
    $this->end();

    return $this->string;
  }

  public function start(){
    foreach($this->entities as $entity){
      $this->string .= "  opt{$entity->getName('XxYy')}$: Observable<Array<any>>;
";
    }
  }

  public function end(){
    $this->string .= "
";
  }

}
