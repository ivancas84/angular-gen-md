<?php

require_once("GenerateFile.php");

class GenDataDefinitionLabel extends GenerateFile {

  protected $structure;

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct($_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/"."src/app/service/data-definition-label/", "data-definition-label.service.ts");
  }

  protected function generateCode(){
    $this->string .= "import { Injectable } from '@angular/core';

import { _DataDefinitionLabelService } from '@service/data-definition-label/_data-definition-label.service';

@Injectable({
  providedIn: 'root'
})
export class DataDefinitionLabelService extends _DataDefinitionLabelService{ }
/**
 * La forma mas sencilla de definir o sobrescribir un metodo label 
 * es a traves de una sucesion de switchMap
 * Ejemplo:
 * labelCurso(id: string): Observable<any> {
 * return this.dd.get('curso', id).pipe(
 *  switchMap(
 *   curso => {
 *     return this.dd.getConnection(curso,'asignatura','asignatura',{asignatura:'nombre'})
 *   }
 * ),
 * switchMap(
 *   curso => {
 *     return this.dd.getConnection(curso,'comision','comision',{division:'division',sede:'sede',planificacion:'planificacion'})
 *   }
 * ),
 * switchMap(
 *   curso => {
 *     return this.dd.getConnection(curso,'planificacion','planificacion',{anio:'anio',semestre:'semestre'})
 *   }
 * ),
 * switchMap(
 *   curso => {
 *     return this.dd.getConnection(curso,'sede','sede',{numero_sede:'numero'})
 *   }
 * ),
 * map(
 *   curso => { 
 *     return (!curso)? null : curso['numero_sede']+curso['division']+'/'+curso['anio']+curso['semestre']+' '+curso['asignatura']; 
 *   }
 * )
 *);
}

";
  }

}
