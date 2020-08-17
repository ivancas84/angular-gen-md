
<?php
require_once("GenerateFileEntity.php");

class Gen_SearchParamsTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    $file = $entity->getName("xx-yy") . "-search-params.component.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->start();
    $this->constructor();
    $this->formGroup();
    $this->getters();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';
import { Display } from '@class/display';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { SearchParamsComponent } from '@component/search-params/search-params.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search-params',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search-params.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchParamsComponent extends SearchParamsComponent {

";
  }

  public function constructor(){
    $this->string .= "  constructor (
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService
  ) { super(fb); }

";
  }

  protected function formGroup(){
    require_once("component/searchParams/_FormGroup.php");
    $gen = new Gen_SearchParamsTs_formGroup($this->entity);
    $this->string .= $gen->generate();
  }
  
  protected function getters(){
    foreach($this->entity->getFieldsByType(["nf","fk"]) as $field){
      switch($field->getDataType()){
        case "textarea": break;
        default: $this->string .= "  get {$field->getName('xxYy')}() { return this.fieldset.get('{$field->getName()}')}
"; 
      }
      
    }
    $this->string .= "
";
  }

  protected function end(){
    $this->string .= "}
";
  }





}
