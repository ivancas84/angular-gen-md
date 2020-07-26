<?php

require_once("GenerateEntity.php");
require_once("class/controller/StructTools.php");

class Gen_initOptions extends GenerateEntity {

  public function generate($entities = NULL) {
    switch($entities){
      case "unique_multiple": $this->entities = StructTools::getEntityRefBySubtypeSelectUniqueMultiple($this->entity); break;
      default: $this->entities = StructTools::getEntityRefBySubtypeSelect($this->entity); break;
    }
    if(!count($this->entities)) return;
    $this->start();
    $this->body();
    $this->end();

    return $this->string;
  }

  protected function start() {
    $this->string .= "  initOptions(): void {
";
  }

  protected function body() {
    foreach($this->entities as $entity){
      $this->string .= "    this.opt{$entity->getName('XxYy')}$ = this.dd.all('{$entity->getName()}', new Display);
";
    }
  }

  protected function end() {
    $this->string .= "  }

";
  }
}
