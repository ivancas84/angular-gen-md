<?php

/**
 * Controlador para generar el proyecto angular-gen-md
 * Es posible seleccionar la generacion de una determinada interfaz mediante el parametro "gen", ejemplo ...?gen=nombre
 * Utiliza elementos de la estructura del proyecto.
 */

require_once("../config/config.php");
require_once("class/model/entity/structure.php");
require_once("class/tools/Filter.php");

require_once("service/data-definition-loader/DataDefinitionLoader.php");

$generate = Filter::get("gen");

switch($generate) {
  case null: case "loader": loader($structure); break;
}


foreach($structure as $entity) {
  switch($generate){
    //services
    case "data-definition": dataDefinition($entity); break;
    
    //components
    case "admin": admin($entity); break;
    case "fieldset": fieldset($entity); break;
    case "table": table($entity); break;
    case "show": show($entity); break;
    case "search": search($entity); break;
    case "search-params": searchParams($entity); break;
    case "input-picker": inputPicker($entity); break;

    /*
    case "detail": detail($entity); break;
    case "card": card($entity); break;
    case "grid": grid($entity); break;
    case "unordered-list": unorderedList($entity); break;
    case "search-condition": searchCondition($entity); break;
    case "search-order": searchOrder($entity); break;
    */
    case null:
      //services
      dataDefinition($entity);
      //components
      admin($entity);
      fieldset($entity);
      table($entity);
      show($entity);
      search($entity);
      searchParams($entity);
      inputPicker($entity);


      /*
      searchCondition($entity);
      searchOrder($entity);
      grid($entity);
      unorderedList($entity);
      detail($entity);
      card($entity);
      */
    break;
  }
}


function loader(array $structure) {
  $gen = new DataDefinitionLoaderService($structure);
  $gen->generate();
}

function dataDefinition(Entity $entity) {
  require_once("class/data-definition/_DataDefinition.php");
  $gen = new _ClassDataDefinition($entity);
  $gen->generate();

  require_once("class/data-definition/DataDefinition.php");
  $gen = new ClassDataDefinition($entity);
  $gen->generateIfNotExists();
}

function show(Entity $entity) {
  require_once("component/show/ShowTs.php");
  $gen = new Gen_ShowTs($entity);
  $gen->generate();

  require_once("component/show/ShowHtml.php");
  $gen = new Gen_ShowHtml($entity);
  $gen->generate();
}

function admin(Entity $entity) {
  require_once("component/admin/AdminTs.php");
  $gen = new Gen_AdminTs($entity);
  $gen->generate();

  require_once("component/admin/AdminHtml.php");
  $gen = new Gen_AdminHtml($entity);
  $gen->generate();
}

function detail(Entity $entity) {
  require_once("component/detail/DetailTs.php");
  $gen = new Gen_DetailTs($entity);
  $gen->generate();

  require_once("component/detail/DetailHtml.php");
  $gen = new Gen_DetailHtml($entity);
  $gen->generate();
}

function card(Entity $entity) {
  require_once("component/card/CardTs.php");
  $gen = new GenCardTs($entity);
  $gen->generate();

  require_once("component/card/CardHtml.php");
  $gen = new GenCardHtml($entity);
  $gen->generate();
}

function fieldset(Entity $entity) {
  require_once("component/fieldset/FieldsetTs.php");
  $gen = new FieldsetTs($entity);
  $gen->generate();

  require_once("component/fieldset/FieldsetHtml.php");
  $gen = new FieldsetHtml($entity);
  $gen->generate();
}

function table(Entity $entity) {
  require_once("component/table/TableTs.php");
  $gen = new GenTableTs($entity);
  $gen->generate();

  require_once("component/table/TableHtml.php");
  $gen = new GenTableHtml($entity);
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
function search(Entity $entity) {
  require_once("component/search/SearchTs.php");
  $gen = new Gen_SearchTs($entity);
  $gen->generate();

  require_once("component/search/SearchHtml.php");
  $gen = new Gen_SearchHtml($entity);
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

function searchParams(Entity $entity) {
  require_once("component/searchParams/SearchParamsTs.php");
  $gen = new Gen_SearchParamsTs($entity);
  $gen->generate();

  require_once("component/searchParams/SearchParamsHtml.php");
  $gen = new Gen_SearchParamsHtml($entity);
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