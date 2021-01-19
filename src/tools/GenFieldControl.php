<?php

require_once("function/snake_case_to.php");

class GenFieldControl {
  public $field;
  public $label;
  public $type = "default";
  public $default = null;
  public $validators = [];
  public $asyncValidators = [];
  public $entityName = null;
  public $options = null; //opciones para tipos select
  public $widthSm = null;
  public $widthGtSm = null;
  protected $string = "";

  public static function getInstance(array $params = []){
    $instance = new GenFieldControl();
    foreach($params as $key => $value){
      $instance->{snake_case_to("xxYy",$key)} = $value; 
    }
    return $instance;
  }

  function generate(){
    $this->string .= "    new FieldControl({
      field:\"" . $this->field . "\",
      label:\"" . $this->label . "\",
";


    if($this->type !== "default") $this->string .= "      type: \"" . $this->type . "\",
";  
    if(!is_null($this->default)) $this->string .= "      default: " . $this->default . ",
";  
    if(!is_null($this->entityName)) $this->string .= "      entityName: \"" . $this->entityName . "\",
";  
    if(!is_null($this->options)) $this->string .= "      options: ['" . implode("','",$this->options) . "'],
";  
    if(!is_null($this->widthSm)) $this->string .= "      widthSm: \"" . $this->widthSm . "\",
";  
    if(!is_null($this->widthGtSm)) $this->string .= "      widthGtSm: \"" . $this->widthGtSm . "\",
";  
    if(!empty($this->validators)) $this->string .= "      validators: [" . implode(', ', $this->validators) . "],
";    
    if(!empty($this->asyncValidators)) $this->string .= "      asyncValidators: [" . implode(', ', $this->asyncValidators) . "],
";  
    $this->string .= "    }),

";
    return $this->string;
  }
}