<?php

require_once("GenerateFileEntity.php");

class Gen_ShowTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    $file = $entity->getName("xx-yy") . "-show.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowComponent } from '@component/show/show.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-show',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-show.component.html',
})
export class " . $this->entity->getName("XxYy") . "ShowComponent extends ShowComponent {

  readonly entityName: string = \"" . $this->entity->getName() . "\";

";
  }

  
  protected function fields(){
    require_once("component/show/_Fields.php");
    $gen = new GenShowTs_fields($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}

";
  }

  protected function generateCode() { //@override
    $this->start();
    $this->fields();
    $this->end();
  }

}
