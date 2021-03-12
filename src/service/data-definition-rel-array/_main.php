<?php

require_once("Generate.php");

class _GenDataDefinitionRelArray_main extends Generate {

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
    $this->string .= "  main(entityName: string, id: string): Observable<string> {
    switch(entityName) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "      case \"" . $entity->getName() . "\": { return this." . $entity->getName("xxYy") . "(display:Display); }
";
      }
  }

  protected function end(){
    $this->string .= "    }
  }
";
  }

  

}
