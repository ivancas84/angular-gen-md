<?php

require_once("GenerateFile.php");

class GenDataDefinitionRelArray extends GenerateFile {

  protected $structure;

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/data-definition-rel-array/", "data-definition-rel-array.service.ts");
  }

  protected function generateCode(){
    $this->string .= "import { Injectable } from '@angular/core';

import { _DataDefinitionRelArrayService } from '@service/data-definition-rel-array/_data-definition-rel-array.service';

@Injectable({
  providedIn: 'root'
})
export class DataDefinitionRelArrayService extends _DataDefinitionRelArrayService{ }
/**
 * Clase de implementacion
 */

";
  }

}
