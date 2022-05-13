<?php

require_once("Generate.php");

class GenDataDefinitionLabel_label extends Generate {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
  }

  public function generate(){
    $this->start();
    $this->body();
    $this->end();
    return $this->string;
  }


  protected function start(){
    $this->string .= "  label(entityName: string, id: string): Observable<string> {
    switch(entityName) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "      case \"" . $entity->getName() . "\": { return this.label" . $entity->getName("XxYy") . "(id); }
";
      }
  }

  protected function end(){
    $this->string .= "      default: return of(\"\");
    }
  }
";
  }

  

}
