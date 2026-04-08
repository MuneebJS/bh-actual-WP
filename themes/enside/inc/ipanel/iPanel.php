<?php

    /*
     *    === Define the Path ===
    */
    defined('ENSIDE_IPANEL_PATH') ||
        define( 'ENSIDE_IPANEL_PATH' , get_template_directory() . '/ipanel/' );

    /*
     *    === Define the Version of iPanel ===
    */
    define( 'IPANEL_VERSION' , '1.1' );



    /*
     *    === Define the Classes Path ===
    */
    if ( defined('ENSIDE_IPANEL_PATH') ) {
        define( 'IPANEL_CLASSES_PATH' , ENSIDE_IPANEL_PATH . 'classes/' );
    } else {
        define( 'IPANEL_CLASSES_PATH' , get_template_directory() . '/ipanel/classes/' );
    }

    function enside_iPanelLoad(){
        require_once IPANEL_CLASSES_PATH . 'ipanel.class.php';
		if( file_exists(ENSIDE_IPANEL_PATH . 'options.php') )
			require_once ENSIDE_IPANEL_PATH . 'options.php';
    }

    if ( defined('ENSIDE_IPANEL_PLUGIN_USAGE') ) {
        if ( ENSIDE_IPANEL_PLUGIN_USAGE === true ) {
            add_action('plugins_loaded', 'enside_iPanelLoad');
        } else {
            add_action('init', 'enside_iPanelLoad');
        }
    } else {
        add_action('init', 'enside_iPanelLoad');
    }
