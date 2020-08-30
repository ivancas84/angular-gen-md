<?php

require_once("GenerateFileEntity.php");

class GenTableTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    $file = $entity->getName("xx-yy") . "-table.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  
  protected function generateCode(){
    $this->start();
    $this->body();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { TableComponent } from '@component/table/table.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-table',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-table.component.html',
  styles:[`
  .mat-card-content { overflow-x: auto; }
  .mat-table.mat-table { min-width: 700px; }
  `],
})
export class " . $this->entity->getName("XxYy") . "TableComponent extends TableComponent { 
";        
  }

  protected function body(){
    $names = [];
    foreach($this->entity->getFieldsByType(["nf","fk"]) as $field)  array_push($names, $field->getName());  
    $this->string .= "  displayedColumns: string[] = ['" . implode("', '", $names) . "'];

";
  }

  protected function end(){
    $this->string .= "}
";
  }
  
}

