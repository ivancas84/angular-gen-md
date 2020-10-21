<?php

require_once("GenerateFile.php");

class _GenDataDefinitionLabel extends GenerateFile {

  protected $structure;

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/data-definition-label/", "_data-definition-label.service.ts");
  }

  protected function generateCode(){
    $this->importsStart();
    $this->classStart();
    $this->label();
    $this->labelEntityRow();

    $this->labelEntity();

    $this->classEnd();
  }

  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';

import { DataDefinitionService } from '@service/data-definition/data-definition.service';
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
export class _DataDefinitionLabelService {

  constructor(protected dd: DataDefinitionService){ }

";
  }

  protected function label(){
    require_once("service/data-definition-label/_label.php");
    $gen = new GenDataDefinitionLabel_label($this->structure);
    $this->string .= $gen->generate();
  }

  protected function labelEntity(){
    require_once("service/data-definition-label/_labelEntity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionLabel_labelEntity($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function labelEntityRow(){
    require_once("service/data-definition-label/_labelEntityRow.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionLabel_labelEntityRow($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
