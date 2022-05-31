<?php

/**
 * Controlador para generar el proyecto angular-gen-md
 * Es posible seleccionar la generacion de una determinada interfaz mediante el parametro "gen", ejemplo ...?gen=nombre
 * Utiliza elementos de la estructura del proyecto.
 */

require_once("../config/config.php");
require_once("class/Container.php");



$container = new Container();

require_once("service/data-definition-label/_DataDefinitionLabel.php");
$gen = new _GenDataDefinitionLabel($container->getStructure());
$gen->generate();

require_once("service/data-definition-label/DataDefinitionLabel.php");
$gen = new GenDataDefinitionLabel($container->getStructure());
$gen->generateIfNotExists();