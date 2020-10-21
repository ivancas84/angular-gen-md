<?php

require_once("GenerateFile.php");

class GenDataDefinitionLabel extends GenerateFile {

  protected $structure;

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/data-definition-label/", "data-definition-label.service.ts");
  }

  protected function generateCode(){
    $this->string .= "import { Injectable } from '@angular/core';

import { _DataDefinitionLabelService } from '@service/data-definition-label/_data-definition-label.service';

@Injectable({
  providedIn: 'root'
})
export class DataDefinitionLabelService extends _DataDefinitionLabelService{ }
";
  }

}
