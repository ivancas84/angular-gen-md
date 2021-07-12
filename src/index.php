<?php

/**
 * Controlador para generar el proyecto angular-gen-md
 * Es posible seleccionar la generacion de una determinada interfaz mediante el parametro "gen", ejemplo ...?gen=nombre
 * Utiliza elementos de la estructura del proyecto.
 */

require_once("../config/config.php");
require_once("class/Container.php");



$container = new Container();
storageService($container->getStructure());
labelService($container->getStructure());


foreach($container->getStructure() as $entity) {
  
      //services
      //dataDefinition($entity);
      //components
      admin($entity);
      detail($entity);
      show($entity);
      inputPicker($entity);


      /*
      searchCondition($entity);
      searchOrder($entity);
      grid($entity);
      unorderedList($entity);
      detail($entity);
      */
}


function storageService(array $structure) {
  require_once("service/data-definition-storage/DataDefinitionStorage.php");
  $gen = new GenDataDefinitionStorage($structure);
  $gen->generate();
}

function labelService(array $structure) {
  require_once("service/data-definition-label/_DataDefinitionLabel.php");
  $gen = new _GenDataDefinitionLabel($structure);
  $gen->generate();

  require_once("service/data-definition-label/DataDefinitionLabel.php");
  $gen = new GenDataDefinitionLabel($structure);
  $gen->generateIfNotExists();
}

function show(Entity $entity) {
  require_once("component/show/ShowTs.php");
  $gen = new Gen_ShowTs($entity);
  $gen->generate();
}

function admin(Entity $entity) {
  require_once("component/admin/AdminTs.php");
  $gen = new Gen_AdminTs($entity);
  $gen->generate();
}

function detail(Entity $entity) {
  require_once("component/detail/DetailTs.php");
  $gen = new GenDetailTs($entity);
  $gen->generate();

  require_once("component/detail/DetailHtml.php");
  $gen = new Gen_DetailHtml($entity);
  $gen->generate();
}


function label(Entity $entity) {
  require_once("component/label/LabelTs.php");
  $gen = new GenLabelTs($entity);
  $gen->generate();

  require_once("component/label/LabelHtml.php");
  $gen = new GenLabelHtml($entity);
  $gen->generate();
}




function grid(Entity $entity) {
  require_once("component/showElement/grid/GridTs.php");
  $gen = new GenGridTs($entity);
  $gen->generate();

  require_once("component/showElement/grid/GridHtml.php");
  $gen = new GenGridHtml($entity);
  $gen->generate();
}

function unorderedList(Entity $entity) {
  require_once("component/showElement/list/ListTs.php");
  $gen = new GenListTs($entity);
  $gen->generate();

  require_once("component/showElement/List/ListHtml.php");
  $gen = new GenListHtml($entity);
  $gen->generate();
}

function searchCondition(Entity $entity) {
  require_once("component/searchCondition/SearchConditionTs.php");
  $gen = new Gen_SearchConditionTs($entity);
  $gen->generate();

  require_once("component/searchCondition/SearchConditionHtml.php");
  $gen = new Gen_SearchConditionHtml($entity);
  $gen->generate();
}

function searchOrder(Entity $entity) {
  require_once("component/searchOrder/SearchOrderTs.php");
  $gen = new Gen_SearchOrderTs($entity);
  $gen->generate();

  require_once("component/searchOrder/SearchOrderHtml.php");
  $gen = new Gen_SearchOrderHtml($entity);
  $gen->generate();
}


function inputPicker(Entity $entity){
  require_once("component/inputPicker/InputPickerTs.php");
  $gen = new GenInputPickerTs($entity);
  $gen->generate();

  require_once("component/inputPicker/InputPickerHtml.php");
  $gen = new GenInputPickerHtml($entity);
  $gen->generate();
}