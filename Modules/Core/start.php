<?php

// load helpers
foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
    require_once($filename);
}

// load directives
foreach (glob(__DIR__ . '/Resources/views/directives/*.php') as $filename) {
    require_once($filename);
}
