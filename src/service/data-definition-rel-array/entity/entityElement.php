<?php


class GenDataDefinitionRelArray_entityElement extends GenerateEntityRecursiveFk {
  protected $names = [];

  

  protected function start() {
    $fk = $this->entity->getFieldsFk();

    foreach($fk as $field){
      $this->body($field->getEntityRef(), "", $field->getAlias());
    }
  }
  
  protected function end() {
    $this->string .= "";
  }

  protected function body(Entity $entity, $prefix, Field $field = null){
    $p = (empty($prefix)) ? "" : $prefix."-";
    $prf = (empty($prefix)) ? "" : $prefix . "_";
    
    $structure = "{";
    foreach($entity->getFieldNames() as $fieldName)
      $structure.= "'".$prf.$field->getAlias()."-".$fieldName."':'".$fieldName."', ";
    $structure = "}";

    $this->string .= "      switchMap(
        data => {
          return this.dd.getAllColumnData(data, '" . $p . $field->getName() . "', '" . $entity->getName() ."',  
          
        }
      )
";
  }


  protected function fk($entity, array $tablesVisited, $prefix = "") {
    array_push ($tablesVisited, $entity->getName());
    $fk = $entity->getFieldsFkNotReferenced($tablesVisited);
    
    $prefixAux = (empty ($prefix)) ? "" : $prefix . "_";

    foreach ($fk as $field) {
      $fieldId = $this->defineName($field->getName());

      $prefixTemp = $prefixAux . $field->getAlias();

      $this->string .= "  '{$prefixTemp}' => ['field_id'=>'{$fieldId}', 'field_name'=>'{$field->getName()}', 'entity_name'=>'{$field->getEntityRef()->getName()}'],
";
      
      if(!in_array($field->getEntityRef()->getName(), $tablesVisited)) $this->fk($field->getEntityRef(), $tablesVisited, $prefixTemp);

    }
  }

  protected function recursive(Entity $entity, array $tablesVisited = NULL) {
    if(is_null($tablesVisited)) $tablesVisited = array();
    array_push ($tablesVisited, $entity->getName());
    $fk = $entity->getFieldsFkNotReferenced($tablesVisited);
    //$u_ = $entity->getFieldsU_NotReferenced($tablesVisited);

    $this->fk($fk, $tablesVisited);
  }

  protected function end() {
    $this->string .= "    ];

";
  }
}
