<?php

class ClearPar {

	protected $cadena_array = [];

	public function build($string)
	{
		// validación del string
		if (strlen($string) == 0) {
			return "Campos vacío, sin caracteres.";
		}

		// esta variable recibe el string como array para validación de caracteres permitidos
		$this->cadena_array = str_split($string);

		if ($this->validarcadena($string)) {
			
			$cadena = '';
			// contando las coincidencias de : '()'
			$cant = substr_count($string, '()');

			// de acuerdo a las coincidencias devuelvo una nueva cadena según la cantidad
			for ($i=0; $i < $cant; $i++) { 
				$cadena .= '()';
			}
			
			return $cadena;
		}

		return "La cadena no tiene el formato correcto. Solo se permite \"(\" o \")\".";

	}
	public function validarcadena($string)
	{
		foreach ($this->cadena_array as $value) {
			// validando si existe '('
			if ($value !== '(') {
				if ($value !== ')') {
					return false;

				}
			}
		}
		return true;
	}
}

$resultado = new ClearPar;
echo $resultado->build('()())()');
echo "<br>";
echo $resultado->build('()(()');
echo "<br>";
echo $resultado->build('r)(');
echo "<br>";
echo $resultado->build('((()');
echo "<br>";
echo $resultado->build('');