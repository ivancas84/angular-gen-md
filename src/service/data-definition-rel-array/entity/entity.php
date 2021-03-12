<?php

require_once("GenerateEntity.php");


class GenDataDefinitionRelArray_entity extends GenerateEntity {

  protected function hasRelations(){ return ($this->getEntity()->hasRelations()) ? true : false; }

  
  public function generate() {
    $this->start();
    $this->pipe();
    $this->fk();
  }


  protected function start(){
    $this->string .= "  " . $this->entity->getName("xxYy"). "(display: Display): Observable<any> {
    return this.dd.all(\"" . $this->entity->getName(). "\", display)";
  }

  public function pipe(){
    if($this->hasRelations())   $this->string .= ".pipe(
";
  }

  protected function fk(){
    new GenerateEntityElement
  }

  protected function end(){
    $this->string .= "          ])
        }
      ),
      map(
        response => { return (!response)? null : response.join(\" \"); }
      )
    );
  }

";
  }




}
