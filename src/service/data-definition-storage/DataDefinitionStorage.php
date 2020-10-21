<?php

require_once("GenerateFile.php");

class GenDataDefinitionStorage extends GenerateFile {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/", "data-definition-storage.service.ts");

  }

  protected function generateCode(){
    $this->importsStart();
    $this->classStart();
    $this->storage();
    $this->storageEntity();
    $this->classEnd();
  }

  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';

import { SessionStorageService } from '@service/storage/session-storage.service';

";
  }

  protected function classStart(){
    $this->string .= "
@Injectable({
  providedIn: 'root'
})
export class DataDefinitionStorageService {

  constructor(protected stg: SessionStorageService){ }

";
  }

  protected function storage(){
    require_once("service/data-definition-storage/_storage.php");
    $gen = new GenDataDefinitionStorage_storage($this->structure);
    $this->string .= $gen->generate();
  }

  protected function storageEntity(){
    require_once("service/data-definition-storage/_storageEntity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionStorage_storageEntity($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
