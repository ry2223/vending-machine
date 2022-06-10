<?php

use VendingMachine\Exception\InvalidInputException;

$options = [
	'AVAILABLE ' => 'OPTIONS',
	'Symbols: ' => 'N, D, Q, DOLLAR',
	'Actions: ' => 'GET-A, GET-B, GET-C, RETURN-MONEY',
];

foreach($options as $key => $option) {
	echo $key . $option . PHP_EOL;
}

while(true) {
	try {
		// $input = $inputHandler->getInput();
		
		// 1. Pobieranie znaków z klawiatury (odesłanie do danej klasy
			// i przetworzenie z niej danych)
		// 2. Stworzenie produktów po uruchomieniu programu
		// 3. Ustawienie salda początkowego na $0
		// 4. Ustalenie stałych cen produktów
		// 5. Ustawienie stałych wartości monet



	}
	catch(InvalidInputException $e) {
		echo "Invalid input, try again...\n";
	}
}