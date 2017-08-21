<?php
/**
 * Displays slider in header
 *
 * @package WordPress
 * @subpackage unisco
 * @since 1.0
 * @version 1.0
 */

?>
<div id="unisco-slider" class="slider_img">
    <div id="carousel" class="carousel slide" data-ride="carousel">
		<?php
		// slides
		$slides = json_decode( get_theme_mod( 'unisco_slides' ) );
		if( empty( $slides ) ){
		    $slides = json_decode( json_encode( array(
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
		    ) ) );
        }
		?>
        <ol class="carousel-indicators">
            <?php
            foreach( $slides as $key => $slide ) { ?>
                <li data-target="#carousel" data-slide-to="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key === 0 ? 'active' : '' ); ?>"></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner" role="listbox">
	        <?php
	        foreach( $slides as $key => $slide ) { ?>
                <div class="carousel-item<?php echo esc_attr( $key === 0 ? ' active' : '' ); ?>">
                    <img class="d-block" src="<?php echo esc_url( $slide->background_image ); ?>"
                         alt="<?php echo esc_attr( $slide->title ); ?>">
                    <div class="carousel-caption d-md-block">
                        <div class="slider_title">
                            <h1><?php echo esc_html( $slide->title ); ?></h1>
                            <h4><?php echo wp_kses_post( $slide->description ); ?></h4>
					        <?php if ( $slide->button_1_text || $slide->button_2_text ): ?>
                                <div class="slider-btn">
							        <?php if ( $slide->button_1_url ): ?>
                                        <a href="<?php echo esc_url( $slide->button_1_url ); ?>"
                                           class="btn btn-default"><?php echo esc_html( $slide->button_1_text ); ?></a>
							        <?php endif; ?>
							        <?php if ( $slide->button_2_url ): ?>
                                        <a href="<?php echo esc_url( $slide->button_2_url ); ?>"
                                           class="btn btn-default"><?php echo esc_html( $slide->button_2_text ); ?></a>
							        <?php endif; ?>
                                </div>
					        <?php endif; ?>
                        </div>
                    </div>
                </div>
	        <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <i class="icon-arrow-left fa-slider" aria-hidden="true"></i>
            <span class="sr-only"><?php esc_html_e( 'Previous', 'unisco' ); ?></span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <i class="icon-arrow-right fa-slider" aria-hidden="true"></i>
            <span class="sr-only"><?php esc_html_e( 'Next', 'unisco' ); ?></span>
        </a>
    </div>
</div>