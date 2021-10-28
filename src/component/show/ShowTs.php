<?php

require_once("GenerateFileEntity.php");

class Gen_ShowTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    $file = $entity->getName("xx-yy") . "-show.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowRelDynamicComponent } from '@component/show/show-rel-dynamic.component';
import { FieldViewOptions } from '@class/field-view-options';
import { FieldYesNoOptions, TypeLabelOptions, FieldInputSelectCheckboxOptions, FieldInputCheckboxOptions, FieldInputSelectParamOptions, FieldInputAutocompleteOptions, FieldInputSelectOptions, FieldInputTextOptions, FieldDateOptions, FieldInputDateOptions } from '@class/field-type-options';
import { RouterLinkOptions } from '@class/field-view-aux-options';
import { FieldWidthOptions } from '@class/field-width-options';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-show',
  templateUrl: '../../core/component/show/show-dynamic.component.html',
})
export class " . $this->entity->getName("XxYy") . "ShowComponent extends ShowRelDynamicComponent {

  readonly entityName: string = \"" . $this->entity->getName() . "\";

";
  }

  
  protected function fieldsViewOptions(){
    require_once("component/show/_fieldsViewOptions.php");
    $gen = new GenShowTs_fieldsViewOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function fieldsViewOptionsSp(){
    require_once("component/show/_fieldsViewOptionsSp.php");
    $gen = new GenShowTs_fieldsViewOptionsSp($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}

";
  }

  protected function generateCode() { //@override
    $this->start();
    $this->fieldsViewOptions();
    $this->fieldsViewOptionsSp();
    $this->end();
  }

}
