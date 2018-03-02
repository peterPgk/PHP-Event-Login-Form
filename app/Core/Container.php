<?php

//change this to something like Pimple

namespace Pgk\Core;

use \ArrayIterator;


/**
 * Provides function for iterates over collections
 * Usually this implements some interface like \ArrayAccess ...
 *
 * Class Container
 * @package Pgk\Core
 */
class Container {
	/**
	 * The source data
	 *
	 * @var array
	 */
	protected $_data = [];

	/**
	 * Create new collection
	 *
	 * @param array $items Populate collection
	 */
	public function __construct(array $items = [])
	{
		foreach ($items as $key => $value) {
			$this->set($key, $value);
		}
	}

	/**
	 * Set collection item
	 *
	 * @param string $key   The data key
	 * @param mixed  $value The data value
	 */
	public function set($key, $value)
	{
		$this->_data[$key] = $value;
	}

	/**
	 * Get collection item for key
	 *
	 * @param string $key
	 * @param mixed  $default The default value to return if data key does not exist
	 *
	 * @return mixed The key's value, or the default value
	 */
	public function get($key, $default = null)
	{
		return $this->has($key) ? $this->_data[$key] : $default;
	}

	public function getOffset(  ) {

	}

	/**
	 * Add items to this collection
	 *
	 * @param array $items
	 */
	public function replace(array $items)
	{
		foreach ($items as $key => $value) {
			$this->set($key, $value);
		}
	}

	/**
	 * Get all items in collection
	 *
	 * @return array The collection's source data
	 */
	public function all()
	{
		return $this->_data;
	}

	/**
	 * Get collection keys
	 *
	 * @return array The collection's source data keys
	 */
	public function keys()
	{
		return array_keys($this->_data);
	}

	/**
	 * Does this collection have a given key?
	 *
	 * @param string $key The data key
	 *
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->_data);
	}

	/**
	 * Remove item from collection
	 *
	 * @param string $key The data key
	 */
	public function remove($key)
	{
		unset($this->_data[$key]);
	}

	/**
	 * Remove all items from collection
	 */
	public function clear()
	{
		$this->_data = [];
	}

	/**
	 * Does this collection have a given key?
	 *
	 * @param  string $key The data key
	 *
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}

	/**
	 * Get collection item for key
	 *
	 * @param string $key The data key
	 *
	 * @return mixed The key's value, or the default value
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/**
	 * Set collection item
	 *
	 * @param string $key   The data key
	 * @param mixed  $value The data value
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Remove item from collection
	 *
	 * @param string $key The data key
	 */
	public function offsetUnset($key)
	{
		$this->remove($key);
	}

	/**
	 * Get number of items in collection
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->_data);
	}


	/**
	 * Get collection iterator
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->_data);
	}

}