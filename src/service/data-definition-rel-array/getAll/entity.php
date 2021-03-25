<?php

require_once("GenerateEntity.php");


class GenDataDefinitionRelArray_entityGetAll extends GenerateEntity {

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
    $this->string .= "  " . $this->entity->getName("xxYy"). "GetAll(ids: string[], fields: { [index: string]: any }): Observable<any> {
    return this.dd.getAll(\"" . $this->entity->getName(). "\", ids)";
  }

  public function pipeStart(){
    if($this->hasRelations())   $this->string .= ".pipe(
";
  }

  protected function entityElement(){    
    require_once("service/data-definition-rel-array/getAll/entityElement.php");
    $g = new GenDataDefinitionRelArray_entityElementGetAll($this->entity);
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
