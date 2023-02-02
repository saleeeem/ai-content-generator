<?php

/**
 * // If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class that holds all ajax callbacks.
 */
class devnetix_callback {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_myaction', array( $this, 'chatbot_request_callback' ) ); 
		add_action( 'wp_ajax_nopriv_myaction', array( $this, 'chatbot_request_callback' ) );
	}

	//  Making request to OpenAI API to request the prompt

	public function chatbot_request_callback() {

		$chatgpt_options = get_option( 'dev_ntx_settings_options' );
	
		if( !empty( $chatgpt_options['api-key'] ) ) {
		$chatgpt_api_key = "Bearer " . $chatgpt_options['api-key'];
		$chatgpt_model = $chatgpt_options['mode_value'];
		$chatgpt_temprature = $chatgpt_options['temprature'];
		$chatgpt_max_length = $chatgpt_options['max_length'];
		}else {
		$chatgpt_api_key = "Bearer ";
		$chatgpt_model =  "text-davinci-003";
		$chatgpt_temprature = 0.7;
		$chatgpt_max_length = 256;
		}
	
		$prompt = $_POST['request'];
	
		if($prompt === ''){
		$string = 'Please type something...';
		echo json_encode($string);
		die;
		}
		if($chatgpt_api_key === "Bearer "){
		$string = 'Your API Key is not valid...';
		echo json_encode($string);
		die;
		}
		$url = "https://api.openai.com/v1/completions";
		$headers = array(
		"Content-Type" => "application/json",
		"Authorization" => $chatgpt_api_key
		);
		$body = array(
		"model" => $chatgpt_model,
		"prompt" => $prompt,
		"temperature" => (int)$chatgpt_temprature,
		"max_tokens" => (int)$chatgpt_max_length,
		"top_p" => 1,
		"frequency_penalty" => 0,
		"presence_penalty" => 0
		);
		$response = wp_remote_post( $url, array(
		'method'      => 'POST',
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers'     => $headers,
		'body'        => json_encode($body),
		'cookies'     => array()
			)
		);
	
		
		if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		echo "Something went wrong: $error_message";
		} else {
		$responseBody = json_decode(wp_remote_retrieve_body( $response )); 
		echo json_encode($responseBody->choices[0]->text);    
		die;
	
		}
	}

}

if ( is_admin() ) {
	new devnetix_callback();
}