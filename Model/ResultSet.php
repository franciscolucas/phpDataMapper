<?php
/**
 * $Id$
 * 
 * Collection of phpDataMapper_Result objects
 * 
 * @package phpDataMapper
 * @author Vance Lucas <vance@vancelucas.com>
 * @link http://phpdatamapper.com
 * 
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 */
class phpDataMapper_Model_ResultSet implements Iterator, Countable, ArrayAccess
{
	protected $results = array();
	protected $resultsIdentities = array();
	
	
	/**
	 * Constructor function
	 *
	 * @param array $results Array of pre-loaded DataMapper_Result objects
	 * @param array $resultsIdentities Array of key values for given result set primary key
	 */
	public function __construct(array $results, array $resultsIdentities = array())
	{
		$this->results = $results;
		$this->resultsIdentities = $resultsIdentities;
	}
	
	
	/**
	 * Returns first result in set
	 */
	public function first()
	{
		if(isset($this->results[0])) {
			return $this->results[0];
		} else {
			return false;
		}
	}
	
	
	/**
	 * ResultSet to array using given key/value columns
	 */
	public function toArray($keyColumn, $valueColumn)
	{
		$return = array();
		foreach($this->results as $row) {
			$return[$row->$keyColumn] = $row->$valueColumn;
		}
		return $return;
	}
	
	
	/**
	 * Returns results array
	 */
	public function getResults()
	{
		return $this->results;
	}
	
	
	// SPL - Countable functions
	// ----------------------------------------------
	/**
	 * Get a count of all the records in the result set
	 */
	public function count()
	{
		return count($this->results);
	}
	// ----------------------------------------------
	
	
	// SPL - Iterator functions
	// ----------------------------------------------
	public function current()
	{
		return current($this->results);
	}

	public function key()
	{
		return key($this->results);
	}

	public function next()
	{
		next($this->results);
	}

	public function rewind()
	{
		reset($this->results);
	}

	public function valid()
	{
		return (current($this->results) !== FALSE);
	}
	// ----------------------------------------------
	
	
	// SPL - ArrayAccess functions
	// ----------------------------------------------
	public function offsetExists($key) {
		return isset($this->results[$key]);
	}
	
	public function offsetGet($key) {
		return $this->results[$key];
	}
	
	public function offsetSet($key, $value) {
		if($key === null) {
			return $this->results[] = $value;
		} else {
			return $this->results[$key] = $value;
		}
	}
	
	public function offsetUnset($key) {
		if(is_int($key)) {
	        array_splice($this->results, $key, 1);
	    } else {
	        unset($this->results[$key]);
	    }
	}
	// ----------------------------------------------
}