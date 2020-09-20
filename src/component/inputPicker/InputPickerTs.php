<?php

require_once("GenerateFileEntity.php");

class GenInputPickerTs extends GenerateFileEntity {

  protected $options = []; //opciones

  public function __construct(Entity $entity) {
    $file = $entity->getName("xx-yy") . "-input-picker.component.ts";
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/input-picker/" . $entity->getName("xx-yy") . "-form-pick/";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    if(!$this->entity->getFieldsUniqueMultiple()) return "";
    $this->start();
    $this->constructor();
    $this->formGroup();
    $this->getters();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { InputPickerComponent } from '@component/input-picker/input-picker.component';
import { FormBuilder, Validators } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-input-picker',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-input-picker.component.html',
})
export class " . $this->entity->getName("XxYy") . "InputPickerComponent extends InputPickerComponent {

  readonly entityName: string = '" . $this->entity->getName() . "';

";
  }

  protected function constructor(){
    $this->string .= "  constructor(
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService
  ) {
    super(fb, dd);
  }

";
  }

  protected function getters(){
    foreach($this->entity->getFieldsUniqueMultiple() as $field){
      $this->string .= "  get {$field->getName('xxYy')}() { return this.form.get('{$field->getName()}')}
";
    }
    $this->string .= "
";
  }

  protected function formGroup(){
    require_once("component/inputPicker/_FormGroup.php");
    $gen = new GenInputPicker_formGroup($this->entity);
    $this->string .= $gen->generate();
  }



  protected function end(){
    $this->string .= "}
";
  }

}
