<?php

namespace Componentes;

class JsonBD
{
	protected $file = __DIR__ . '/files/employees.json';
	public $data;

	function __construct()
	{
		// esta variable contiene el json como array
		$this->data = $this->leerJsonFile();

	}
	function leerJsonFile()
	{
		// el json es devuelto como array asociativo.
		return json_decode(file_get_contents($this->file), true);

	}
	function all()
	{
		// utilizado para mostrar todo los registros
		return $this->data;

	}
	function searchBy($cadena, $campo)
	{
		// esta funcion de php facilita la búsqueda en arrays asociativos
		return array_filter($this->data, function($value, $key) use ($cadena, $campo){
			// por cada valor del array busco si hay coincidencia con la $cadena enviada
			// el parámetro $campo es variable, quiere decir que se puede buscar por cualquier campo pero uno a la vez
			return strpos($value[$campo], $cadena) !== false;

			// ARRAY_FILTER_USE_BOTH es para buscar en los valores y en la clave
		}, ARRAY_FILTER_USE_BOTH);
		
	}
	function rangoSalario($campo, $max, $min)
	{
		// esta funcion de php facilita la búsqueda en arrays asociativos
		return array_filter($this->data, function($value, $key) use ($campo, $max, $min){
			
			// validación del rangos
			return $this->convert($value[$campo]) < $max && $this->convert($value[$campo]) > $min;

			// ARRAY_FILTER_USE_BOTH es para buscar en los valores y en la clave
		}, ARRAY_FILTER_USE_BOTH);
		
	}
	function convert($string)
	{
		// quito las comas, quito símbolo de dolar y obtengo el valor flotante
		return floatval(substr(str_replace(',', '', $string), 1));
	}
}