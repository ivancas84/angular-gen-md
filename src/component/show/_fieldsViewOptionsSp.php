<?php

require_once("GenerateEntity.php");

class GenShowTs_fieldsViewOptionsSp extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->search();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }

  protected function start() {
    $this->string .= "  fieldsViewOptionsSp: FieldViewOptions[] = [
";
  }

  protected function search(){
    $this->string .= "    new FieldViewOptions({
      field:\"search\",
      label:\"Buscar\",
      type: new FieldInputTextOptions(),
      width: new FieldWidthOptions({sm:'100%',gtSm:'100%'}),
    }),
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "checkbox": 
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputSelectCheckboxOptions(),
    }),
";
        break;
        case "date":
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputDateOptions(),
    }),
";  
        break;
        case "year": 
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputYearOptions(),
    }),
";          
        break;
        case "select": 
          $options="['" . implode("','",$field->getSelectValues()) . "']";
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputSelectParamOptions({options:" . $options . "}),
    }),
"; 
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
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
    }),
";
          */
      }
    }
  }

  protected function fk() {
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "typeahead": case "autocomplete": 
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputAutocompleteOptions({entityName:'" . $field->getEntityRef()->getName() . "'}),
    }),
";
        break;
        case "select": 
          $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputSelectOptions({entityName:'" . $field->getEntityRef()->getName() . "'}),
    }),
";
       break;
      }
    }
  }

  protected function end() {
    $this->string .= "  ];  
";
  }

  
}
