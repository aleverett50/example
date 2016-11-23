<?php

namespace App\Helpers;

use PDO;

class Db
{

    public static function conn()
    {

    $connect = false;

		$options = array(

			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

		);



	try{

	$connect = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USERNAME, PASSWORD, $options);

	} catch(PDOException $e){

	print $e->getMessage();

	}

    return $connect;

    }

}
