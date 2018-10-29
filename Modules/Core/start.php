<?php

// load helpers
foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
    require_once($filename);
}
