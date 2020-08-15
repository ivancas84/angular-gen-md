<?php

require_once("GenerateEntity.php");


class Gen_SearchParamsTs_formGroup extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  formGroup(): FormGroup {
    let fg: FormGroup = this.fb.group({
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "textarea": case "timestamp": break;
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
        default: $this->defecto($field); //name, email
      }
    }
  }

  protected function end() {
    $this->string .= "    });
    return fg;
  }

";
  }

  protected function defecto(Field $field) {
    $this->string .= "      {$field->getName()}: null,
";
  }

}
