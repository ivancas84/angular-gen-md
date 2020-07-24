<?php

require_once("GenerateFile.php");

class DataDefinitionLoaderService extends GenerateFile {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/", "data-definition-loader.service.ts");

  }

  protected function generateCode(){
    $this->importsStart();
    $this->importsDataDefinition();
    $this->classStart();
    $this->methodGet();
    $this->classEnd();
  }

  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';

import { SessionStorageService } from '../core/service/storage/session-storage.service';
import { ParserService } from '../core/service/parser/parser.service';
import { DataDefinition } from '../core/class/data-definition';

";
  }

  protected function importsDataDefinition(){
    foreach($this->structure as $entity){
      $this->string .= "import { " . $entity->getName("XxYy") . "DataDefinition } from '../class/data-definition/" . $entity->getName("xx-yy") . "-data-definition';
";
    }
  }

  protected function classStart(){
    $this->string .= "
@Injectable({
  providedIn: 'root'
})
export class DataDefinitionLoaderService {

  constructor(protected stg: SessionStorageService, protected parser: ParserService){ }

";
  }

  protected function methodGet(){
    require_once("service/data-definition-loader/_get.php");
    $gen = new DataDefinitionLoaderService_get($this->structure);
    $this->string .= $gen->generate();
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
