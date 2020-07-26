<?php

require_once("GenerateFileEntity.php");

class FieldsetTs extends GenerateFileEntity {

  protected $options = []; //opciones

  public function __construct(Entity $entity) {
    $file = $entity->getName("xx-yy") . "-fieldset.component.ts";
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset/" . $entity->getName("xx-yy") . "-fieldset/";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    $this->declareOptions();
    $this->constructor();
    $this->initOptions();
    $this->formGroup();
    $this->getters();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FieldsetComponent } from '@component/fieldset/fieldset.component';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ValidatorsService } from '@service/validators/validators.service';
import { Observable } from 'rxjs';
import { Display } from '@class/display';
import { Router } from '@angular/router';
import { SessionStorageService } from '@service/storage/session-storage.service';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-fieldset',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-fieldset.component.html',
})
export class " . $this->entity->getName("XxYy") . "FieldsetComponent extends FieldsetComponent {

  readonly entityName: string = '" . $this->entity->getName() . "';

";
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

  protected function declareOptions(){
    require_once("component/_initOptions/_DeclareOptions.php");
    $gen = new Gen_declareOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function initOptions(){
    require_once("component/_initOptions/_InitOptions.php");
    $gen = new Gen_initOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function initData(){
    require_once("component/fieldset/_InitData.php");
    $gen = new Gen_initData($this->entity);
    $this->string .= $gen->generate();
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
