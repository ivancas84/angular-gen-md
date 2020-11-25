<?php

require_once("GenerateFileEntity.php");

class Gen_SearchParamsHtml extends FieldsetHtml {
  public $matFieldCount = 0;

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-search-params.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    parent::__construct($entity, $directorio, $file);
  }

  /*public function generateCode() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();
  }*/

  protected function header() {
    $this->string .= "<mat-card>
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field);  break;
        //case "float": case "integer": case "cuil": case "dni": $this->number($field); break;
        //case "year": $this->year($field); break;
        case "timestamp": break;
        case "time": $this->time($field); break;
        case "select_text": case "select_int": case "select": $this->selectValues($field); break;
        case "textarea": $this->textarea($field); break;
        default: $this->defecto($field); //name, email
      }
    }
  }


  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->autocomplete($field); break;
      }
    }
  }


  protected function rowEnd() {
    $this->string .= "      </div>
    </div>    
";
  
  }

}