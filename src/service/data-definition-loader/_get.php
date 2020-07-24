<?php

require_once("Generate.php");

class DataDefinitionLoaderService_get extends Generate {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
  }


  protected function start(){
    $this->string .= "  get(name: string): DataDefinition {
    switch(name) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "      case \"" . $entity->getName() . "\": { return new " . $entity->getName("XxYy") . "DataDefinition(this.stg, this.parser); }
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
