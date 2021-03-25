<?php

require_once("GenerateEntityRecursiveFk.php");

class GenDataDefinitionRelArray_entityElementGetAll extends GenerateEntityRecursiveFk {
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

    //$structure = $this->defineStructure($entity, $prf);

    $this->string .= "      switchMap(
        (data:{ [index: string]: any; }[]) => {
          var f = this.filterFields(fields, '" . $prf . "-');
          return (isEmptyObject(f)) ? of(data) : this.dd.getAllColumnData(data, '" . $prf2 . $field->getName() . "', '" . $entity->getName() ."', f)
        }
      ),
";
  }

  protected function defineStructure($entity, $prf){
    /**
     * La estructura se utilizaba en la version 1, cuando no estaba implementado el atributo fields.
     * A partir de la version 2, se debe indicar como parametro los campos que quiere filtrar 
     */
    $structure = "{";
    foreach($entity->getFieldNames() as $fieldName)
      $structure .= "'".$prf."-".$fieldName."':'".$fieldName."', ";
    $structure .= "}";
    return $structure;  
  }

}
