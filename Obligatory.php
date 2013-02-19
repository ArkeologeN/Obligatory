<?php
/**
 * @author      Hamza Waqas
 * @since       19-02-2013
 * @link        http://www.github.com/ArkeologeN/Obligatory
 */


/**
 *  Works like a value object to handle all necessary mandatory request params for REST
 */
namespace Logilim;

class Obligatory {

    /**
     * @var array Magic Data Storage
     */
    private static $_params = array();

    /**
     * @var array Holds all the Request Data from which it has to be validated
     */
    private $_collection = array();

    /**
     * Get New Fresh Factory Instance of Obligatory. Grab lot of instances at once.
     * @return Obligatory
     */
    static function newFactoryInstance() {
        return new Obligatory();
    }

    /**
     *  Set the Param name that needs to be validated and pass it's status either mandatory or not
     * @param $param The name of the param
     * @param bool $is_required TRUE / FALSE
     */
    public function __set($param, $is_required = true) {
        self::$_params[$param] = $is_required;
    }

    /**
     *  Returns the status being set of any param or null
     * @param $param
     * @return null | boolean
     */
    public function __get($param) {
        return array_key_exists($param,self::$_params) ? self::$_params[$param] : null;
    }

    /**
     * Sets Request data to be validated
     * @param array $collection The HTTP Request data from which it has to be validated
     */
    public function setCollection($collection = array()) {
        $this->_collection = array_merge($this->_collection, $collection);
    }

    /**
     *  Check either your params are perfectly matched with HTTP Request Data
     * @throws \Exception
     */
    public function validate() {
        $self_params = (self::$_params);
        $filtered = array_filter(array_keys(self::$_params), function($k) use ($self_params) {
            if ( $self_params[$k] == 1)
                return true;

            return false;
        });
        $diffs = array_diff($filtered, array_keys($this->_collection));
        $missing_params = array();
        if ( !empty ($diffs)) {
            foreach ($diffs as $diff) {
                $missing_params[] = $diff;
            }

            throw new \Exception("Missing Parameter(s): ".implode(',', $missing_params));
        }
    }


}