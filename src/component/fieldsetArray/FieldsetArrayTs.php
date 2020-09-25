<?php

require_once("component/fieldset/FieldsetTs.php");

class FieldsetArrayTs extends FieldsetTs {

  public function __construct(Entity $entity) {
    $file = $entity->getName("xx-yy") . "-fieldset-array.component.ts";
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset-array/" . $entity->getName("xx-yy") . "-fieldset-array/";
    parent::__construct($entity, $dir, $file);
  }

  protected function component(){
    $this->string .="import { FieldsetArrayComponent } from '@component/fieldset-array/fieldset-array.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-fieldset-array',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-fieldset-array.component.html',
})
export class " . $this->entity->getName("XxYy") . "FieldsetArrayComponent extends FieldsetArrayComponent {

";
  }

  protected function formGroup(){
    require_once("component/fieldsetArray/_FormGroup.php");
    $gen = new FieldsetArrayTs_formGroup($this->entity);
    $this->string .= $gen->generate();
  }
  

  protected function getters(){
    foreach($this->entity->getFieldsByType(["pk","nf","fk"]) as $field){
      if(!$field->isAdmin()) continue;
      $this->string .= "  {$field->getName('xxYy')}(index: number) { return this.fieldset.at(index).get('{$field->getName()}')}
";
    }
    $this->string .= "  _delete(index: number) { return this.fieldset.at(index).get('_delete')}

";
  }

}
