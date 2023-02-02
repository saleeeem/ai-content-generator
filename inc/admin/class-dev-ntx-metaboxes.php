<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Register Metabox for posts.
 */
class devnetix_Admin_Options {

	/**
	 * Holds the values to be used in the fields callbacks
	 *
	 * @var array
	 */
	private $options;


	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'devnetix_add_custom_box') );
	}

	/**
	 * Register metaboxes for options .
	 */
	public function devnetix_add_custom_box() {
		$screens = [ 'post' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'devnetix_box_id',                 // Unique ID
				__( 'Plugin Options', 'textdomain' ),      // Box title
				array( $this, 'devnetix_add_meta_box_html' ),  // Content callback, must be of type callable
				$screen                            // Post type
			);
		}
	}
	/**
	 * Callback for metabox to add fields.
	 */
	public function devnetix_add_meta_box_html(){
		?>
		  <section class="dev-ntx-main dev-ntx-metaboxs">
		  	<span class="dev-ntx-loader"></span>
			<div class="dev-ntx-content">
				<div class="dev-ntx-form-container">
					<div class="dev-ntx-row">
					<div class="dev-ntx-field">
						<label>Add Your Title</label>
						<input id="dev-ntx-title" type="text" placeholder="Title" name="" value="">
					</div>
					<div class="dev-ntx-field " >
						<label>Add your keywords comma seperated.</label>
						<div id="dev-ntx-tags" class="dev-ntx-tag">
						<input type="text" placeholder="Keywords" name="" value=""></div>
					</div>
					</div>
					<div class="dev-ntx-row">
					<div class="dev-ntx-field dev-ntx-textarea">
						<label>Content</label>
						<textarea id="dev-ntx-res-container" class="dev-ntx-ct-area" name="dev-ntx-area" rows="10" readonly>
						</textarea>
					</div>
					</div>
					<button class="dev-ntx-btn" id="dev-ntx-btn" type="button" name="button">Generate Content</button>
				</div>
				
			</div>
			</section>
		<?php
	}


}

if ( is_admin() ) {
	new devnetix_Admin_Options();
}