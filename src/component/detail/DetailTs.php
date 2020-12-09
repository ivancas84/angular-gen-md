<?php

require_once("GenerateFileEntity.php");

class Gen_DetailTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/detail/" . $entity->getName("xx-yy") . "-detail/";
    $file = $entity->getName("xx-yy") . "-detail.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode() {
    $this->string .= "import { Component } from '@angular/core';
import { DetailComponent } from '@component/detail/detail.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-detail',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-detail.component.html',
})
export class " . $this->entity->getName("XxYy") . "DetailComponent extends DetailComponent {
  readonly entityName: string = \"" . $this->entity->getName() . "\";

}

";
  }





}
