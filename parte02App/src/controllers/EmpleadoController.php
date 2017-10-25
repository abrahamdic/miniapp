<?php

namespace src\controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Componentes\JsonBD;
use Exception;

class EmpleadoController
{
	protected $view;
	protected $empleado;

	public function __construct(\Slim\Container $view)
	{
		// inicializacion de variables 
		$this->view = $view;
		$this->empleado = new JsonBD;
		
	}
	function index($request, $response, $args)
	{
		// para mostrar todos los registros del json
		return $this->view->renderer->render(
			$response, 
			'empleado/index.phtml', 
			[
				'data'	=>	$this->empleado->all(),
				'msg'	=> 	''

			]
		);
		
	}
	function show($request, $response, $args)
	{
		try {
			if (isset($args['id']))
			{
				// se muestra un solo registro buscado por id
				return $this->view->renderer->render(
					$response, 
					'empleado/show.phtml', 
					[
						'data' 	=> $this->empleado->searchBy($args['id'], 'id'), 
						'msg'	=> ''
					]
				);

			} else { throw new Exception("No se ha enviado el Id."); }
		} catch (Exception $e) { return $this->mensajeerror($e, $response); }
		
	}
	function buscador($request, $response, $args)
	{
		try {
			// valido si existe información para buscar
			if (isset($request->getQueryParams()['string']) && !empty($request->getQueryParams()['string']))
			{
				// realiza la búsqueda por email, el parámetro recibido es mediante GET el campo se llama 'string'
				return $this->view->renderer->render(
					$response, 
					'empleado/index.phtml', 
					[
						'data' 	=> $this->empleado->searchBy($request->getQueryParams()['string'], 'email'), 
						'msg'	=> 'Búsqueda satisfactoria.'
					]
				);

			} else { throw new Exception("Ingrese un email en el campo superior, para empezar la búsqueda"); }
		} catch (Exception $e) { return $this->mensajeerror($e, $response); }
		
	}
	function mensajeerror($e, $r)
	{
		return $this->view->renderer->render(
					$r, 
					'empleado/index.phtml', 
					[
						'data' 	=> [], 
						'msg'	=> $e->getMessage()
					]
				);
	}
	public function salario($request, $response, $args) {

		try {
			
			if (isset($args['salario_min']) && isset($args['salario_max'])) {

				// obtengo el array con las coincidencias
				$data = $this->empleado->rangoSalario('salary', $args['salario_max'], $args['salario_min']);

			    $nueva_respuesta = $response->withHeader('Content-type', 'application/xml');

			    // construyo el contenido xml
			    $xml = new \SimpleXMLElement('<empleados/>');
			        foreach ($data as $r) {
			            //se puede mostrar todos los valores
			            $item = $xml->addChild('data');
			            $item->addChild('name', $r['name']);
			            $item->addChild('email', $r['email']);
			            $item->addChild('position', $r['position']); 
			            $item->addChild('salary', $r['salary']); 
			        }
			    
			    echo  $xml->asXml();

			    return $nueva_respuesta;

			} else {
				throw new Exception("Debe enviar un salario máximo y mínimo.");
				
			}

		} catch (Exception $e) { return $this->mensajeerror($e, $response); }

	}
}