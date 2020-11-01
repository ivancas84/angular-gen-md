<?php

require_once("GenerateEntity.php");


class GenDataDefinitionLabel_labelEntity extends GenerateEntity {

  public $fields = [];

  public function generate() {
    $this->defineFields();

    $this->start();
    $this->fk();
    $this->end();
    return $this->string;
  }


  protected function defineFields(){
   $this->fields["fk"] = array();

   $fk = $this->getEntity()->getFieldsFk();

   foreach ($fk as $field){ if($field->isMain()) array_push($this->fields["fk"], $field); }
 }

  protected function start(){
    $this->string .= "  label" . $this->entity->getName("XxYy"). "(id: string): Observable<any> {
    return this.dd.get(\"" . $this->entity->getName(). "\", id).pipe(
      switchMap(
        row => {
          if(!row) return of(null);
          return combineLatest([
            of(this.label" . $this->entity->getName("XxYy"). "Row(row)),
";
  }


  protected function fk(){
    if(!count($this->fields["fk"])) return;
        
    $fields = $this->fields["fk"];

    foreach($fields as $field) $this->get($field);
  }

  protected function get(Field $field){
    $this->string .= "            this.label" . $field->getEntityRef()->getName("XxYy") . "(row." . $field->getName() . "),
";
  }

  protected function end(){
    $this->string .= "          ])
        }
      ),
      map(
        response => { return (!response)? null : response.join(\" \"); }
      )
    );
  }

";
  }




}
