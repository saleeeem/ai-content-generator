<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Enqueue Admin and front-end scripts.
 */
class devnetix_enqueue_scripts {

	/**
	 * Constructor.
	 */
	public function __construct() {
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
    
    }

    /**
     * Admin Scripts Enqueue.
     */
    public function enqueue_admin_scripts() {
		wp_enqueue_style( 'wp-chatbot-styles', plugin_dir_url( __FILE__ ) . '../../assets/css/style.css', array(), '', 'all' );
		wp_enqueue_script( 'wp-chatbot-scripts-admin', plugin_dir_url( __FILE__ ) . '../../assets/js/scripts.js', array('jquery'), '', true );
		wp_localize_script('wp-chatbot-scripts-admin', 'chatbot', array(
		  'ajaxurl' => admin_url( 'admin-ajax.php' ),
		  'botImg' =>  plugin_dir_url( __FILE__ ) . 'assets/imgs/bot.svg',
		  'userImg' =>  plugin_dir_url( __FILE__ ) . 'assets/imgs/user.svg',
	  ));
      
	  } 
		
	
}

if ( is_admin() ) {
	new devnetix_enqueue_scripts();
}