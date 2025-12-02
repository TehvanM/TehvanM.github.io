<?php
	try {
		// sinu andmed
		$db_server = 'localhost';
		$db_andmebaas = 'tmarjapuu';
		$db_kasutaja = 'tmarjapuu';
		$db_salasona = '9C3l+oxF6vuFhsRl';

		// ühendus
		$yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
	} catch (mysqli_sql_exception $e) {
		die('Probleem andmebaasiga: ' . $e->getMessage());
	}
?>