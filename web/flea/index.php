<?php

$safepath = preg_replace('/[^\/_a-zA-Z0-9\-]/', '', $_SERVER['PATH_INFO']);
$elems = split('/', $safepath);
// we do a mapping and search here to prevent instantiating something 
// passed in the URL. One never knows what ignorant or malicious users 
// might want us to instantiate. 

$controllers = array('search' => 'Search', 'tdata' => 'TableData',);
foreach ($controllers as $k => $v) {
    if ($k === $elems[1]) {
        $c = new $v;
        if (!is_subclass_of($c, 'Handler'))
            throw new Exception("$c is not a handler");
        $c->handle(array_slice($elems, 2));
        break;
    }
}