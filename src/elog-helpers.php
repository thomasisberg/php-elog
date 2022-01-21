<?php

use Tintonic\PhpElog\Elog;

/* -----------------------------------------------------------
| Define Elog helpers if none of them already exists.
|---------------------------------------------------------- */
if (empty(array_filter(array_map('function_exists', [
    'create_elog',
    'elog',
    'elogn',
    'elognamed',
    'elogat'
]))))
{
    function create_elog(String $directory_path = null, String $name = 'elog', String $file_name = null, String $file_extension = 'log')
    {
        return new Elog($directory_path, $name, $file_name, $file_extension);
    }

    /* -----------------------------------------------------------
    | Helper function for easer access to logging with Elog.
    | Default usage logs to the first Elog instance that
    | was created.
    |---------------------------------------------------------- */
    function elog ($data, String $label = null, Bool $include_type = null)
    {
        Elog::get_instance_at(0)->log($data, $label, $include_type);
    }

    /* -----------------------------------------------------------
    | Helpers to log to named Elog instance.
    |---------------------------------------------------------- */
    function elogn (String $name, $data, String $label = null, Bool $include_type = null)
    {
        Elog::get_named_instance($name)->log($data, $label, $include_type);
    }

    function elognamed (String $name, $data, String $label = null, Bool $include_type = null)
    {
        elogn($name, $data, $label, $include_type);
    }

    /* -----------------------------------------------------------
    | Helper to log to Elog instance at specific index.
    |---------------------------------------------------------- */
    function elogat (Int $index, $data, String $label = null, Bool $include_type = null)
    {
        Elog::get_instance_at($index)->log($data, $label, $include_type);
    }
}
