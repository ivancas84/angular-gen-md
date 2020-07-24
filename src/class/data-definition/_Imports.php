<?php

require_once("GenerateEntity.php");


class EntityDataDefinition_Imports extends GenerateEntity {

  protected $fields = [];

  public function generate() {
    if(!$this->defineFields()) return "";
    $this->body();
    return $this->string;
  }


  protected function defineFields(){
   $fk = $this->getEntity()->getFieldsFk();

   foreach ($fk as $field){ if($field->isMain()) array_push($this->fields, $field); }
   if(!count($this->fields)) return false;
   return true;
 }

  protected function body(){
    $imports = [];
    foreach($this->fields as $field) {
        if(in_array($field->getEntityRef()->getName(), $imports)) continue;
        array_push($imports, $field->getEntityRef()->getName()); 
        $this->string .= "import { " . $field->getEntityRef()->getName("XxYy") . "DataDefinition } from '@class/data-definition/" . $field->getEntityRef()->getName("xx-yy") . "-data-definition';
";        
      }
    }
  }


