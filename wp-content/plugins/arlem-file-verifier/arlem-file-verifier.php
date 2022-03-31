<?php
defined ( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: ARLEM File Verifier
 * Version: 0.0.1
 * Author: Katharine Beaumont
 * Description: Examine uploaded ARLEM zips and ensure they meet required standards
 */

foreach ( glob( plugin_dir_path( __FILE__ ).'inc/*.php' ) as $file )
    include $file;


?>