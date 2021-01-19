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
import { FieldConfig } from '@class/field-config';
import { FieldControl } from '@class/field-control';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-show',
  templateUrl: '../../core/component/show/show.component.html',
})
export class " . $this->entity->getName("XxYy") . "ShowComponent extends ShowComponent {

  readonly entityName: string = \"" . $this->entity->getName() . "\";

";
  }

  
  protected function fieldsConfig(){
    require_once("component/show/_FieldsConfig.php");
    $gen = new GenShowTs_fieldsConfig($this->entity);
    $this->string .= $gen->generate();
  }

  protected function fieldsControlSp(){
    require_once("component/show/_FieldsControlSp.php");
    $gen = new GenShowTs_fieldsControlSp($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}

";
  }

  protected function generateCode() { //@override
    $this->start();
    $this->fieldsConfig();
    $this->fieldsControlSp();
    $this->end();
  }

}
