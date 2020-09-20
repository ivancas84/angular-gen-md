<?php

require_once("GenerateFileEntity.php");

class GenInputPickerHtml extends GenerateFileEntity {
  /** 
   * Generar template para componente FormPick
   * Basado en GenFieldsetHtml 
   */

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-input-picker.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/input-picker/" . $entity->getName("xx-yy") . "-form-pick/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    if(!$this->entity->getFieldsUniqueMultiple()) return "";
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();
  }

  protected function start() {
    $this->string .= "<form fxLayout=\"row\" fxLayoutGap=\"10px\" fxLayout.xs=\"row\" [formGroup]=\"form\" (ngSubmit)=\"onSubmit()\" novalidate>
";
  }


  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      if(!$field->isUniqueMultiple()) continue;
      switch ( $field->getSubtype() ) {
        case "checkbox": 
          /**
           * No se admiten campos checkbox como unicos multiples
           */
        break;
        case "date": $this->date($field); break;
        case "timestamp":
          /**
           * No existe un input para timestamp se considera como date (asignando el sufijo de transformacion)
           **/ 
          $this->date($field, "Date"); 
        break;

        case "year": $this->year($field); break;
        case "select_text": //temporal debe ser reemplazado por select
        case "select_int": //temporal debe ser reemplazado por select
        case "select":
           $this->selectValues($field); 
        break;

        case "textarea": $this->textarea($field); break;
        default: $this->defecto($field); //name, email, time (temporalmente hasta implementar time-picker)
      }
    }
  }


  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      if(!$field->isUniqueMultiple()) continue;
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->typeahead($field); break;
      }
    }
  }




  protected function date(Field $field, $sufix = "") {
    $this->string .= "  <core-input-date [field]=\"" . $field->getName("xxYy") . "Date\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-date>
";
  }

  protected function year(Field $field) {
    $this->string .= "  <core-input-year [field]=\"" . $field->getName("xxYy") . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-year>
";
  }


  protected function defecto(Field $field) {
    $this->string .= "  <core-input-text [field]=\"" . $field->getName("xxYy") . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-text>
";
  }


  protected function textarea(Field $field) {
    $this->string .= "  <core-input-textarea [field]=\"" . $field->getName("xxYy") . "\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-textarea>
";
  }


  protected function selectValues(Field $field){
    $this->string .= "  <core-input-select-param [field]=\"" . $field->getName("xxYy") . "\" [options]=\"'" . implode("','", $field->getSelectValues()). "'\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-select-param>
";
  }


  protected function select(Field $field) {
    $this->string .= "  <core-input-select [field]=\"" . $field->getName("xxYy") . "\" [entityName]=\"'" . $field->getName("xxYy") . "'\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-autocomplete>
";
  }

  protected function typeahead(Field $field) {
    $this->string .= "  <core-input-autocomplete [field]=\"" . $field->getName("xxYy") . "\" [entityName]=\"'" . $field->getName("xxYy") . "'\" [title]=\"'" . $field->getName("Xx Yy") . "'\" fxFlex=\"auto\" fxLayoutAlign=\"center center\"></core-input-autocomplete>
";

  }



  protected function end() {
    $this->string .= "  <div fxFlex=\"auto\">
    <button mat-mini-fab *ngIf=\"field.pending\" (click)=\"field.setValue(null)\" [disabled]=\"field.pending\" color=\"primary\"><mat-icon>hourglass_empty</mat-icon></button>
    <button mat-mini-fab *ngIf=\"!field.pending\" (click)=\"field.setValue(null)\" [disabled]=\"!field.value && !field.pending\" color=\"primary\"><mat-icon>clear</mat-icon></button>
  </div>
</form>
";
  }

  protected function templateErrorStart(Field $field){
    $this->string .= "    <div class=\"text-danger\" *ngIf=\"({$field->getName("xxYy")}.touched || {$field->getName("xxYy")}.dirty) && {$field->getName("xxYy")}.invalid\">
";
  }

  protected function templateErrorEnd(Field $field){
    $this->string .= "    </div>
";
  }

  protected function templateErrorIsNotNull(Field $field){
    if($field->isNotNull()) $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.required\">Debe completar valor</div>
";
  }

  protected function templateErrorIsUnique(Field $field){
    if($field->isUnique()) $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.notUnique\">El valor ya se encuentra utilizado: <a routerLink=\"/{$field->getEntity()->getName("xx-yy")}-admin\" [queryParams]=\"{'{$field->getName()}':{$field->getName('xxYy')}.value}\">Cargar</a></div>
";
  }


  protected function templateErrorEmail(Field $field) {
    $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.email\">Debe ser un email válido</div>
";
  }


  protected function templateErrorYear(Field $field) {
    $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.nonNumeric\">Ingrese sólo números</div>
      <div *ngIf=\"{$field->getName("xxYy")}.errors.notYear\">No es un año válido</div>    
";
    if($field->getMinLength()) $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.minYear\">Valor no permitido</div>
";
    if($field->getLength()) $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.maxYear\">Valor no permitido</div>
";    
  }



  protected function templateErrorDate(Field $field) {
    $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.ngbDate\">Ingrese una fecha válida</div>
";
  }

  protected function templateErrorDni(Field $field) {
    $this->string .= "      <div *ngIf=\"{$field->getName("xxYy")}.errors.pattern\">Ingrese solo números</div>
      <div *ngIf=\"{$field->getName("xxYy")}.errors.minlength\">Longitud incorrecta</div>
      <div *ngIf=\"{$field->getName("xxYy")}.errors.maxlength\">Longitud incorrecta</div>
";
  }

}
