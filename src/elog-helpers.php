<?php

use Tintonic\Elog;

if (function_exists('elog')) {
    exit;
}

/* -----------------------------------------------------------
| Helper function for easer access to logging with Elog.
| Default usage logs to the first Elog instance that
| was created.
|---------------------------------------------------------- */
function elog (String|Bool|Array|Object $data, String $label = null, Bool $include_type = null)
{
    Elog::getInstanceAt(0)->log($data, $label, $include_type);
}

/* -----------------------------------------------------------
| Helpers to log to named Elog instance.
|---------------------------------------------------------- */
function elogn (String $name, String|Bool|Array|Object $data, String $label = null, Bool $include_type = null)
{
    Elog::getNamedInstance($name)->log($data, $label, $include_type);
}

function elognamed (String $name, String|Bool|Array|Object $data, String $label = null, Bool $include_type = null)
{
    elogn($name, $data, $label, $include_type);
}

/* -----------------------------------------------------------
| Helper to log to Elog instance at specific index.
|---------------------------------------------------------- */
function elogat (Int $index, String|Bool|Array|Object $data, String $label = null, Bool $include_type = null)
{
    Elog::getInstanceAt($index)->log($data, $label, $include_type);
}
