<?php

namespace Tintonic;

use Exception;

/* -----------------------------------------------------------
| Simple PHP class for enhanced logging to custom file.
|---------------------------------------------------------- */
class Elog {
    public static $ALL_DISABLED = false;
    public static $INSTANCES = [];

    public $file_path;
    public $enabled = true;
    public $default_include_type = false;
    public $name;

    /* -----------------------------------------------------------
    | Create instance with path to log file.
    | Log file will be created if missing.
    |---------------------------------------------------------- */
    function __construct ($directory_path = __DIR__, $file_name = 'elog.log', $directory_parent_levels = 0)
    {
        if ($directory_parent_levels) {
            $directory_path = dirname($directory_path, $directory_parent_levels);
        }

        $this->file_path = $directory_path . '/' . $file_name;

        /* -----------------------------------------------------------
        | Register instance for access from helper method.
        |---------------------------------------------------------- */
        self::$INSTANCES[] = $this;
    }

    /* -----------------------------------------------------------
    | Log data.
    |---------------------------------------------------------- */
    public function log (String|Bool|Array|Object $data, String $label = null, Bool $include_type = null)
    {
        /* -----------------------------------------------------------
        | Bail out if globally or locally disabled.
        |---------------------------------------------------------- */
        if (self::$ALL_DISABLED || !$this->enabled) {
            return;
        }

        /* -----------------------------------------------------------
        | Stringify data.
        |---------------------------------------------------------- */
        $data_out = '';
        if($data === null) {
            $data_out = '[null]';
        } else if($data === '') {
            $data_out = '[empty string]';
        } else if(is_bool($data)) {
            $data_out = $data ? '[true]' : '[false]';
        } else if(is_array($data) || is_object($data)) {
            $data_out = print_r($data, true);
        } else {
            $data_out = $data;
        }

        $label_out = $label ? "--- $label: ---\n" : '';

        /* -----------------------------------------------------------
        | Set default value for $include_type.
        |---------------------------------------------------------- */
        if ($include_type === null) {
            $include_type = $this->default_include_type;
        }

        $type_out = $include_type ? '{ ' . gettype($data) . ' } ' . "\n" : '';

        $out = $label_out . $type_out . $data_out;
        
        /* -----------------------------------------------------------
        | Log message.
        |---------------------------------------------------------- */
        try {
            error_log($out . "\n", 3, $this->file_path);
        } catch (Exception $exception) {
            throw new ElogException("Error logging to file.");
        }
    }

    /* -----------------------------------------------------------
    | Enable logging on this instance.
    |---------------------------------------------------------- */
    public function enable ()
    {
        $this->enabled = true;
    }

    /* -----------------------------------------------------------
    | Disable logging on this instance.
    |---------------------------------------------------------- */
    public function disable ()
    {
        $this->enabled = false;
    }

    /* -----------------------------------------------------------
    | Set a default value for $include_type that will be used
    | when null is passed to log().
    |---------------------------------------------------------- */
    public function set_default_include_type (Bool $default_include_type)
    {
        $this->default_include_type = $default_include_type;
    }

    /* -----------------------------------------------------------
    | Set a name for this instance that can be used to log
    | to specific instance by name.
    |---------------------------------------------------------- */
    public function set_name (String $name)
    {
        $this->name = $name;
    }

    /* -----------------------------------------------------------
    | Get instance by name.
    |---------------------------------------------------------- */
    public static function getNamedInstance ($name)
    {
        if (!$name || !is_string($name)) {
            throw new ElogException("No valid name provided.");
        }

        $matching_instances = array_values(array_filter(self::$INSTANCES, function (Elog $elog_instance) use ($name) {
            return $elog_instance->name == $name;
        }));

        if (!count($matching_instances)) {
            throw new ElogException("Found no Elog instance named \"$name\".");
        }

        return $matching_instances[0];
    }

    public static function getInstanceAt (Int $index = 0)
    {
        $count = count(self::$INSTANCES);

        if ($count <= $index - 1) {
            throw new ElogException("No instance found at index \"$index\" – only \"$count\" instances.");
        }

        return self::$INSTANCES[$index];
    }
}

class ElogException extends Exception {}
