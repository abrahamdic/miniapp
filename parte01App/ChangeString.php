<?php

class ChangeString {

	public function build($string)
	{
		$nuevo_string = '';

		// obtengo el string como array
		$micadena = $this->micadena($string);

		// por cada item del array
		foreach ($micadena as $key => $caracter) {
			
			// identifico si el caracter es mayuscula para volver convertir la letra del abecedario()
			$flag_mayus = ctype_upper($caracter);

			// busco las minúsculas del caracter en el abecedario() y obtengo la clave de la coincidencia
			$rev = array_search(strtolower($caracter), $this->abecedario());
			
			// si no existe es false por lo tanto tomo el caracter igual en el nuevo_string 
			if ($rev === false) {
				$nuevo_string .= $caracter;

			} else {
				// caso contrario: he obtenido la clave de abecedario() y muestro el que sigue sumando  +1
				$letra = $this->abecedario()[$rev + 1];
				// si la letra fue mayúscula lo convierto
				$nuevo_string .= ($flag_mayus) ? $this->convermayus($letra) : $letra;

			}
		}
		
		return $nuevo_string;

	}

	public function micadena($cadena)
	{
		$array = [];

		//obtengo el total de la cadena
		$total = strlen($cadena);
		
		//obtengo cada letra de la cadena en un array
		for ($i=0; $i < $total; $i++) { 
			$array[] = substr($cadena, $i, 1);
		}

		//devuelvo el array
		return $array;

	}
	public function convermayus($c)
	{
		return strtoupper($c);
	}
	function abecedario()
	{
		// el caracter 'a' será tomado una sola vez
		return ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z','a'];
	}
}

$resultado = new ChangeString;
echo $resultado->build("123 abcd*3");
echo "<br>";
echo $resultado->build("**Casa 52");
echo "<br>";
echo $resultado->build("**Casa 52Z");

