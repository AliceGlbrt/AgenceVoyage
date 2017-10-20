<?php

/**
 * Application d'exemple Agence de voyages Silex
 */

// require_once __DIR__.'/vendor/autoload.php';
$vendor_directory = getenv ( 'COMPOSER_VENDOR_DIR' );
if ($vendor_directory === false) {
	$vendor_directory = __DIR__ . '/vendor';
}
require_once $vendor_directory . '/autoload.php';



// Initialisations
$app = require_once 'initapp.php';

require_once 'agvoymodel.php';



// Routage et actions

$app->get ( '/admin/circuit', 
    function () use ($app) 
    {
    	$circuitslist = get_all_circuits ();
    	// print_r($circuitslist);
    	
    	return $app ['twig']->render ( 'backEnd/circuitslist.html.twig', [
    			'circuitslist' => $circuitslist
// circuitlist : Liste tous les circuits
    	] );
    }
)->bind ( 'circuitslist' );


// circuitlistfutur : Liste des circuits pour le client

$app->get ( '/circuit', 
    function () use ($app) 
    {
    	$circuitslist = get_all_circuits ();
    	// print_r($circuitslistfutur);
    	
    	return $app ['twig']->render ( 'frontEnd/circuitslistclient.html.twig', [
    			'circuitslist' => $circuitslist
    	] );
    }
)->bind ( 'circuitslistclient' );


// circuitshow : affiche les détails d'un circuit
$app->get ( 'admin/circuit/{id}', 
	function ($id) use ($app) 
	{
		$circuit = get_circuit_by_id ( $id );
		// print_r($circuit);
		$programmations = get_programmations_by_circuit_id ( $id );
		//$circuit ['programmations'] = $programmations;

		return $app ['twig']->render ( 'backEnd/circuitshow.html.twig', [ 
				'id' => $id,
				'circuit' => $circuit 
			] );
	}
)->bind ( 'circuitshow' );

// circuitshowclient : affiche les détails d'un circuit vu par le client
$app->get ( '/circuit/{id}', 
	function ($id) use ($app) 
	{
		$circuit = get_circuit_by_id ( $id );
		// print_r($circuit);
		$programmations = get_programmations_by_circuit_id ( $id );
		//$circuit ['programmations'] = $programmations;

		return $app ['twig']->render ( 'frontEnd/circuitshowclient.html.twig', [ 
				'id' => $id,
				'circuit' => $circuit 
			] );
	}
)->bind ( 'circuitshowclient' );

// detailEtape : affiche le détail des étapes d'un circuit
$app->get ( 'circuit/{id}/etapes', 
	function ($id) use ($app) 
	{
		$circuit = get_circuit_by_id ( $id );
		// print_r($circuit);
		$programmations = get_programmations_by_circuit_id ( $id );
		//$circuit ['programmations'] = $programmations;

		return $app ['twig']->render ( 'detailEtape.html.twig', [ 
				'id' => $id,
				'circuit' => $circuit 
			] );
	}
)->bind ( 'detailEtape' );


// programmationlist : liste tous les circuits programmés
$app->get ( '/programmation', 
	function () use ($app) 
	{
		$programmationslist = get_all_programmations ();
		// print_r($programmationslist);

		return $app ['twig']->render ( 'programmationslist.html.twig', [ 
				'programmationslist' => $programmationslist 
			] );
	}
)->bind ( 'programmationlist' );

$app->run ();
