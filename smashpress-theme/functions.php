<?php

/**
 *  Enable optimisation only for the frontend
 */
if (!is_admin()){
    require_once( STYLESHEETPATH . '/src/config.php');
    require_once( STYLESHEETPATH . '/src/speedup.php');
}