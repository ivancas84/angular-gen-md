<?php

require_once("GenerateFileEntity.php");

class Gen_SearchHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "<mat-card>
  <mat-card-header>
    <mat-card-title (click)=\"optCard = !optCard\">Opciones</mat-card-title>
  </mat-card-header>
  <mat-card-content>  
    <form [formGroup]=\"searchForm\" novalidate (ngSubmit)=\"onSubmit()\">       
      <core-search-all [form]=\"searchForm\" [display$]=\"display$\"></core-search-all>
      <!--app-{$this->entity->getName('xx-yy')}-search-params [form]=\"searchForm\" [display$]=\"display$\"></app-{$this->entity->getName('xx-yy')}-search-params-->
      <!--app-{$this->entity->getName('xx-yy')}-search-condition [form]=\"searchForm\" [display$]=\"display$\"></app-{$this->entity->getName('xx-yy')}-search-condition-->
      <!--app-{$this->entity->getName('xx-yy')}-search-order [form]=\"searchForm\" [display$]=\"display$\"></app-{$this->entity->getName('xx-yy')}-search-order-->

      <button mat-raised-button color=\"primary\" type=\"submit\">Aceptar</button>&nbsp;
    </form>
  </mat-card-content>
</mat-card>
";
  }

}
