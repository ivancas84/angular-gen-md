<?php

require_once("GenerateEntity.php");


class GenShowTs_fieldsConfig extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  fieldsConfig: FieldConfig[] = [
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field); break;
        case "year": $this->year($field); break;
        case "timestamp":
        /**
         * timestamp es un dato particular habitualmente utilizado para campos de control
         * como por ejemplo altas, bajas, modificaciones
         * por el momento no se incluye
         */
        break;
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
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"si_no\",
    }),
";
  }

  protected function year(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"yyyy\"
    }),
";
  }

  protected function timestamp(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"dd/MM/yyyy HH:mm\"
    }),
";
  }

  protected function date(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"dd/MM/yyyy\"
    }),
";
  }

  protected function time(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"date\",
      format:\"HH:mm\"
    }),
";
  }

  protected function defecto(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
    }),
";
  }

  protected function label(Field $field) {
    $this->string .= "    new FieldConfig({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:\"label\",
      entityName: \"" . $field->getEntityRef()->getName() . "\",
      routerLink: \"" . $field->getEntityRef()->getName("xx-yy") . "-detail\",
      queryParamField:\"" . $field->getName() . "\", 
    }),
";
  }


}
