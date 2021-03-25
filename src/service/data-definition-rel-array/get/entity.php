<?php

require_once("GenerateEntity.php");


class GenDataDefinitionRelArray_entityGet extends GenerateEntity {

  protected function hasRelations(){ return ($this->getEntity()->hasRelations()) ? true : false; }

  
  public function generate() {
    $this->start();
    $this->pipeStart();
    $this->entityElement();
    $this->pipeEnd();
    $this->end();
    return $this->string;
  }


  protected function start(){
    $this->string .= "  " . $this->entity->getName("xxYy"). "Get(id: string, fields: { [index: string]: any }): Observable<any> {
    return this.dd.get(\"" . $this->entity->getName(). "\", id)";
  }

  public function pipeStart(){
    if($this->hasRelations())   $this->string .= ".pipe(
";
  }

  protected function entityElement(){    
    require_once("service/data-definition-rel-array/get/entityElement.php");
    $g = new GenDataDefinitionRelArray_entityElementGet($this->entity);
    $this->string .= $g->generate();
  }

  public function pipeEnd(){
    if($this->hasRelations())  $this->string .= "    )
";
  }

  protected function end(){
    $this->string .= "  }
    
";
  }




}
