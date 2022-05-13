<?php

require_once("GenerateEntity.php");


class GenDataDefinitionLabel_labelEntityRow extends GenerateEntity {

  public $fields = [];

  public function generate() {
    $this->defineFields();

    $this->start();
    $this->pk();
    $this->nf();
    $this->end();
    return $this->string;
  }

  protected function defineFields(){
   $this->fields["pk"] = null;
   $this->fields["nf"] = array();

   $pk = $this->getEntity()->getPk();
   $nf = $this->getEntity()->getFieldsNf();

   if($pk->isMain()) $this->fields["pk"] = $pk;
   foreach ($nf as $field){ if($field->isMain()) array_push($this->fields["nf"], $field); }
 }

  protected function start(){
    $this->string .= "  label" . $this->entity->getName("XxYy"). "Row (row: any): string {
    if(!row) return \"\";

    let ret = \"\";
";
  }

  protected function pk(){
    $pk = $this->fields["pk"];
    if($pk) $this->defecto($pk);
  }

  protected function nf(){
    $fields = $this->fields["nf"];

    foreach($fields as $field){

      switch ( $field->getSubtype() ) {
        case "date": $this->date($field); break;
        default: $this->defecto($field); break;
      }
    }
  }

  protected function defecto(Field $field){
    $this->string .= "    if (row[\"" . $field->getName() . "\"]) ret = ret.trim() + \" \" + row[\"" . $field->getName() . "\"];

";
  }

  protected function date(Field $field){
    $this->string .= "    if (row[\"" . $field->getName() . "\"]) ret = ret.trim() + \" \" + Parser.dateFormat(Parser.date(row[\"" . $field->getName() . "\"]), 'd/m/Y');

";
  }

  protected function end(){
    $this->string .= "    return ret.trim();
  }

";
  }




}
