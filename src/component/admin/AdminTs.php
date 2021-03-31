<?php

require_once("GenerateFileEntity.php");

class Gen_AdminTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/admin/" . $entity->getName("xx-yy") . "-admin/";
    $file = $entity->getName("xx-yy") . "-admin.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode() {
    $this->start();
    $this->fieldsViewOptions();
    $this->end();
  }
  
  protected function start() {
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Location } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AdminComponent } from '@component/admin/admin.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ValidatorsService } from '@service/validators/validators.service';
import { SessionStorageService } from '@service/storage/session-storage.service';
import { FieldViewOptions } from '@class/field-view-options';
import { FieldInputCheckboxOptions, FieldInputSelectParamOptions, FieldInputTextOptions, FieldInputAutocompleteOptions, FieldControlOptions, FieldHiddenOptions, FieldInputDateOptions, FieldInputYearOptions, FieldInputSelectOptions } from '@class/field-type-options';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-admin',
  templateUrl: '../../core/component/admin/admin-dynamic.component.html',
})
export class " . $this->entity->getName("XxYy") . "AdminComponent extends AdminComponent {

  readonly entityName: string = \"" . $this->entity->getName() . "\"
  title: string = \"" . $this->entity->getName('Xx Yy') . "\"

";
  }

  protected function fieldsViewOptions(){
    require_once("component/admin/_fieldsViewOptions.php");
    $gen = new GenAdminTs_fieldsViewOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end() {
    $this->string .= "}

";
  }



}
