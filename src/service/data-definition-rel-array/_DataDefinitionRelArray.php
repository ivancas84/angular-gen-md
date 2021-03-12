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
import { Observable } from 'rxjs';
import { map, switchMap } from 'rxjs/operators';
import { Display } from '@class/display';
import { DataDefinitionToolService } from '@service/data-definition/data-definition-tool.service';
";
  }

  protected function classStart(){
    $this->string .= "
@Injectable({
  providedIn: 'root'
})
export class _DataDefinitionRelArrayService {
  /**
   * Define un array de relaciones, 
   * utilizando metodos que consultan el storage,
   * para reducir las consultas al servidor.
   * La estructura resultante, puede ser utilizada directamente 
   * en una tabla de visualizacion, facilitando el ordenamiento,
   * ya que cada campo se identifica con el prefijo correspondiente
   * de la entidad relacionada
   */

  constructor(protected dd: DataDefinitionToolService){ }

";
  }

  protected function main(){
    require_once("service/data-definition-rel-array/_main.php");
    $gen = new GenDataDefinitionRelArray_main($this->structure);
    $this->string .= $gen->generate();
  }

  protected function entity(){
    require_once("service/data-definition-rel-array/entity/entity.php");
    foreach($this->structure as $entity){
      $gen = new GenDataDefinitionRelArray_entity($entity);
      $this->string .= $gen->generate();
    }
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
