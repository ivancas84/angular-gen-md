<?php

require_once("GenerateEntity.php");


class GenDataDefinitionRelArray_entity extends GenerateEntity {

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
    $this->string .= "  " . $this->entity->getName("xxYy"). "(display: Display): Observable<any> {
    return this.dd.all(\"" . $this->entity->getName(). "\", display)";
  }

  public function pipeStart(){
    if($this->hasRelations())   $this->string .= ".pipe(
";
  }

  protected function entityElement(){    
    require_once("service/data-definition-rel-array/entity/entityElement.php");
    $g = new GenDataDefinitionRelArray_entityElement($this->entity);
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
