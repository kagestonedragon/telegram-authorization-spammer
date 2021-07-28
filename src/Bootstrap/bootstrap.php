<?php

$root = dirname(__DIR__, 2);

/**
 * Composer autoloader
 */
require_once($root . '/vendor/autoload.php');

/**
 * Env
 */
require_once($root . '/src/Bootstrap/env.php');

/**
 * Di
 */
require_once($root . '/src/Bootstrap/di.php');

/**
 * Functions
 */
require_once($root . '/src/Bootstrap/functions.php');