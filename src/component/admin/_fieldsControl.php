<?php

require_once("GenerateEntity.php");
require_once("function/settypebool.php");

class GenAdminTs_fieldsControl extends GenerateEntity {


  public function generate() {
    $this->start();
    $this->pk();
    $this->nf();
    $this->fk();
    $this->end();

    return $this->string;
  }


  protected function start() {
    $this->string .= "  fieldsControl: FieldControl[] = [
";
  }

  protected function pk() {
    $this->fieldControl($this->getEntity()->getPk(), "hidden");
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

  protected function fieldControl($field, $type, $default = null, $validators = [], $asyncValidators = [], $entityName = null, $options = null){
    $this->string .= "    new FieldControl({
      field:\"" . $field->getName() . "\",
      label:\"" . $field->getName("Xx Yy") . "\",
";


    if($type !== "default") $this->string .= "      type: \"" . $type . "\",
";  
    if(!is_null($default)) $this->string .= "      default: " . $default . ",
";  
    if(!is_null($entityName)) $this->string .= "      entityName: \"" . $entityName . "\",
";  
    if(!is_null($options)) $this->string .= "      options: ['" . implode("','",$field->getSelectValues()) . "'],
";  
    if(!empty($validators)) $this->string .= "      validators: [" . implode(', ', $validators) . "],
";    
    if(!empty($validators)) $this->string .= "      asyncValidators: [" . implode(', ', $asyncValidators) . "],
";  
    $this->string .= "    }),

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

  protected function checkbox(Field $field) {
    $default = (settypebool($field->getDefault())) ? "true":"false";
    $this->fieldControl($field, "checkbox", $default);
  }

  protected function defecto(Field $field) {
    $default = (is_null($field->getDefault())) ? null : "\"{$field->getDefault()}\"";

    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "default", $default, $validators, $asyncValidators);
  }

  protected function email(Field $field) {
    $validators = ["Validators.pattern(\"[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\\.[a-z]{2,3}\")"];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "default", $default, $validators, $asyncValidators);
  }

  protected function dni(Field $field) {
    $validators = array("Validators.minLength(7)", "Validators.maxLength(9)", "Validators.pattern('^[0-9]*$')");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "default", $this->defaultString($field), $validators, $asyncValidators);
  }

  protected function year(Field $field) {
    $validators = array("this.validators.year()");
    if($field->getMax()) array_push($validators, "this.validators.maxYear('" . $field->getLength() . "')");
    if($field->getMin()) array_push($validators, "this.validators.minYear('" . $field->getMinLength() . "')");
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "year", $this->defaultDateTime($field), $validators, $asyncValidators);
  }

  protected function date(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "date", $this->defaultDateTime($field), $validators, $asyncValidators);
  }

  protected function integer(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "default", $this->defaultNumber($field), $validators, $asyncValidators);
  }

  protected function float(Field $field) {
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

    $this->fieldControl($field, "float", $this->defaultNumber($field), $validators, $asyncValidators);
  }

  protected function autocomplete(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "autocomplete", $this->defaultString($field), $validators, $asyncValidators, $field->getEntityRef()->getName());
  }

  protected function select(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $this->fieldControl($field, "select", $this->defaultString($field), $validators, $asyncValidators, $field->getEntityRef()->getName());
  }

  protected function selectParam(Field $field) {
    $validators = [];
    if($this->validatorRequired($field)) array_push($validators, $this->validatorRequired($field));

    $asyncValidators = [];
    if($this->asyncValidatorUnique($field)) array_push($asyncValidators, $this->asyncValidatorUnique($field));

    $options="\"['" . implode("','",$field->getSelectValues()) . "']\"";

    $this->fieldControl($field, "select_param", $this->defaultString($field), $validators, $asyncValidators, null, $field->getSelectValues());
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
