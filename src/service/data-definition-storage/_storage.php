<?php

require_once("Generate.php");

class GenDataDefinitionStorage_storage extends Generate {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
  }


  protected function start(){
    $this->string .= "  storage(entityName: string, row: { [index: string]: any }): void {
    switch(entityName) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "      case \"" . $entity->getName() . "\": this.storage" . $entity->getName("XxYy") . "(row); break;
";
      }
  }

  protected function end(){
    $this->string .= "    }
  }
";
  }

  public function generate(){
    $this->start();
    $this->body();
    $this->end();
    return $this->string;
  }


}
