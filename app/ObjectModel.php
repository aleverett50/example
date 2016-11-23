<?php	

namespace App;

use App\Helpers\Db;
use App\Helpers\Validation;
use App\Helpers\Tools;
use PDO;

abstract class ObjectModel
{

    protected $table;
    protected $timestamps = true;
    protected $rules = array();
    protected $fillable = array();
    protected $unFillable = array();
    protected $dates = array();

    public function execute($query, array $array)
    {

	$query = Db::conn()->prepare($query);

	$query->execute($array);

	return $query->fetchAll(PDO::FETCH_OBJ);

    }


    public function executeAssoc($query, array $array)
    {

	$query = Db::conn()->prepare($query);

	$query->execute($array);

	return $query->fetchAll(PDO::FETCH_ASSOC);

    }


    public function find($id)
    {

	$query = Db::conn()->prepare('SELECT * FROM `' . $this->table . '` WHERE BINARY id = ?  ');

	$query->execute(array($id));

	return $query->fetch(PDO::FETCH_OBJ);

    }


    public function getRowByField($field, $string)
    {

	$query = Db::conn()->prepare(' SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` =  ? ');

	$query->execute(array($string));

	return $query->fetch(PDO::FETCH_OBJ);

    }
	
	
    public function getRowByFieldNotDeleted($field, $string)
    {

	$query = Db::conn()->prepare(' SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` =  ? AND deleted_at IS NULL ');

	$query->execute(array($string));

	return $query->fetch(PDO::FETCH_OBJ);

    }


    public function add()
    {

	$values = $this->getValues();

	/*  Add the row  */

	return $this->insertRow($this->table, $values);

    }


    public function update($where, $whereValues)
    {

	/*  First validate all form posts  */

	if (!$this->validate()) {

		return false;

	}

	/*  If validation is true, all posts where ok get all values of fillable form posts  */

	$values = $this->getValues();

	/*  Add the row  */

	return $this->updateRow($this->table, $values, $where, $whereValues);

    }


    public function validate()
    {

	foreach ($this->rules as $field => $rules){

		$rules = explode('|', $rules);

		foreach ($rules as $rule) {

			$rule = explode(':', $rule);

			$validate = isset($rule[1]) ? Validation::$rule[0]($field, $_POST[$field], $rule[1]) : Validation::$rule[0]($field, $_POST[$field]);

			if ($validate) {

				Tools::error($validate);

			}

		}

	}

	if (count(Validation::errors())) {

		return false;

	}

	return true;

    }


    public function getValues()
    {

	if (count($this->unFillable)) {

		/*  If we use Unfillable instead. This lists all table fields excluding the ones that don't need to be updated  */

		$this->fillable = $this->getTableColumns($this->table, $this->unFillable);

	}

	/*  Get all form post values to insert in to the row. Only get fillable fields set in the class.  */

	foreach ($this->fillable as $field) {

		if (isset($this->$field)) {

			$values[$field] = $this->$field;

		} else if (isset($_POST[$field])) {

			$values[$field] = $_POST[$field];

		}

	}

	return $values;

    }
	

    public function insertRow($table, $values)
    {

	/*  If $timestamps is not false in chid class add a timestamp  */

	if ($this->timestamps) {

		$values['created_at'] = DT;
		$values['updated_at'] = DT;

	}

	$values = Tools::formatFields($values, $this->dates);

	$query = 'INSERT INTO `' . $table . '` (';

	foreach ($values AS $key => $value) {
		$query .= '`' . $key . '`,';
	}

	$query = rtrim($query, ',') . ') VALUES (';

	foreach ($values AS $key => $value) {
		$query .= ' :' . $key . ',';
	}

	$query = rtrim($query, ',') . ' )';

	$query = Db::conn()->prepare($query);

	foreach ($values as $key => &$value) {

		$query->bindParam(':' . $key, $value);

	}

	$query->execute();

	Tools::deleteSessions();

	return Db::conn()->lastinsertid();

    }


    public function updateRow($table, $values, $where, $whereValues)
    {

	if ($this->timestamps) {

		$values['updated_at'] = DT;

	}

	$values = Tools::formatFields($values, $this->dates);

	$query = 'UPDATE `' . $table . '` SET ';

	foreach ($values as $key => $value) {

		$execute[$key] = $value;

		$query .= '`' . $key . '` = :' . $key . ', ';

	}

	foreach ($whereValues as $key => $value) {

		$execute[$key] = $value;

	}

	$query = rtrim($query, ', ');

	$query .= ' WHERE ' . $where;

	$query = Db::conn()->prepare($query);

	foreach ($execute as $key => &$value) {

		if ($value == '') {$value = null;}

		$query->bindParam(':' . $key, $value);

	}

	$query->execute();

	// debug_backtrace() finds what class or method the query came from

	if (debug_backtrace()[1]['function'] != 'updateCartWithMemberType' && debug_backtrace()[1]['function'] != 'updateCartWithNoMemberType') {

		Tools::deleteSessions();

	}

	return true;

    }


    public function getTableColumns($table, $exclude)
    {

	$exclude[] = 'id';
	$exclude[] = 'created_at';
	$exclude[] = 'updated_at';
	$exclude[] = 'deleted_at';

	$result = $this->execute('SHOW COLUMNS FROM `' . $table . '` ', array());

	foreach ($result as $row) {

		if (in_array($row->Field, $exclude)) {continue;}

		$fields[] = $row->Field;

	}

	return $fields;

    }


}
