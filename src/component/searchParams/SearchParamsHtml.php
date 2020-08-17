<?php

require_once("GenerateFileEntity.php");

class Gen_SearchParamsHtml extends GenerateFileEntity {
  public $matFieldCount = 0;

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-search-params.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    parent::__construct($directorio, $file, $entity);
  }

  public function generateCode() {
    $this->start();
    $this->nf();
    //$this->fk();
    $this->end();
  }

  protected function start() {
    $this->string .= "<mat-card *ngIf=\"load$ | async\" [formGroup]=\"fieldset\">
  <mat-card-content>
    <div fxLayout=\"row\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
      <div fxLayout=\"row\" fxFlex=\"auto\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      switch ( $field->getSubtype() ) {
        case "checkbox": 
          //$this->checkbox($field); 
        break;
        case "date": case "timestamp": 
          $this->date($field);  
        break;
        case "float": case "integer": case "cuil": case "dni": 
          //$this->number($field); 
        break;
        case "year": 
          //$this->year($field); 
        break;
     
        case "select_text": 
          $this->selectValues($field); 
        break;
        case "select_int": 
          $this->selectValues($field);
         break;
         case "textarea": break;
        default: $this->defecto($field); //name, email
      }
    }
  }

  public function newRow(){
    if($this->matFieldCount && ($this->matFieldCount % 4 == 0)){
      $this->string .= "      </div>
    </div>  
    <div fxLayout=\"row\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
      <div fxLayout=\"row\" fxFlex=\"auto\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
    } 
    
    elseif($this->matFieldCount && ($this->matFieldCount % 2 == 0)){
      $this->string .= "      </div>
      <div fxLayout=\"row\" fxFlex=\"auto\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
    }
    
    $this->matFieldCount++;

  }

  
  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
    
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->typeahead($field); break;
      }
    }
  }


  protected function date(Field $field) {
    $this->newRow();
    $this->string .= "        <div fxFlex=\"auto\">
          <mat-form-field>
            <mat-label>{$field->getName('Xx yy')}</mat-label>
            <input matInput [matDatepicker]=\"{$field->getAlias()}Picker\" formControlName=\"{$field->getName()}\">
            <mat-datepicker-toggle matSuffix [for]=\"{$field->getAlias()}Picker\"></mat-datepicker-toggle>
            <mat-datepicker #{$field->getAlias()}Picker></mat-datepicker>
            <mat-error *ngIf=\"{$field->getName("xxYy")}.hasError('matDatepickerParse')\">El formato es incorrecto</mat-error>
          </mat-form-field>
        </div>
";
  }

  protected function year(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <input class=\"form-control-sm\" placeholder=\"{$field->getName('Xx yy')}: yyyy\" type=\"text\" formControlName=\"" . $field->getName() . "\">
    </div>
";
  }

  protected function defecto(Field $field) {
    $this->newRow();
    $this->string .= "        <div fxFlex=\"auto\">
          <mat-form-field>
            <mat-label>" . $field->getName("Xx yy") . "</mat-label>
            <input matInput formControlName=\"" . $field->getName() . "\" >
          </mat-form-field>
        </div>
";
  }

  protected function checkbox(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <select class=\"form-control-sm\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--{$field->getName('Xx yy')}--</option>
        <option [ngValue]=\"'true'\">Sí</option>
        <option [ngValue]=\"'false'\">No</option>
      </select>
    </div>
";
  }

  protected function selectValues(Field $field){
    $this->newRow();
    $this->string .= "        <div fxFlex=\"auto\">
          <mat-form-field>
            <mat-label>" . $field->getName("Xx yy") . "</mat-label>
            <mat-select formControlName=\"" . $field->getName() . "\">
              <mat-option>--Seleccione--</mat-option>
" ;

              foreach($field->getSelectValues() as $value) $this->string .= "              <mat-option value=\"" . $value . "\">" . $value . "</mat-option>
";
$this->string .= "            </mat-select>
          </mat-form-field>
        </div>
";
  }

  protected function select(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <select class=\"form-control-sm\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
        <option *ngFor=\"let option of (opt" . $field->getEntityRef()->getName('XxYy') . "$ | async)\" [value]=\"option.id\" >{{option.id | label:\"{$field->getEntityRef()->getName()}\"}}</option>
      </select>
    </div>
";
  }

  protected function typeahead(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <app-typeahead [field]=\"" . $field->getName("xxYy") . "\" [entityName]=\"'" . $field->getEntityRef()->getName() . "'\" [size]=\"sm\"></app-typeahead>
    </div>
";
  }

  protected function end() {
    $this->string .= "      </div>
    </div>
  </mat-card-content>
</mat-card>
";
  }
}