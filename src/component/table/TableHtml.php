<?php

require_once("GenerateFileEntity.php");


class GenTableHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-table.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();
  }


  protected function start(){
    $this->string .= "<mat-card>
  <mat-card-header>
    <mat-card-title>" . $this->getEntity()->getName("Xx Yy") . "</mat-card-title>
  </mat-card-header>
  <mat-card-content>
    <table mat-table *ngIf=\"(load$ | async)\" [dataSource]=\"dataSource\" matSort matSortDisableClear (matSortChange)=\"onChangeSort(\$event)\" class=\"mat-elevation-z8\">
";
  }


  protected function nf(){
    foreach ($this->getEntity()->getFieldsNf() as $field) {
      switch($field->getSubtype()){
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field); break;
        case "timestamp": $this->timestamp($field); break;
        case "time": $this->time($field); break;
        default: $this->defecto($field); break;
      }
    }
  }



  protected function fk(){
    foreach($this->getEntity()->getFieldsFk() as $field){
      switch($field->getSubtype()){
        default: $this->link($field); break;
      }
    }
  }


  protected function end(){
    $this->string .= "      <tr mat-header-row *matHeaderRowDef=\"displayedColumns\"></tr>
      <tr mat-row *matRowDef=\"let row; columns: displayedColumns;\"></tr>
    </table>  
  </mat-card-content>
</mat-card>
";
  }

  protected function options(){
    $this->string .= "      <ng-container matColumnDef=\"options\">
        <th mat-header-cell *matHeaderCellDef> Opciones </th>
        <td mat-cell *matCellDef=\"let row\"> 
          <!-- a [routerLink]=\"['/" . $this->getEntity()->getName("xx-yy") . "-detail']\" [queryParams]=\"{id:row.id}\" ><span class=\"oi oi-eye\" title=\"Detalle\"></span></a>    
          <a [routerLink]=\"['/" . $this->getEntity()->getName("xx-yy") . "-admin']\" [queryParams]=\"{id:row.id}\" ><span class=\"oi oi-pencil\" title=\"Modificar\"></span></a>              
          <!-- button type=\"button\" (click)=\"delete(i)\"><span class=\"oi oi-trash\" title=\"Eliminar\"></span></button -->
        </td>
      </ng-container>

";
  }

  protected function defecto(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> {{row." . $field->getName() . "}} </td>
      </ng-container>

";
  }

  protected function textarea(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\" title=\"{{row." . $field->getName() . "}}\"> {{row." . $field->getName() . " | summary}} </td>
      </ng-container>

";
  }

  protected function date(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> {{row." . $field->getName() . " | toDate | date:'dd/MM/yyyy'}} </td>
      </ng-container>

";
  }

  protected function checkbox(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> {{row." . $field->getName() . " | siNo}} </td>
      </ng-container>

";
  }

  protected function time(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> {{row." . $field->getName() . " | toDate | date:'HH:mm'}} </td>
      </ng-container>

";
  }

  protected function timestamp(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> {{row." . $field->getName() . " | toDate | date:'dd/MM/yyyy HH:mm'}} </td>
      </ng-container>

";
  }
  
  protected function link(Field $field){
    $this->string .= "      <ng-container matColumnDef=\"{$field->getName()}\">
        <th mat-header-cell *matHeaderCellDef mat-sort-header> {$field->getName('Xx Yy')} </th>
        <td mat-cell *matCellDef=\"let row\"> 
          <a [routerLink]=\"['/" . $field->getEntityRef()->getName("xx-yy") . "-show']\" [queryParams]=\"{id:row." . $field->getName() . "}\" >{{row." . $field->getName() . " | label:'{$field->getEntityRef()->getName()}'}}</a>
        </td>
      </ng-container>

";
  }
}