<?php

require_once("GenerateEntity.php");


class GenShowTs_fields extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  fields = [
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field); break;
        case "year": $this->year($field); break;
        case "timestamp": $this->timestamp($field); break;
        
        /**
         * La administracion de timestamp no se define debido a que no hay un controlador que actualmente lo soporte
         * Para el caso de que se requiera se deben definir campos adicionales para la fecha y hora independientes
         */
        default: $this->defecto($field); //name, email, date

      }
    }
  }

  protected function fk() {
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        default: $this->label($field); //name, email
      }
    }
  }

  protected function end() {
    $this->string .= "  ];  
";
  }

  protected function checkbox(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"si_no\",
    },
";
  }

  protected function year(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"yyyy\"
    },
";
  }

  protected function timestamp(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"dd/MM/yyyy HH:mm\"
    },
";
  }

  protected function date(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"dd/MM/yyyy\"
    },
";
  }

  protected function time(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"HH:mm\"
    },
";
  }

  protected function defecto(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
    },
";
  }

  protected function label(Field $field) {
    $this->string .= "    {
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"label\",
      entityName: \"" . $field->getEntityRef()->getName() . "\",
      routerLink: \"" . $field->getEntityRef()->getName("xx-yy") . "-detail\",
      queryParamField:\"" . $field->getName() . "\", 
    },
";
  }


}
