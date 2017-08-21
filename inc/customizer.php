<?php
/**
 * unisco Theme Customizer
 *
 * @package unisco
 */


/**
 * Pro customizer section.
 *
 * @since  1.0.0
 * @access public
 */
if( class_exists( 'WP_Customize_Section' ) ) {
	class Unisco_Customize_Section_Pro extends WP_Customize_Section {
		/**
		 * The type of customize section being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'unisco-pro';
		/**
		 * Custom button text to output.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $pro_text = '';
		/**
		 * Custom pro button URL.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $pro_url = '';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function json() {
			$json             = parent::json();
			$json['pro_text'] = $this->pro_text;
			$json['pro_url']  = esc_url( $this->pro_url );

			return $json;
		}

		/**
		 * Outputs the Underscore.js template.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		protected function render_template() { ?>
            <li id="accordion-section-{{ data.id }}"
                class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}
                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-primary alignright" target="_blank">{{
                            data.pro_text }}</a>
                        <# } #>
                            <br>
                            <span class="customize-action">{{ data.description }}</span>
                </h3>
            </li>
		<?php }
	}
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function unisco_customize_register( $wp_customize ) {

	// Register custom section types.
	$wp_customize->register_section_type( 'Unisco_Customize_Section_Pro' );

	// Pro Section
    $pro_url = apply_filters( 'unisco_customizer_pro_url', true );
    if( $pro_url ) {
	    $wp_customize->add_section(
		    new Unisco_Customize_Section_Pro(
			    $wp_customize,
			    'unisco_pro',
			    array(
				    'title'       => __( 'Unisco Pro', 'unisco' ),
				    'priority'    => 1,
				    'pro_text'    => __( 'Go Pro', 'unisco' ),
				    'pro_url'     => 'https://snapthemes.io/products/unisco-education-wordpress-theme/?utm_source=unisco_lite_customizer',
				    'description' => __( 'Courses, Events & more', 'unisco' )
			    )
		    )
	    );
    }

//	$wp_customize->remove_control('display_header_text');

	/**
	 * Site Title with custom priority
	 */
	$wp_customize->add_control( 'blogname', array(
		'label'      => __( 'Site Title', 'unisco' ),
		'section'    => 'title_tagline',
		'priority' => 10,
	) );

	/**
	 * Display Site Title and Tag line with custom priority and label
	 */
	$wp_customize->add_control( 'display_header_text', array(
		'settings' => 'header_textcolor',
		'label'    => __( 'Display Site Title', 'unisco' ),
		'section'  => 'title_tagline',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

	/**
	 * Site Tagline with custom priority
	 */
	$wp_customize->add_control( 'blogdescription', array(
		'label'      => __( 'Tagline', 'unisco' ),
		'section'    => 'title_tagline',
		'priority' => 11,
	) );

	/**
	 * Display Site Title
	 */
	$wp_customize->add_setting( 'unisco_display_site_tagline',
		array(
			'default'           => true,
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_checkbox'
		)
	);
	$wp_customize->add_control(
		'unisco_display_site_tagline', //Set a unique ID for the control
		array(
			'label'    => __( 'Display Site Tagline', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_display_site_tagline',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 11,
			//Determines the order this control appears in for the specified section
			'type'     => 'checkbox',
			'section'  => 'title_tagline',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	/**
	 * Header Background Color
	 */
	$wp_customize->add_setting( 'unisco_header_bgcolor',
		array(
			'default'           => '#292b2c',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_header_bgcolor', //Set a unique ID for the control
		array(
			'label'    => __( 'Header Background Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_header_bgcolor',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 9,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);


	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'unisco_accent_color',
		array(
			'default'           => '#cbb58b',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_accent_color_control', //Set a unique ID for the control
		array(
			'label'    => __( 'Accent Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_accent_color',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 10,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	/**
	 * Content Color
	 */
	$wp_customize->add_setting( 'unisco_content_color',
		array(
			'default'           => '#292b2c',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_content_color_control', //Set a unique ID for the control
		array(
			'label'    => __( 'Body Text Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_content_color',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 10,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	$wp_customize->add_setting( 'unisco_footer_text_color',
		array(
			'default'           => '#c4c4c4',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_footer_text_color_control', //Set a unique ID for the control
		array(
			'label'    => __( 'Footer Text Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_footer_text_color',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 10,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	$wp_customize->add_setting( 'unisco_footer_heading_color',
		array(
			'default'           => '#ffffff',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_footer_heading_color_control', //Set a unique ID for the control
		array(
			'label'    => __( 'Footer Heading Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_footer_heading_color',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 10,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	$wp_customize->add_setting( 'unisco_footer_bg_color',
		array(
			'default'           => '#292b2c',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'unisco_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		'unisco_footer_bg_color_control', //Set a unique ID for the control
		array(
			'label'    => __( 'Footer Background Color', 'unisco' ),
			//Admin-visible name of the control
			'settings' => 'unisco_footer_bg_color',
			//Which setting to load and manipulate (serialized is okay)
			'priority' => 10,
			//Determines the order this control appears in for the specified section
			'type'     => 'color',
			'section'  => 'colors',
			//ID of the section this control should render in (can be one of yours, or a WordPress default section)
		)
	);

	$wp_customize->add_setting( 'unisco_mobile_logo',
		array(
			'default'           => '', // get_template_directory_uri() . '/images/responsive-logo.png'
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'unisco_mobile_logo',
			array(
				'label'    => __( 'Mobile Logo', 'unisco' ),
				'section'  => 'title_tagline',
				'description' => __( 'This logo will appear on small screens.', 'unisco' ),
				'settings' => 'unisco_mobile_logo',
				'priority' => 9
			)
		)
	);

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Lite Section
	$wp_customize->add_panel(
		'unisco-options',
		array(
			'title'       => __( 'Unisco Lite', 'unisco' ),
			'capability'     => 'edit_theme_options',
		)
	);

	// Front Slider Section
	include( get_template_directory() . '/customizer/sections/slider.php' );
}
add_action( 'customize_register', 'unisco_customize_register' );


function unisco_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function unisco_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
//	var_dump($hex_color);
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

// Custom CSS output based on Customizer
function unisco_css_output() { ?>
	<style type="text/css" id="unisco-customizer-css">
		<?php
		$header_image = unisco_header_image();
		if( !empty( $header_image ) ) : ?>
        .custom-header {
            background-image: url(<?php echo esc_html($header_image); ?>);
            background-color: <?php echo esc_html(get_theme_mod( 'unisco_header_bgcolor', '#292b2c' )); ?>
        }
        <?php endif;
		$accent_color = get_theme_mod( 'unisco_accent_color', '#cbb58b' ); ?>
		/*accent color styles*/
		a, .navbar-light .navbar-nav .nav-link:hover, .navbar-light .navbar-nav .nav-link:focus, .site-footer a:hover, .site-footer .widget a:hover, .btn-submit:hover, .accordian-link:active, .accordian-link:hover, .accordian-link:focus, .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover, .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .event-toggle, .event-toggle:focus, .blogpost-tab-description h6, .blog-tiltle_block a, .research-posts .research-news_block span, .admission-form_listed li, .admission_insruction p span, .admission-pdf p span a, .course_duration ul li p, .social-icons ul li a:hover i, .our-teachers-block .teachers-description p span, .testi-img_block p span, .quote i, .tweet a:hover, .tweet i, .sitemap ul li :hover, .btn-about, .blogtitle p, .site-footer a:hover, .site-footer .widget a:hover, .icon-menu, .btn-default, .dropdown-item:hover, .nav-toggle_icon, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover, .navbar-light .navbar-nav .active > .nav-link, .navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .nav-link.open, .navbar-light .navbar-nav .open > .nav-link {
			color: <?php echo esc_html( $accent_color ); ?>;
		}
		.btn-default:hover, div.panel, button.accordion.active, button.accordion:hover, .btn-default, .navbar-light .navbar-toggler, .dropdown .dropdown-menu, .btn-about, .quote i, .blogpost_list, .nav-tabs .nav-link:focus {
			border-color: <?php echo esc_html( $accent_color ); ?>;
		}
		.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
			border-bottom-color: <?php echo esc_html( $accent_color ); ?>;
		}
		.btn-default:hover, .contact-form, .btn-warning.active, .btn-warning:active, .show > .btn-warning.dropdown-toggle, .event-date, .page-next, .research-featurestext_block, .admission_rating, .course_filter, .btn-black.active, .btn-black:active, .show > .btn-warning.dropdown-toggle, .btn-default:hover, .btn:focus, .dropdown-item.active, .dropdown-item:active, .carousel-indicators .active, .event-img_date, .date-description h3:after, input[type='submit'] {
			background-color: <?php echo esc_html( $accent_color ); ?>;
		}
		.btn-warning:hover, input[type='submit']:hover {
			background-color: <?php echo esc_html( unisco_darken_color( $accent_color, 1.2 ) ); ?>;
		}
		@media (min-width: 992px) {
			.quote .quote_text:before, .quote .quote_text:after {
				color: <?php echo esc_html( $accent_color ); ?>;
			}
		}
		/*body content color styles*/
		.blog-single-item .entry-title a, .btn-simple, .card-block, .accordian-link, div.panel p, .tabcontent p, .tab-list, .page-link:focus, .page-link:hover, .page-numbers:focus, .page-numbers:hover, .page-link, .page-numbers, .blog-category_block ul li a, .research-current_block p, .admission_share-icon a, .course_box:hover, .course_box:focus, .course_box:active, .course_box, .testimonial h2, .welcome_about p, .welcome_about h2, .our_courses .courses_box a, .about p, .about h2, a:hover, .dropdown-item, .widget ul li a, .entry-content h6 a, .single .entry-content h1, .single .comment h1, .page .entry-content h1, .page .comment h1, .blog-featured-img_block a, .home_blog_link, body {
            color: <?php echo esc_html( get_theme_mod( 'unisco_content_color', '#292b2c' ) ); ?>;
        }
		 /*footer text color styles*/
		.site-footer .address p, .sitemap ul li a, .tweet, .foot-logo p, .site-footer a, .site-footer .widget a, footer.site-footer, .site-footer ul li a {
			color: <?php echo esc_html( get_theme_mod( 'unisco_footer_text_color', '#c4c4c4' ) ); ?>;
		}
		/*footer heading color styles*/
        .site-footer .widget-title {
            color: <?php echo esc_html( get_theme_mod( 'unisco_footer_heading_color', '#ffffff' ) ); ?>;
        }
        /*footer background color styles*/
        .blog-date, footer.site-footer {
            background-color: <?php echo esc_html( get_theme_mod( 'unisco_footer_bg_color', '#292b2c' ) ); ?>;
        }
	</style>
<?php
}
add_action( 'wp_head', 'unisco_css_output');

// Register scripts and styles for the controls.
function unisco_enqueue_control_scripts(){
	wp_enqueue_script( 'unisco-customize-controls', get_template_directory_uri() . '/js/customize-controls.js', array( 'customize-controls' ) );
	wp_enqueue_style( 'unisco-customize-controls', get_template_directory_uri() . '/css/customize-controls.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'unisco_enqueue_control_scripts', 0 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function unisco_customize_preview_js() {
	wp_enqueue_script( 'unisco-customizer', get_template_directory_uri() . '/js/customizer.js', array(
		'jquery',
		'customize-preview'
	), '20170613', true );
}

add_action( 'customize_preview_init', 'unisco_customize_preview_js' );
