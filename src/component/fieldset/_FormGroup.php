<?php

require_once("GenerateEntity.php");


class FieldsetTs_formGroup extends GenerateEntity {


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
      id:null,
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      if(!$field->isAdmin()) continue;

      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "email": $this->email($field); break;
        case "dni": $this->dni($field); break;
        case "year": $this->year($field); break;
        case "timestamp":  break;
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
      if(!$field->isAdmin()) continue;

      switch ( $field->getSubtype() ) {
        case "typeahead": $this->typeahead($field); break;

        default: $this->defecto($field); //name, email
      }
    }
  }



  protected function u_() {
    $fields = $this->getEntity()->getFieldsU_();
    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        default: $this->fieldU_($field);
      }
    }
  }

  protected function end() {
    $formGroupAsyncValidation = $this->formGroupAsyncValidation();
    $this->string .= "    }" . $formGroupAsyncValidation . ");
    return fg;
  }

";
  }

  protected function formGroupAsyncValidation(){
    if(!$this->entity->getFieldsUniqueMultiple()) return "";
    $fieldsName = [];
    foreach($this->entity->getFieldsUniqueMultiple() as $field) array_push($fieldsName, $field->getName());
    $f = implode("', '", $fieldsName);
    return ", {
      asyncValidators: [this.validators.uniqueMultiple('{$this->entity->getName()}', ['{$f}'])],
    }";
  }

  protected function formControlStart(Field $field){
    $this->string .= "      {$field->getName()}: [null, {
";
  }

  protected function formControlEnd(){
    $this->string .= "      }],
";
  }
  
  protected function formControlValidators(array $validators){
    if(!empty($validators)) $this->string .= "        validators: [" . implode(', ', $validators) . "],
";
  }

  protected function validatorRequired(Field $field){
    return ($field->isNotNull()) ? "Validators.required" : false;
  }

  protected function formControlAsyncValidators(array $asyncValidators){
    if(!empty($asyncValidators)) $this->string .= "        asyncValidators: [" . implode(', ', $asyncValidators) . "],
";
  }

  protected function asyncValidatorUnique(Field $field){
    if($field->isUnique()) return "this.validators.unique('{$field->getName()}', '{$field->getEntity()->getName()}')";

    /*if($field->isUniqueMultiple()) {
      $fieldsUniqueNames = [];
      foreach($field->getEntity()->getFieldsUniqueMultiple() as $fieldUnique) {
        array_push($fieldsUniqueNames, $fieldUnique->getName());
      }

      $f = "'" . implode("', '", $fieldsUniqueNames) . "'";

      return "this.validators.uniqueMultiple('{$field->getEntity()->getName()}', [{$f}])";
    }

    return false;*/
  }

  protected function checkbox(Field $field) {
    $this->string .= "      " . $field->getName() . ": false,
";
  }

  protected function defecto(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->formControlStart($field);
    $this->formControlValidators($validators);
    $this->formControlAsyncValidators($asyncValidators);
    $this->formControlEnd();
  }

  protected function year(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));    
    if($field->getLength()) array_push($validators, "this.validators.maxYear('" . $field->getLength() . "')");
    if($field->getMinLength()) array_push($validators, "this.validators.minYear('" . $field->getMinLength() . "')");
    array_push($validators, "this.validators.year()");
    
    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->formControlStart($field);
    $this->formControlValidators($validators);
    $this->formControlAsyncValidators($asyncValidators);
    $this->formControlEnd();
  }

  protected function email(Field $field) {
    $validators = [];
    array_push($validators, "Validators.email");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->formControlStart($field);
    $this->formControlValidators($validators);
    $this->formControlAsyncValidators($asyncValidators);
    $this->formControlEnd();
  }

  protected function dni(Field $field) {
    $validators = array("Validators.minLength(7)", "Validators.maxLength(9)", "Validators.pattern('^[0-9]*$')");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->formControlStart($field);
    $this->formControlValidators($validators);
    $this->formControlAsyncValidators($asyncValidators);
    $this->formControlEnd();
  }

  protected function typeahead(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->formControlStart($field);
    $this->formControlValidators($validators);
    $this->formControlAsyncValidators($asyncValidators);
    $this->formControlEnd();
  }

  /*protected function timestamp(Field $field) {
    $this->string .= "      " . $field->getName() . ": this.fb.group({
";
    if($field->isNotNull()) {
      $this->string .= "        date: [null, Validators.required ],
        time: [null, Validators.required ],
";
    } else {
      $this->string .= "        date: null,
        time: null
";
    }
    $this->string .= "      }),
";
  }*/
}
