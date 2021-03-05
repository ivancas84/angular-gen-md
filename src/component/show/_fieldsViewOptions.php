<?php

require_once("GenerateEntity.php");


class GenShowTs_fieldsViewOptions extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  fieldsViewOptions: FieldViewOptions[] = [
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
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new FieldYesNoOptions(),
    }),
";
  }

  protected function year(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new FieldDateOptions({format:\"yyyy\"})
    }),
";
  }

  protected function timestamp(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new FieldDateOptions({format:\"dd/MM/yyyy HH:mm\"})
    }),
";
  }

  protected function date(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new FieldDateOptions({format:\"dd/MM/yyyy\"})
    }),
";
  }

  protected function time(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new FieldDateOptions({format:\"HH:mm\"})
    }),
";
  }

  protected function defecto(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
    }),
";
  }

  protected function label(Field $field) {
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type:new TypeLabelOptions({entityName: \"" . $field->getEntityRef()->getName() . "\"}),
      aux:new RouterLinkOptions({path: \"" . $field->getEntityRef()->getName("xx-yy") . "-detail\", params:{id:\"{{" . $field->getName() . "}})\"}}), 
    }),
";
  }


}
