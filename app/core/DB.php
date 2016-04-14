<?php
namespace Pgk\Core;

use PDO;
use PDOException;

//Start building DB abstraction class, but ... time

/**
 * Class DB
 * @package Pgk\Core
 */
class DB
{
    private static $factory;
	/**
	 * @var PDO
	 */
    private $database,
            $_error = false,
			$_count,
			$_query,
			$_results,
			$_fetch = true;

	private $_operators = ['=', '>', '<', '>=', '<='];


    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = new DB();
        }
        return self::$factory;
    }

	public function __construct() {
		$this->getConnection();
	}

    public function getConnection() {
        if (!$this->database) {

            try {
                $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
                $this->database = new PDO(
                   Config::get('db.driver') . ':host=' . Config::get('db.host') . ';dbname=' .
                   Config::get('db.database') . ';port=' . Config::get('db.port') . ';charset=' . Config::get('db.charset'),
                   Config::get('db.username'), Config::get('db.password'), $options
                   );
            } catch (PDOException $e) {

                // Echo custom message. Echo error code gives you some info.
                echo 'Database connection can not be estabilished. Please try again later.' . '<br>';
                echo 'Error code: ' . $e->getCode();

                // Stop the application
                exit;
            }
        }
        return $this->database;
    }

	public function query( $sql, $params = [] ) {
		$this->_error = false;

		if( $this->_query = $this->database->prepare( $sql ) ) {
			$x = 1;
			if( count( $params ) ) {
				foreach ( $params as $param ) {
					$this->_query->bindValue( $x, $param );
					$x++;
				}
			}

			if( $this->_query->execute() ) {
				if ( $this->_fetch ) {
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				}
				$this->_count = $this->_query->rowCount();
			}
			else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action( $action, $table, $where = [ ] ) {
		if(count($where) === 3) {

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if(in_array($operator, $this->_operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}

		return false;
	}

	public function get( $table, $where ) {
		return $this->action('SELECT *', $table, $where);
	}

	public function results() {
		return $this->_results;
	}

	public function first() {
		return $this->results()[0];
	}

	public function insert( $table, $fields = [ ] ) {
		$this->_fetch = false;
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;

			//Improve this - get array count()
			foreach ( $fields as $field ) {
				$values .= '?';
				if( $x < count($fields) ) {
					$values .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO ". $table ." (`". implode('`, `', $keys) ."`) VALUES ({$values})";

			if(!$this->query($sql, $fields)->error()) {
				return true;
			}
		}

		return false;
	}

	public function update( $table, $id, $fields ) {
		$this->_fetch = false;
		$set = '';
		$x = 1;

		foreach ( $fields as $name => $field ) {
			$set .= "{$name} = ?";
			if( $x < count($fields) ) {
				$set .= ', ';
			}
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE user_id={$id}";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}

		return false;
	}

	public function delete( $table, $where ) {
		$this->_fetch = false;
		return $this->action('DELETE', $table, $where);
	}

	public function count() {
		return $this->_count;
	}

	public function error() {
		return $this->_error;
	}

	public function field_exists( $table, $field, $value ) {
		$this->get( $table, [$field, '=', $value ] );
		return $this->count() !== 0;
	}

}
