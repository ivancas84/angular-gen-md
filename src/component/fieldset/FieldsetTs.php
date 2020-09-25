<?php

require_once("GenerateFileEntity.php");

class FieldsetTs extends GenerateFileEntity {

  protected $options = []; //opciones

  public function __construct(Entity $entity, $dir=null, $file=null) {
    if(!$file) $file = $entity->getName("xx-yy") . "-fieldset.component.ts";
    if(!$dir) $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset/" . $entity->getName("xx-yy") . "-fieldset/";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    /**
     * Se define una estructura de generacion que facilite su reimplementacion
     */
    $this->imports();
    $this->component();
    $this->attributes();
    $this->defaultValues();
    $this->constructor();
    $this->formGroup();
    $this->getters();
    $this->end();
  }

  protected function imports(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ValidatorsService } from '@service/validators/validators.service';
import { Router } from '@angular/router';
import { SessionStorageService } from '@service/storage/session-storage.service';
";
  }

  protected function component(){
    $this->string .="import { FieldsetComponent } from '@component/fieldset/fieldset.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-fieldset',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-fieldset.component.html',
})
export class " . $this->entity->getName("XxYy") . "FieldsetComponent extends FieldsetComponent {

";
  }

  protected function attributes(){
    $this->string .= "readonly entityName: string = '" . $this->entity->getName() . "';

";
  }

  protected function defaultValues(){
    require_once("component/fieldset/_DefaultValues.php");
    $gen = new FieldsetTs_defaultValues($this->entity);
    $this->string .= $gen->generate();
  }


  protected function constructor(){
    $this->string .= "  constructor(
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService, 
    protected validators: ValidatorsService,
    protected router: Router, 
    protected storage: SessionStorageService 
  ) {
    super(router, storage);
  }

";
  }


  protected function getters(){
    foreach($this->entity->getFieldsByType(["pk","nf","fk"]) as $field){
      if(!$field->isAdmin()) continue;
      $this->string .= "  get {$field->getName('xxYy')}() { return this.fieldset.get('{$field->getName()}')}
";
    }
    $this->string .= "
";
  }

  protected function formGroup(){
    require_once("component/fieldset/_FormGroup.php");
    $gen = new FieldsetTs_formGroup($this->entity);
    $this->string .= $gen->generate();
  }

  protected function server(){
    require_once("component/fieldset/_Server.php");
    $gen = new ComponentFieldsetTs_server($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }

}
