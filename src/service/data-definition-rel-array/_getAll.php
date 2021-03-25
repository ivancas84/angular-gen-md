<?php

require_once("Generate.php");

class GenDataDefinitionRelArray_getAll extends Generate {

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
    $this->string .= "  getAll(entityName: string, ids:string[], fields: { [index: string]: any }): Observable<any> {
      /**
       * @param fields Ejemplo de estructura, para entityName = 'alumno'
       * {'per-nombres':'nombres', 'per-numero_documento':'numero_documento', 'per_dom-calle':'calle'}
       */
    switch(entityName) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "      case \"" . $entity->getName() . "\": { return this." . $entity->getName("xxYy") . "GetAll(ids, fields); }
";
      }
  }

  protected function end(){
    $this->string .= "    }
  }
";
  }

  

}
