<?php

require_once("GenerateFileEntity.php");


class Gen_ShowHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-show.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->string .= "<ng-template #loading>
  <mat-progress-bar mode=\"indeterminate\"></mat-progress-bar>
</ng-template>

<!-- app-" . $this->getEntity()->getName("xx-yy") . "-search [display$]=\"display\$\"></app-" . $this->getEntity()->getName("xx-yy") . "-search -->
<app-" . $this->getEntity()->getName("xx-yy") . "-table *ngIf=\"load; else loading\" [data$]=\"data$\" [collectionSize$]=\"collectionSize$\" [display$]=\"display$\"></app-" . $this->getEntity()->getName("xx-yy") . "-table>
";

  }
}
