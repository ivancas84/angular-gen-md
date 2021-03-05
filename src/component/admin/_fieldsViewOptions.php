<?php

require_once("GenerateEntity.php");
require_once("function/settypebool.php");

class GenAdminTs_fieldsViewOptions extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->pk();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  fieldsViewOptions: FieldViewOptions[] = [
";
  }

  protected function pk() {
    $this->string .= "    new FieldViewOptions({
      field:\"id\",
      label:\"id\",
      type: new FieldHiddenOptions,
    }),
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "email": $this->email($field); break;
        case "dni": $this->dni($field); break;
        case "date": $this->date($field); break;
        case "year": $this->year($field); break;
        case "float": $this->float($field); break;
        case "select_text": case "select_int": case "select": case "select_param": $this->selectParam($field); break;
        case "timestamp": break;

        
        /**
         * La administracion de timestamp no se define debido a que no hay un controlador que actualmente lo soporte
         * Para el caso de que se requiera se deben definir campos adicionales para la fecha y hora independientes
         */
        default: $this->defecto($field);

      }
    }
  }

  protected function fk() {
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      switch ( $field->getSubtype() ) {
        case "typeahead": case "autocomplete": $this->autocomplete($field); break;
        case "select": $this->select($field); break;
      }
    }
  }

  protected function end() {
    $this->string .= "  ];  
";
  }

  protected function defaultDateTime($field){
    if(is_null($field->getDefault())) return null;
    return (strpos(strtolower($field->getDefault()), "current") !== false) ? 
      "new Date()" : "new Date('" . $field->getDefault() . "')";
  }

  protected function defaultNumber($field){
    if(is_null($field->getDefault())) return null;
    return "{$field->getDefault()}";
  }

  protected function defaultString($field){
    if(is_null($field->getDefault())) return null;
    return (is_null($field->getDefault())) ? null : "\"{$field->getDefault()}\"";      
  }

  protected function fieldControlOptions($validators, $asyncValidators){
    if(!empty($validators)||!empty($asyncValidators)){
      $this->string .= "      control: new FieldControlOptions({";
      if(!empty($validators)) $this->string .= "validators: [" . implode(', ', $validators) . "],";    
      if(!empty($asyncValidators)) $this->string .= "asyncValidators: [" . implode(', ', $asyncValidators) . "],";  
      $this->string .= "})
";
    }
  }

  protected function checkbox(Field $field) {
    $default = (settypebool($field->getDefault())) ? "true":"false";
    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputCheckboxOptions(),
";
      if($default) $this->string .= "      default:" . $default . ",
    }),
";
  }

  protected function defecto(Field $field) {
    $default = (is_null($field->getDefault())) ? null : "\"{$field->getDefault()}\"";

    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function email(Field $field) {
    $default = (is_null($field->getDefault())) ? null : "\"{$field->getDefault()}\"";

    $validators = ["Validators.pattern(\"[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\\.[a-z]{2,3}\")"];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function dni(Field $field) {
    $default = (is_null($field->getDefault())) ? null : "\"{$field->getDefault()}\"";

    $validators = array("Validators.minLength(7)", "Validators.maxLength(9)", "Validators.pattern('^[0-9]*$')");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function year(Field $field) {
    $validators = array("this.validators.year()");
    if($field->getMax()) array_push($validators, "this.validators.maxYear('" . $field->getLength() . "')");
    if($field->getMin()) array_push($validators, "this.validators.minYear('" . $field->getMinLength() . "')");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $default = $this->defaultDateTime($field);

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputYearOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function date(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $default = $this->defaultDateTime($field);

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputDateOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function integer(Field $field) {
    $default = $this->defaultNumber();

    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function float(Field $field) {
    $default = $this->defaultNumber();
    
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $l = ($field->getLength())? explode(",",$field->getLength()) : [10];
    if(isset($l[1])) {
      $m = $l[0] - $l[1];
      $d = $l[1];
    } else {
      $m = $l[0];
      $d = 0;
    }

    $pattern = "^-?[0-9]";
    if($d) $pattern .= "+(\\\\.[0-9]{1," . $d . "})?$";
    array_push($validators, "Validators.pattern('" . $pattern. "')");
    $v = str_pad("", $m, "9", STR_PAD_LEFT);
    if($d) $v .= ".".str_pad("", $d, "9", STR_PAD_RIGHT);
    ($field->getMax()) ? array_push($validators, "Validators.max(" . $field->getMax() . ")") :  array_push($validators, "Validators.max(" . $v . ")");
    ($field->getMin()) ? array_push($validators, "Validators.min(" . $field->getMin() . ")") :  array_push($validators, "Validators.max(-" . $v . ")");

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputTextOptions(),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function autocomplete(Field $field) {
    $default = $this->defaultString($field);
    
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputAutocompleteOptions({entityName:\"" . $field->getEntityRef()->getName() . "\"}),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function select(Field $field) {
    $default = $this->defaultString($field);

    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputSelectOptions({entityName:'" . $field->getEntityRef()->getName() . "'}),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
";
  }

  protected function selectParam(Field $field) {
    $default = (($field->getDataType() == "integer") 
      || ($field->getDataType() == "float")) ? $this->defaultNumber($field) : $this->defaultString($field);
      

    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $aux = (($field->getDataType() == "integer") 
      || ($field->getDataType() == "float")) ? "" : "'";

    $options="[{$aux}" . implode("{$aux},{$aux}",$field->getSelectValues()) . "{$aux}]";

    $this->string .= "    new FieldViewOptions({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
      type: new FieldInputSelectParamOptions({options:" . $options . "}),
";
    if($default) $this->string .= "      default:" . $default . ",
";
    $this->fieldControlOptions($validators,$asyncValidators);
    $this->string .= "    }),
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

  protected function validatorRequired(Field $field){
    return ($field->isNotNull()) ? "Validators.required" : false;
  }
 

}
