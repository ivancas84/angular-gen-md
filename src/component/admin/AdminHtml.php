<?php

require_once("GenerateFileEntity.php");


class Gen_AdminHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-admin.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/admin/" . $entity->getName("xx-yy") . "-admin/";
    parent::__construct($directorio, $file, $entity);
  }

  public function generateCode() {
    $this->string .= "<form [formGroup]=\"adminForm\" (ngSubmit)=\"onSubmit()\" novalidate autocomplete=\"off\">
  <app-" . $this->getEntity()->getName("xx-yy") . "-fieldset [form]=\"adminForm\" [data\$]=\"data\$\"></app-" . $this->getEntity()->getName("xx-yy") . "-fieldset>

  <button mat-raised-button [disabled]=\"adminForm.pending || isSubmitted\" type=\"submit\" color=\"primary\">Aceptar</button>&nbsp;
  <button mat-mini-fab color=\"accent\" type=\"button\"  (click)=\"back()\"><mat-icon>keyboard_backspace</mat-icon></button>
  <button mat-mini-fab color=\"accent\" type=\"button\" (click)=\"reset()\"><mat-icon>clear_all</mat-icon></button>
  <button mat-mini-fab color=\"accent\" type=\"button\" (click)=\"clear()\"><mat-icon>add</mat-icon></button>
  <button mat-mini-fab color=\"warn\" type=\"button\" [disabled]=\"isDeletable\" (click)=\"delete()\"><mat-icon>delete</mat-icon></button>

  <!--p>Debug Form value: {{ adminForm.value | json }}</p>
  <p>Debug Form status: {{ adminForm.status | json }}</p-->
</form>
";

  }
}
