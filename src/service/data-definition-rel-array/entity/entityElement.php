<?php

require_once("GenerateEntityRecursiveFk.php");

class GenDataDefinitionRelArray_entityElement extends GenerateEntityRecursiveFk {
  protected $names = [];

  

  protected function start() {
    $this->string .= "";
  }
  
  protected function end() {
    $this->string .= "";
  }

  protected function body(Entity $entity, $prefix, Field $field = null){
    $prf = (empty($prefix)) ? $field->getAlias() : $prefix . "_" . $field->getAlias();
    $prf2 = (empty($prefix)) ? "" : $prefix . "-";

    $structure = "{";
    foreach($entity->getFieldNames() as $fieldName)
      $structure .= "'".$prf."-".$fieldName."':'".$fieldName."', ";
    $structure .= "}";

    $this->string .= "      switchMap(
        (data:{ [index: string]: any; }[]) => {
          return this.dd.getAllColumnData(data, '" . $prf2 . $field->getName() . "', '" . $entity->getName() ."', " . $structure . ")
        }
      ),
";
  }

}
