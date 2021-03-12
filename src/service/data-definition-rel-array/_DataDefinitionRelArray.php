<?php

require_once("GenerateFile.php");

class _GenDataDefinitionRelArray extends GenerateFile {

  protected $structure;

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/data-definition-rel-array/", "_data-definition-rel-array.service.ts");
  }

  protected function generateCode(){
    $this->importsStart();
    $this->classStart();
    $this->main();
    $this->entity();
    $this->classEnd();
  }

  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';

import { DataDefinitionToolService } from '@service/data-definition-tool/data-definition-tool.service';
import { Parser } from '@class/parser';
import { combineLatest, Observable, of } from 'rxjs';
import { map, switchMap } from 'rxjs/operators';
";
  }

  protected function classStart(){
    $this->string .= "
@Injectable({
  providedIn: 'root'
})
export class _DataDefinitionRelArrayService {

  constructor(protected dd: DataDefinitionToolService){ }

";
  }

  protected function main(){
    require_once("service/data-definition-rel-array/_main.php");
    $gen = new GenDataDefinitionRelArray_main($this->structure);
    $this->string .= $gen->generate();
  }

  protected function entity(){
    require_once("service/data-definition-label/_labelEntity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionLabel_labelEntity($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
