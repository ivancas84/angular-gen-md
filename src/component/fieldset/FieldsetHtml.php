<?php

require_once("GenerateFileEntity.php");

class FieldsetHtml extends GenerateFileEntity {

  protected $matFieldCount = 0;

  public function __construct(Entity $entity, $dir=null, $file=null) {
    if(!$file) $file = $entity->getName("xx-yy") . "-fieldset.component.html";
    if(!$dir) $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset/" . $entity->getName("xx-yy") . "-fieldset/";
    parent::__construct($dir, $file, $entity);
  }


  public function generateCode() {
    $this->header();
    $this->contentStart();
    $this->rowStart();
    $this->nf();
    $this->fk();
    $this->rowEnd();
    $this->end();
  }

  protected function header() {
    $this->string .= "<mat-card>
  <mat-card-header>
    <mat-card-title>" . $this->getEntity()->getName("Xx Yy") . "</mat-card-title>
  </mat-card-header>
";
  }

  protected function contentStart() {
    $this->string .= "  <mat-card-content [formGroup]=\"fieldset\">
";
  }

  
  protected function rowStart() {
    $this->string .= "    <div fxLayout=\"row\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
      <div fxLayout=\"row\" fxFlex=\"50%\" fxFlex.lt-md=\"100%\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
  }

  public function newRow(){
    if($this->matFieldCount && ($this->matFieldCount % 4 == 0)){
      $this->string .= "      </div>
    </div>  
    <div fxLayout=\"row\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
      <div fxLayout=\"row\" fxFlex=\"50%\" fxFlex.lt-md=\"100%\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
    } 
    
    elseif($this->matFieldCount && ($this->matFieldCount % 2 == 0)){
      $this->string .= "      </div>
      <div fxLayout=\"row\" fxFlex=\"50%\" fxFlex.lt-md=\"100%\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
    }
    
    $this->matFieldCount++;

  }
  
  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      if(!$field->isAdmin()) continue;
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field);  break;
        //case "float": case "integer": case "cuil": case "dni": $this->number($field); break;
        //case "year": $this->year($field); break;
        case "timestamp": break;
        case "time": $this->time($field); break;
        case "select_text": case "select_int": case "select": $this->selectValues($field); break;
        case "textarea": $this->textarea($field); break;
        case "email": $this->email($field); break;
        default: $this->defecto($field); //name
      }
    }
  }


  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      if(!$field->isAdmin()) continue;
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->autocomplete($field); break;
        case "file": $this->file($field); break;
      }
    }
  }




  protected function date(Field $field, $sufix="") {
    $this->newRow();
    $this->string .= "        <core-input-date [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-date>
";
  }

  protected function time(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-timepicker [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-timepicker>
";
  }

  protected function year(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-year [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-year>
";
  }

  protected function defecto(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-text [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-text>
";
  }


  protected function textarea(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-textarea [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-textarea>
";
  }


  protected function checkbox(Field $field, $sufix= "") {
    $this->newRow();
    $this->string .= "        <core-input-checkbox [field]=\"" . $field->getName("xxYy") . $sufix . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-checkbox>
";
  }

  protected function selectValues(Field $field, $sufix = ""){
    $this->newRow();
    $this->string .= "        <core-input-select-param [field]=\"" . $field->getName("xxYy") . $sufix . "\" [options]=\"['" . implode("','",$field->getSelectValues()) . "']\" [title]=\"'" . $field->getName("Xx yy") . "'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-select-param>
";
  }

  protected function select(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-select [field]=\"" . $field->getName('xxYy') . $sufix . "\" [entityName]=\"'{$field->getEntityRef()->getName()}'\" [title]=\"'{$field->getName("Xx Yy")}'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-select>
";
  }

  protected function autocomplete(Field $field, $sufix = "") {
    $this->newRow();
    $this->string .= "        <core-input-autocomplete [field]=\"" . $field->getName("xxYy") . $sufix . "\" [entityName]=\"'" . $field->getEntityRef()->getName() . "'\" [title]=\"'{$field->getName("Xx Yy")}'\" fxFlex=\"50%\" fxFlex.xs=\"100%\" fxLayoutAlign=\"center center\"></core-input-autocomplete>
";
  }

  protected function file(Field $field) {
    $this->string .= "  <div class=\"form-group row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx Yy") . "</label>
    <div class=\"col-sm-10\">
      <app-upload [field]=\"" . $field->getName("xxYy") . "\"></app-upload>
      <app-upload [field]=\"" . $field->getName("xxYy") . "\"></app-upload>
";
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field);
      
      $this->string .= "    </div>
  </div>
";
  }


  protected function rowEnd() {
    $this->string .= "      </div>
    </div>    
";
    if($this->entity->getFieldsUniqueMultiple()) $this->string .= "    <div class=\"text-danger\" *ngIf=\"fieldset.errors\">
      <div *ngIf=\"fieldset.errors.notUnique\">El valor ya se encuentra utilizado: <a routerLink=\"/{$this->entity->getName("xx-yy")}-admin\" [queryParams]=\"{'id':fieldset.errors.notUnique}\">Cargar</a></div>
    </div>
";

  }
  
  protected function end() {
  $this->string .= "  </mat-card-content>
</mat-card>
";
  }


}
