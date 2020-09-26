<?php

require_once("component/fieldset/FieldsetHtml.php");

class FieldsetArrayHtml extends FieldsetHtml {

  public function __construct(Entity $entity) {
    $file = $entity->getName("xx-yy") . "-fieldset-array.component.html";
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset-array/" . $entity->getName("xx-yy") . "-fieldset-array/";
    parent::__construct($entity, $dir, $file);
    $this->sufix = "(i)";

  }


  
  protected function contentStart() {
    $this->string .= "  <mat-card-content>
    <div *ngFor=\"let row of fieldset.controls; let i=index\" [formGroup]=\"fg(i)\">
    
    <div fxLayout=\"row\" *ngIf=\"!_delete(i).value\">

";
  }

  protected function rowStart() {
    $this->string .= "    <div fxLayout=\"row\" fxFlex=\"90%\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
      <div fxLayout=\"row\" fxFlex=\"50%\" fxFlex.lt-md=\"100%\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\">
";
  }

  public function newRow(){
    if($this->matFieldCount && ($this->matFieldCount % 4 == 0)){
      $this->string .= "      </div>
    </div>  
    <div fxLayout=\"row\" fxFlex=\"90%\" fxLayout.lt-md=\"column\" fxLayoutGap=\"10px\">
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

  protected function end() {
    $this->string .= "    </div>
    
    </div>
    <button mat-mini-fab color=\"primary\" (click)=\"add()\" type=\"button\"><mat-icon>add</mat-icon></button>
    
    </mat-card-content>
  </mat-card>
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
    $this->string .= "    <div fxLayout=\"row\" fxFlex=\"10%\" fxLayoutGap=\"10px\" fxLayout.xs=\"column\" fxLayoutAlign=\"center center\">
      <button mat-mini-fab color=\"warn\" (click)=\"remove(i)\" type=\"button\"><mat-icon>delete</mat-icon></button>
    </div>

";
  }
  

    
  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      if(!$field->isAdmin()) continue;
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field, $this->sufix); break;
        case "date": $this->date($field, $this->sufix);  break;
        //case "float": case "integer": case "cuil": case "dni": $this->number($field); break;
        //case "year": $this->year($field); break;
        case "timestamp": break;
        case "time": $this->time($field, $this->sufix); break;
        case "select_text": case "select_int": case "select": $this->selectValues($field); break;
        case "textarea": $this->textarea($field, $this->sufix); break;
        case "email": $this->email($field, $this->sufix); break;
        default: $this->defecto($field, $this->sufix); //name
      }
    }
  }


  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      if(!$field->isAdmin()) continue;
      switch($field->getSubtype()) {
        case "select": $this->select($field, $this->sufix); break;
        case "typeahead": $this->autocomplete($field, $this->sufix); break;
        case "file": $this->file($field, $this->sufix); break;
      }
    }
  }


}
