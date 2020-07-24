<?php

require_once("GenerateEntity.php");


class EntityDataDefinition_Storage extends GenerateEntity {

  public function generate() {
    $this->start();
    $tablesVisited = [$this->entity->getName()];

    $this->recursive($this->getEntity(), $tablesVisited);
    $this->end();

    return $this->string;
  }

  protected function start(){
    $this->string .= "  storage(row: { [index: string]: any }){
    if(!row) return;
    var rowCloned = JSON.parse(JSON.stringify(row))
    /**
     * se realiza un 'deep clone' del objeto para poder eliminar atributos a medida que se procesa y no alterar la referencia original
     */
";
  }

  protected function end(){
    $this->string .= "    this.stg.setItem(\"" . $this->getEntity()->getName() . "\" + rowCloned.id, rowCloned);
  }

";
  }


  protected function recursive(Entity $entity, array $tablesVisited = NULL, array $names = []) {

    if(is_null($tablesVisited)) $tablesVisited = array();

    $this->fk($entity, $tablesVisited, $names);
    //$this->u_($entity, $tablesVisited, $names);


     if (!empty($names)) $this->fields($entity->getName(), $names);
  }

  protected function fields($tableName, array $names){
    $row = "rowCloned";
    $key = $names[count($names)-1];

    $this->string .= "    if(('{$names[0]}' in {$row})
";

    for($i = 1; $i < count($names) ; $i++) {
      $row .= "['{$names[$i-1]}']";
      $this->string .= "    && ('{$names[$i]}' in {$row})
";

    }

    $row .= "['{$names[count($names)-1]}']";

    $this->string .= "    ){
      this.stg.setItem('{$tableName}' + {$row}.id, {$row});
      delete {$row};
    }
";

  }

  protected function fk(Entity $entity, array $tablesVisited, array $names){
    $fk = $entity->getFieldsFkNotReferenced($tablesVisited);
    array_push($tablesVisited, $entity->getName());

    foreach ($fk as $field ) {
      $namesAux = $names;
      array_push($namesAux, $field->getName() . "_");

      $this->recursive($field->getEntityRef(), $tablesVisited, $namesAux) ;
    }
  }

  protected function u_(Entity $entity, array $tablesVisited, array $names){
    $u_ = $entity->getFieldsU_NotReferenced($tablesVisited);
    array_push($tablesVisited, $entity->getName());

    foreach ($u_ as $field ) {
      $namesAux = $names;
      array_push($namesAux, $field->getAlias("_") . "_");
      $this->fields($field->getEntity()->getName(), $namesAux);
    }
  }

}
