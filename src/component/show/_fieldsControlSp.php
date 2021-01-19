<?php

require_once("GenerateEntity.php");
require_once("tools/GenFieldControl.php");

class GenShowTs_fieldsControlSp extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->search();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }

  protected function start() {
    $this->string .= "  fieldsControlSp: FieldControl[] = [
";
  }

  protected function search(){
    $this->string .= GenFieldControl::getInstance([
      "field"=>"search",
      "label"=>"Buscar",
      "width_sm"=>"100%",
      "width_gt_sm"=>"100%",
    ])->generate();
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "checkbox": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(),
            "label"=>$field->getName("Xx Yy"), 
            "type"=>"select_checkbox"
          ])->generate(); 
        break;
        case "date": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(),
            "label"=>$field->getName("Xx Yy"),
            "type"=>"date"
          ])->generate(); 
        break;
        case "year": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(),
            "label"=>$field->getName("Xx Yy"), 
            "type"=>"year"
          ])->generate(); 
        break;
        case "select": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(),
            "label"=>$field->getName("Xx Yy"),
            "type"=>"select_param", 
            "options"=>$field->getSelectValues()
          ])->generate(); 
        break;
        case "timestamp": 
        /**
         * timestamp es un dato particular habitualmente utilizado para campos de control
         * como fecha de alta, baja, modificacion.
         * No se incluye por dos razones principales
         * 1) Por el momento no existe controlador que lo soporte
         * 2) A simple vista no aporta ninguna funcionalidad
         * En el caso que se desee con las herramientas actuales 
         * deberia implementarse como fecha y aproximado.
         */  
        break;
        
        default:
         /**
          * Al ser la busqueda a traves de parametros estrictamente igual,
          * no conviene incluir valores de texto.
          * La busqueda a traves de valores de texto
          * deberia ser aproximada.
          * Por el momento no se incluyen,
          * se deja comentado el codigo
          */
          /*
          
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(),
            "label"=>$field->getName("Xx Yy"),
          ])->generate();
          
          */
      }
    }
  }

  protected function fk() {
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "typeahead": case "autocomplete": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(), 
            "label"=>$field->getName("Xx Yy"),
            "type"=>"autocomplete", 
            "entity_name" => $field->getEntityRef()->getName()
          ])->generate(); break;
        case "select": 
          $this->string .= GenFieldControl::getInstance([
            "field"=>$field->getName(), 
            "label"=>$field->getName("Xx Yy"),
            "type"=>"select", 
            "entity_name" => $field->getEntityRef()->getName()
          ])->generate(); break;
      }
    }
  }

  protected function end() {
    $this->string .= "  ];  
";
  }

  
}
