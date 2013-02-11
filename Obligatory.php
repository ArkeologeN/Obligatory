<?php
/**
 * Created as Obligatory.php.
 * Developer: Hamza Waqas
 * Date:      2/2/13
 * Time:      12:35 PM
 */


/**
 *  Works like a value object to handle all necessary mandatory request params for REST
 */
namespace Logilim;

class Obligatory {

    /**
     * @var array Magic Data Storage
     */
    private $_params = array();

    private $_collection = array();

    static function newFactoryInstance() {
        return new Obligatory();
    }

    public function __set($param, $is_required = true) {
        $this->_params[$param] = $is_required;
    }

    public function __get($param) {
        return array_key_exists($param,$this->_params) ? $this->_params[$param] : null;
    }

    public function setCollection($collection = array()) {
        $this->_collection = array_merge($this->_collection, $collection);
    }

    public function validate() {

        $filtered = array_filter(array_keys($this->_params), function($k) {
            if ( $this->_params[$k] == 1)
                return true;

            return false;
        });
        $diffs = array_diff($filtered, array_keys($this->_collection));
        $missing_params = [];
        if ( !empty ($diffs)) {
            foreach ($diffs as $diff) {
                $missing_params[] = $diff;
            }

            throw new \Exception("Missing Parameter(s): ".implode(',', $missing_params));
        }
    }


}