<?php

class CompleteRange {

	protected $flag = ['false'];

	public function build($range)
	{
		$nuevo_range = [];

		//obtengo el numero mayor y menor del array ordenado
		$numero = $this->mayormenor($this->ordenamiento($range));

		$mayor = $numero['mayor'];
		$menor = $numero['menor'];

		//creo un nuevo rango con los números que faltaban
		for ($i=$menor; $i < $mayor + 1; $i++) { 
			$nuevo_range[] = $menor;
			$menor++;
		}

		return $this->salida($nuevo_range);
	}
	public function build2($range)
	{
		$nuevo_range = [];

		// esta funcion de php ordena los valores del array
		sort($range, SORT_NUMERIC);

		// por cada valor del rango enviado
		foreach ($range as $key => $value) {

			// esto es para verificar que el último valor no se realice
			if (isset($range[$key+1])) {

				// obtengo la diferencia cuando el segundo valor es menor al primero menos 1
				/** ejemplo: 
				* [1,2,4,5] (1) 2-1-1 = 0 entonces no se ingresa al if
				* 			(2) 4-2-1 = 1 entonces si se ingresa al if porque hay un valor nuevo es ese rango
				*/
				$resta = $range[$key+1] - $value - 1;
				
				if ($resta >= 1) {
					// los nuevos rangos encontrados los voy uniendo
					$nuevo_range = array_merge_recursive($nuevo_range,range($value + 1, $range[$key+1] - 1));	
				}
			}
		}

		// finalmente el rango actual con el rango nuevo se unen
		$a = array_merge($range, $nuevo_range);
		// con esto ordeno nuevamente el array 
		sort($a, SORT_NUMERIC);
		
		return $this->salida($a);
	}
	function mayormenor($array)
	{
		return [
			'menor' => $array[0],
			'mayor' => $array[count($array)-1]
		];
	}
	function ordenamiento($range)
	{
		// sigo ordenando mientras exista algun flag como false porque sigue entrando en el id y la comparaciòn >
		while ($this->valida($this->flag) == 0) {
			$this->flag = [];

			for ($i=0; $i < count($range) - 1; $i++) { 
				
				if ($range[$i] > $range[$i+1])
				{
					// se cambia de posición
					$a = $range[$i];
					$b = $range[$i+1];

					$range[$i] = $b;
					$range[$i+1] = $a;
					
					$this->flag[] = 'false';
				} else {
					$this->flag[] = 'true';
				}
			
			}
		}
		
		return $range;
	}
	function salida($array)
	{
		return "[".implode(', ', $array)."]";
	}
	function valida($array)
	{
		if (in_array('false', $array))
		{
			return 0;
		}
		return 1;
	}

}

// Esto determina el mayor y el menor y construye nuevamente el rango
$resultado = new CompleteRange;
echo "Resultado de build: <br>";
echo $resultado->build([1,2,4,5]);
echo "<br>";
echo $resultado->build([2,4,9]);
echo "<br>";
echo $resultado->build([55,58,60]);

// Esto detecta los que faltan y agrega lo nuevo y devuelve todo el nuevo rango
$resultado2 = new CompleteRange;
echo "<br><br> Resultado de build2: <br>";
echo $resultado2->build2([1,2,4,5]);
echo "<br>";
echo $resultado2->build2([2,4,9]);
echo "<br>";
echo $resultado2->build2([55,58,60]);

