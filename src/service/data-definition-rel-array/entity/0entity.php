<?php

require_once("GenerateFile.php");


class GenDataDefinitionRelArray_entity extends GenerateFile {

  public function __construct() {
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_SRC."/function/","get_entity_rel.php");
  }

  protected function generateCode() {
    $container = new Container();
    $this->start();
    foreach($container->getStructure() as $entity) $this->attribRel($entity);
    $this->end();
  }

  protected function start() {
    $this->string .= "<?php

function get_entity_rel(\$entityName) {
  switch(\$entityName){
";
  }

  protected function attribRel($entity){
    require_once("function/getEntityRel/GetEntityRelElement.php");
    $gen = new GetEntityRelElement($entity);
    $this->string .= $gen->generate();
  }
  protected function end() {
    $this->string .= "    default: return [];
  }
}
";
  }


}
