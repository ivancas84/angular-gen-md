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
    $this->filterFields();
    $this->get();
    $this->getAll();
    $this->entityGetAll();
    $this->entityGet();
    $this->classEnd();
  }

  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { switchMap } from 'rxjs/operators';
import { DataDefinitionToolService } from '@service/data-definition/data-definition-tool.service';
import { isEmptyObject } from '@function/is-empty-object.function';

";
  }

  protected function classStart(){
    $this->string .= "
@Injectable({
  providedIn: 'root'
})
export class _DataDefinitionRelArrayService { //2
  /**
   * Define un array de relaciones, utilizando metodos que consultan el storage,
   * 
   * La estructura resultante, puede ser utilizada directamente en una tabla de visualizacion.
   * 
   * Gracias al storage y la identificacion de fields, 
   * reduce los accesos al servidor y facilita el ordenamiento
   * 
   * La identificacion de fields es distinta de la que hace el servidor.
   * En el servidor habitualmente se utiliza '-' para las consultas 
   * y '_' representar el resultado, 
   */

  constructor(protected dd: DataDefinitionToolService){ }

";
  }

  protected function filterFields(){
    $this->string .= "    filterFields(fields, prefix) {
      var f = {}
      for(var key in fields){
        if(fields.hasOwnProperty(key)){
          if(key.includes(prefix)) f[key] = fields[key];
        }
      }
      return f;
    }

";          

  }
  protected function get(){
    require_once("service/data-definition-rel-array/_get.php");
    $gen = new GenDataDefinitionRelArray_get($this->structure);
    $this->string .= $gen->generate();
  }

  protected function getAll(){
    require_once("service/data-definition-rel-array/_getAll.php");
    $gen = new GenDataDefinitionRelArray_getAll($this->structure);
    $this->string .= $gen->generate();
  }

  protected function entityGetAll(){
    require_once("service/data-definition-rel-array/getAll/entity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionRelArray_entityGetAll($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function entityGet(){
    require_once("service/data-definition-rel-array/get/entity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionRelArray_entityGet($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
