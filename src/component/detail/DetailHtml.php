<?php

require_once("GenerateFileEntity.php");


class Gen_DetailHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-detail.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/detail/" . $entity->getName("xx-yy") . "-detail/";
    parent::__construct($directorio, $file, $entity);
  }

  public function generateCode() {
    $this->string .= "<ng-template #loading>
  <mat-progress-bar mode=\"indeterminate\"></mat-progress-bar>
</ng-template>

<div *ngIf=\"(load$ | async); else loading\">
  <mat-progress-bar *ngIf=\"!load\" mode=\"indeterminate\"></mat-progress-bar>
  <app-" . $this->getEntity()->getName("xx-yy") . "-card [data]=\"data\"></app-" . $this->getEntity()->getName("xx-yy") . "-card>
</div>
";

  }
}
