<?php

// Custom Controls
require_once get_template_directory() . '/customizer/controls/unisco_slide_repeater.php';

function unisco_slides_sanitize($input){
	$input_decoded = json_decode($input,true);

	if(!empty($input_decoded)) {
		foreach ($input_decoded as $input_key => $input_value ){
			foreach ($input_value as $key => $value){
				$input_decoded[$input_key][$key] = wp_kses_post( force_balance_tags( $value ) );
			}
		}
		return json_encode($input_decoded);
	}
	return $input;
}

function unisco_front_slider_enabled(){
	$front_slider = get_theme_mod( 'unisco_slider_front');
	if( $front_slider === 'yes' ) {
		return true;
	}
	return false;
}

/**
 * Customizer global header options
 */

$wp_customize->add_section( 'unisco_slider',
	array(
		'title'       => __( 'Front Slider', 'unisco' ),
		//Visible title of section
		'priority'    => 120,
		//Determines what order this appears in
		'capability'  => 'edit_theme_options',
		//Capability needed to tweak
		'description' => __( 'Allows you to customize the slider on the front page. This slider will appear only when the front page is set to latest posts.', 'unisco' ),
		//Descriptive tooltip
	)
);

$wp_customize->add_setting( 'unisco_slider_front', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
	array(
		'default'           => 'no',
		//Default setting/value to save
		'type'              => 'theme_mod',
		//Is this an 'option' or a 'theme_mod'?
		'capability'        => 'edit_theme_options',
		//Optional. Special permissions for accessing this setting.
		'transport'         => 'refresh',
		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		'sanitize_callback' => 'sanitize_text_field'
	)
);
$wp_customize->add_control(
	'unisco_slider_front', //Set a unique ID for the control
	array(
		'label'    => __( 'Enable Front Slider', 'unisco' ),
		//Admin-visible name of the control
		'settings' => 'unisco_slider_front',
		//Which setting to load and manipulate (serialized is okay)
		'priority' => 10,
		//Determines the order this control appears in for the specified section
		'type'     => 'radio',
		'section'  => 'unisco_slider',
		//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		'choices' => array(
			'no' => __('No','unisco'),
			'yes' => __('Yes', 'unisco')
		)
	)
);

$wp_customize->add_setting('unisco_slides', array(
	'default'           => json_encode( array(
		array(
			'title' => 'Creative Thinking & Innovation',
			'description' => 'Proactively utilize open-source users for process-centric total linkage.<br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.',
			'background_image' => get_template_directory_uri() . '/images/slider.jpg',
			'button_1_text' => 'See programs',
			'button_1_url' => '#',
			'button_2_text' => 'Learn More',
			'button_2_url' => '#',
		),
		array(
			'title' => 'We foster wisdom',
			'description' => 'Proactively utilize open-source users for process-centric total linkage.<br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.',
			'background_image' => get_template_directory_uri() . '/images/slider-2.jpg',
			'button_1_text' => 'See programs',
			'button_1_url' => '#',
			'button_2_text' => 'Learn More',
			'button_2_url' => '#',
		),
		array(
			'title' => 'Campus life @ Unisco',
			'description' => 'Proactively utilize open-source users for process-centric total linkage.<br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.',
			'background_image' => get_template_directory_uri() . '/images/slider-3.jpg',
			'button_1_text' => 'Campus life',
			'button_1_url' => '#',
			'button_2_text' => '',
			'button_2_url' => '',
		),
	) ),
	'transport'         => 'refresh',
	'sanitize_callback' => 'unisco_slides_sanitize',
));
$wp_customize->add_control(new Unisco_Slide_Repeater_Control($wp_customize, 'unisco_slides', array(
	'label'    		=> esc_html__('Slides', 'unisco'),
	'description' 	=> esc_html__('Add more and more and more...', 'unisco'),
	'settings'		=> 'unisco_slides',
	'section'  		=> 'unisco_slider',
	'active_callback' => 'unisco_front_slider_enabled',
)));