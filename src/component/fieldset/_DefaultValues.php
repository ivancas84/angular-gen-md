<?php

require_once("GenerateEntity.php");
require_once("function/settypebool.php");

class FieldsetTs_defaultValues extends GenerateEntity {

  protected $fields = [];
  /**
   * Fields que poseen valor por defecto
   */
  public function generate() {
    if(!$this->hasDefaultValues()) return;
    $this->start();
    $this->body();
    $this->end();

    return $this->string;
  }


  protected function hasDefaultValues(){
    foreach($this->entity->getFields() as $field){
      if(!is_null($field->getDefault())) return true;
    }
    return false;
  }

  protected function start() {
    $this->string .= "  readonly defaultValues: {[key:string]: any} = {";
  }

  protected function body(){
    foreach($this->entity->getFields() as $field){
      if(!$field->isAdmin()) continue;

      switch($field->getDataType()){
        case "integer": 
        case "float": $this->number($field); break;
        case "blob": break;
        case "boolean": $this->boolean($field); break;
        case "timestamp": 
        case "date": $this->datetime($field); break;
        default: $this->defecto($field); //string, text
      }
    }
    $this->string .= implode(", ", $this->fields);
  }
  
  protected function end() {
    $this->string .= "}

";
  }


  protected function boolean($field){
    $default = (settypebool($field->getDefault())) ? "true":"false";

    array_push($this->fields, "{$field->getName()}: {$default}");
  }

  protected function datetime($field){
    if(is_null($field->getDefault())) return;
    $default = (strpos(strtolower($field->getDefault()), "current") !== false) ? 
      "new Date()" : "new Date('" . $field->getDefault() . "')";
  
    array_push($this->fields, "{$field->getName()}: {$default}");
  }

  protected function number($field){
    if(is_null($field->getDefault())) return;
    array_push($this->fields, "{$field->getName()}: {$field->getDefault()}");
  }

  protected function defecto($field){
    if(is_null($field->getDefault())) return;
    array_push($this->fields, "{$field->getName()}: \"{$field->getDefault()}\"");
  }

}
