<?php

require_once("GenerateFileEntity.php");

class Gen_SearchHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "<mat-accordion>
  <mat-expansion-panel hideToggle>
    <mat-expansion-panel-header>
      <mat-panel-title>Opciones</mat-panel-title>
    </mat-expansion-panel-header>
    <form [formGroup]=\"searchForm\" novalidate (ngSubmit)=\"onSubmit()\">       
      <core-search-all [form]=\"searchForm\" [display]=\"display\"></core-search-all>
      <!--app-{$this->entity->getName('xx-yy')}-search-params [form]=\"searchForm\" [display]=\"display\"></app-{$this->entity->getName('xx-yy')}-search-params-->
      <!--app-{$this->entity->getName('xx-yy')}-search-condition [form]=\"searchForm\" [display]=\"display\"></app-{$this->entity->getName('xx-yy')}-search-condition-->
      <!--app-{$this->entity->getName('xx-yy')}-search-order [form]=\"searchForm\" [display]=\"display\"></app-{$this->entity->getName('xx-yy')}-search-order-->
      <button mat-raised-button color=\"primary\" type=\"submit\">Buscar</button>&nbsp;
    </form>
  </mat-expansion-panel>
</mat-accordion>
";
  }

}
