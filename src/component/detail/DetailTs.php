<?php

require_once("GenerateFileEntity.php");

class GenDetailTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/detail/" . $entity->getName("xx-yy") . "-detail/";
    $file = $entity->getName("xx-yy") . "-detail.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode() {
    $this->start();
    $this->fields();
    $this->end();
  }

  protected function start() {
    $this->string .= "import { Component } from '@angular/core';
import { DetailComponent } from '@component/detail/detail.component';
import { FieldConfig } from '@class/field-config';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-detail',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-detail.component.html',
})
export class " . $this->entity->getName("XxYy") . "DetailComponent extends DetailComponent {
  readonly entityName: string = \"" . $this->entity->getName() . "\";
";
  }
  
  protected function fields() {
    require_once("component/detail/_fields.php");
    $gen = new GenDetailTs_fields($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end() {
    $this->string .= "
}

";
  }









}
