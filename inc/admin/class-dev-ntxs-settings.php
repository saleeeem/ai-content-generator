<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * dev_ntx_settings class to manage plugin options on admin side.
 */
class dev_ntx_settings {

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
		add_action( 'admin_menu', array( $this, 'dev_ntx_settings_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'dev_ntx_settings_action_links' ) );
	}


	/**
	 * Add/Create the `dev-ntx-options` options admin-page
	 *
	 * @return void
	 */
	public function dev_ntx_settings_page() {
		// This page will be under "Settings".
		add_options_page(
			__( 'Plugin Settings', 'textdomain' ),
			__( 'Plugin Settings', 'textdomain' ),
			'manage_options',
			'dev-nts-settings',
			array( $this, 'dev_ntx_settings_page_content' )
		);
	}



	/**
	 * Callback function to add content to `WP ChatGPT` options admin-page.
	 *
	 * @return void
	 */
	public function dev_ntx_settings_page_content() {
		// Set class property.
		$this->options = get_option( 'dev_ntx_settings_options' );
		
	 ?>
		<div class="wrap devnetix-settings">
			<div class="dev-ntx-top-header">
			<h4><?php esc_html_e( 'Setting Options', 'textdomain' ); ?></h4>
		</div>

		<form method="post" action="options.php">
			<section class="dev-ntx-main">
				<header class="dev-ntx-header">
					<a href="#" class="dev-ntx-brand"> <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/images/logo.svg' ?>" alt=""> </a>
					<ul class="dev-ntx-menu">
						<li class="active"> <a href="#"> <i><img src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/images/menu-icon-setting.svg' ?>" alt=""></i> Setting</a> </li>
						<li > <a href="#"><i> <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/images/menu-icon-condition.svg' ?>" alt=""> </i>General Options</a> </li>
					</ul>
				</header>

				<div class="dev-ntx-content">
					<div class="dev-ntx-title">
						<i> <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/images/menu-icon-setting.svg' ?>" alt=""> </i>
						<h1>Setting <small>Select basic setting like close button type and CSS position of the bar.</small> </h1>
					</div>
						
					<div class="dev-ntx-form-container">
						<?php settings_fields( 'wp_chatgpt_fields_group' ); ?>
							<div class="dev-ntx-row">
								<div class="dev-ntx-field">
									<label>Api Key</label>
									<?php $this->cb_api_key() ; ?>
								</div>
							</div>
							<div class="dev-ntx-row">
								<div class="dev-ntx-field">
									<label>Temprature</label>
									<?php $this->cb_temprature() ; ?>
								</div>
								<div class="dev-ntx-field">
									<label>Max Words To Show</label>
									<?php $this->cb_max_length() ; ?>
								</div>
							</div>
							<div class="dev-ntx-row">
								<div class="dev-ntx-field">
									<label>Select Model</label>
									<?php $this->cb_model() ; ?>
								</div>
							</div>	 		
							<?php submit_button(); ?>
					</div> 
				</div>
    		</section>	
		</form>
	<?php
	}


	/**
	 * Register setting, Add section and the Option Fields on `admin_init` hook
	 *
	 * @return void
	 */
	public function page_init() {
		register_setting(
			'wp_chatgpt_fields_group', // Option group.
			'dev_ntx_settings_options', // Option name.
			array( $this, 'validate' ) // Callback to validate.
		);

		add_settings_section(
			'wp_chatgpt_setings_section', // Section ID.
			'', // Section Title.
			'', // Callback.
			'dev-nts-settings' //  Page Slug.
		);

		add_settings_field(
			'api-key', // Option Field ID.
			__( 'API Key', 'textdomain' ), // Option Field Title.
			array( $this, 'cb_api_key' ), // Callback.
			'dev-nts-settings', //  Page Slug.
			'wp_chatgpt_setings_section' //  Section ID.
		);
		add_settings_field(
			'temprature', // Option Field ID.
			__( 'Temprature', 'textdomain' ), // Option Field Title.
			array( $this, 'cb_temprature' ), // Callback.
			'dev-nts-settings', //  Page Slug.
			'wp_chatgpt_setings_section' //  Section ID.
		);
		add_settings_field(
			'max_length', // Option Field ID.
			__( 'Maximum length', 'textdomain' ), // Option Field Title.
			array( $this, 'cb_max_length' ), // Callback.
			'dev-nts-settings', //  Page Slug.
			'wp_chatgpt_setings_section' //  Section ID.
		);
		add_settings_field(
            'mode_value', // Option Field ID.
            '', // // Option Field Title.
            array( $this, 'cb_model' ), // callback
            'dev-nts-settings', // Page Slug.
            'wp_chatgpt_setings_section' // Section ID.
        );
		

	}


	/**
	 * Sanitize/Validate each setting field as needed.
	 *
	 * @param array $fields Contains all `WP ChatGPT` fields as array.
	 *
	 * @return array Valid fields.
	 */
	public function validate( $fields ) {
		$valid_fields = array();

		if ( isset( $fields['api-key'] ) ) {
			$valid_fields['api-key'] = sanitize_text_field( $fields['api-key'] );
		}
		if ( isset( $fields['temprature'] ) ) {
			$valid_fields['temprature'] = sanitize_text_field( $fields['temprature'] );
		}
		if ( isset( $fields['max_length'] ) ) {
			$valid_fields['max_length'] = sanitize_text_field( $fields['max_length'] );
		}
		if ( isset( $fields['mode_value'] ) ) {
			$valid_fields['mode_value'] = $fields['mode_value'];
        }

		return apply_filters( 'validate_options', $valid_fields, $fields );

	}


	/**
	 * Get the settings options array and print one of its values
	 *
	 * @return void
	 */
	public function cb_api_key() {
		printf(
			'<input type="text" id="api-key" name="dev_ntx_settings_options[api-key]" value="%s" />',
			isset( $this->options['api-key'] ) ? esc_attr( $this->options['api-key'] ) : '',
		
		);
	}

	public function cb_temprature() {
		printf(
			'<input type="float"  id="temprature" name="dev_ntx_settings_options[temprature]" value="%s" />',
			isset( $this->options['temprature'] ) ? esc_attr( $this->options['temprature'] ) : ''
		);
	}
	public function cb_max_length() {

		printf(
			'<input type="number" max="2400" id="max_length" name="dev_ntx_settings_options[max_length]" value="%s" />',
			isset( $this->options['max_length'] ) ? esc_attr( $this->options['max_length'] ) : ''
		);
							
	}

	public function cb_model() {
        ?>
			<select name="dev_ntx_settings_options[mode_value]" id="mode_value">
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'text-davinci-003') ? 'selected' : '' ; ?>
			<option value="text-davinci-003" <?php echo $selected; ?>>text-davinci-003</option>
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'text-curie-001') ? 'selected' : '' ; ?>
			<option value="text-curie-001" <?php echo $selected; ?>>text-curie-001</option>
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'text-babbage-001') ? 'selected' : '' ; ?>
			<option value="text-babbage-001" <?php echo $selected; ?>>text-babbage-001</option>
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'text-ada-001') ? 'selected' : '' ; ?>
			<option value="text-ada-001" <?php echo $selected; ?>>text-ada-001</option>
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'code-davinci-002') ? 'selected' : '' ; ?>
			<option value="code-davinci-002" <?php echo $selected; ?>>code-davinci-002</option>
			<?php $selected = (isset( $this->options['mode_value'] ) && $this->options['mode_value'] === 'code-cushman-001') ? 'selected' : '' ; ?>
			<option value="code-cushman-001" <?php echo $selected; ?>>code-cushman-001</option>
			</select> 
		 <?php
    }

	/**
	 * Merging the Settings link in the plugin links, on installed plugins page.
	 *
	 * @param array $links Array of links.
	 *
	 * @return array Array of links.
	 */
	public function dev_ntx_settings_action_links( $links ) {
		$action_links[] = '<a href="' . admin_url( 'options-general.php?page=dev-nts-settings' ) . '">' . esc_html__( 'Settings', 'breakingnews' ) . '</a>';
		return array_merge( $action_links, $links );
	}

}

if ( is_admin() ) {
	new dev_ntx_settings();
}