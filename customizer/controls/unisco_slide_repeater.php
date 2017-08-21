<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

class Unisco_Slide_Repeater_Control extends WP_Customize_Control {
	/**
	 * Render the control's content.
	 * Allows the content to be overridden without having to rewrite the wrapper.
	 * @return  void
	 */
	public function render_content() {
		?>
        <script>
            var entityMap = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                '\'': '&#39;',
                '/': '&#x2F;'
            };
            function uniscoEscapeHtml(string) {
                'use strict';
                //noinspection JSUnresolvedFunction
                string = String(string).replace(new RegExp('\r?\n', 'g'), '<br />');
                string = String(string).replace(/\\/g, '&#92;');
                return String(string).replace(/[&<>"'\/]/g, function (s) {
                    return entityMap[s];
                });
            }
            function uniscoMediaUpload(button_class) {
                'use strict';
                // Add media
                jQuery('body').on('click', button_class, function (e) {
                    e.preventDefault();
                    var button_id = jQuery(this);
                    var input_field = jQuery(this).parent().parent().children('input.unisco_slide_background_image');
                    var display_field = jQuery(this).parent().parent().find('img.unisco_slide_background_image');
                    var placeholder = jQuery(this).parent().parent().children('.placeholder');
                    var thumbnail = jQuery(this).parent().parent().children('.thumbnail');
                    var buttons = jQuery(this).parent().parent().children('.actions-no-image');
                    var imgButtons = jQuery(this).parent().parent().children('.actions-image-selected');
                    var _custom_media = true;

                    wp.media.editor.send.attachment = function (props, attachment) {
                        if (_custom_media) {
                            if (typeof display_field !== 'undefined') {
                                switch (props.size) {
                                    default:
                                        display_field.attr('src',attachment.url);
                                        input_field.val(attachment.url);
                                        input_field.trigger('change');
                                        placeholder.addClass('hidden');
                                        buttons.addClass('hidden');
                                        thumbnail.removeClass('hidden');
                                        imgButtons.removeClass('hidden');

                                        uniscoUpdateSliderValues();
                                }
                            }
                            _custom_media = false;
                        } else {
                            return wp.media.editor.send.attachment(button_id, [props, attachment]);
                        }
                    };
                    wp.media.editor.open(button_class);
                    // window.send_to_editor = function (html) {};
                    return false;
                });
                // Default media
                jQuery('body').on('click', '.unisco_media_default_button', function (e) {
                    e.preventDefault();

                    var input_field = jQuery(this).parent().parent().children('input.unisco_slide_background_image');
                    var display_field = jQuery(this).parent().parent().find('img.unisco_slide_background_image');
                    var placeholder = jQuery(this).parent().parent().children('.placeholder');
                    var thumbnail = jQuery(this).parent().parent().children('.thumbnail');
                    var buttons = jQuery(this).parent().parent().children('.actions-no-image');
                    var imgButtons = jQuery(this).parent().parent().children('.actions-image-selected');

                    display_field.attr('src',jQuery(this).data('url'));
                    input_field.val(jQuery(this).data('url'));
                    input_field.trigger('change');
                    placeholder.addClass('hidden');
                    buttons.addClass('hidden');
                    thumbnail.removeClass('hidden');
                    imgButtons.removeClass('hidden');

                    uniscoUpdateSliderValues();

                    return false;
                });
                // Remove media
                jQuery('body').on('click', '.unisco_media_remove_button', function (e) {
                    e.preventDefault();

                    var input_field = jQuery(this).parent().parent().children('input.unisco_slide_background_image');
                    var display_field = jQuery(this).parent().parent().find('img.unisco_slide_background_image');
                    var placeholder = jQuery(this).parent().parent().children('.placeholder');
                    var thumbnail = jQuery(this).parent().parent().children('.thumbnail');
                    var buttons = jQuery(this).parent().parent().children('.actions-no-image');
                    var imgButtons = jQuery(this).parent().parent().children('.actions-image-selected');

                    display_field.attr('src','');
                    input_field.val('');
                    input_field.trigger('change');
                    placeholder.removeClass('hidden');
                    buttons.removeClass('hidden');
                    thumbnail.addClass('hidden');
                    imgButtons.addClass('hidden');

                    uniscoUpdateSliderValues();

                    return false;

                });
            }
            function uniscoUpdateSliderValues() {
                var values = [];
                var slideOptions = jQuery('.unisco_slide_options');
                slideOptions.each( function() {
                    var slideTitle = jQuery(this).find('.unisco_slide_title').val();
                    var slideDescription = jQuery(this).find('.unisco_slide_description').val();
                    var slideImage = jQuery(this).find('.unisco_slide_background_image').val();
                    var slideButton1Text = jQuery(this).find('.unisco_slide_button_1_text').val();
                    var slideButton1Url = jQuery(this).find('.unisco_slide_button_1_url').val();
                    var slideButton2Text = jQuery(this).find('.unisco_slide_button_2_text').val();
                    var slideButton2Url = jQuery(this).find('.unisco_slide_button_2_url').val();
                    values.push({
                        'title': uniscoEscapeHtml( slideTitle ),
                        'description': slideDescription,
                        'background_image': encodeURI( slideImage ),
                        'button_1_text': uniscoEscapeHtml( slideButton1Text ),
                        'button_1_url': encodeURI( slideButton1Url ),
                        'button_2_text': uniscoEscapeHtml( slideButton2Text ),
                        'button_2_url': encodeURI( slideButton2Url ),
                    });
                });
                jQuery('#<?php echo esc_attr( $this->id ); ?>').val( JSON.stringify(values) ).trigger('change');
            }
            (function ($) {
                $(document).ready(function () {
                    uniscoMediaUpload('.unisco_media_upload_button');
                    $('.unisco_slide_title,.unisco_slide_description,.unisco_slide_button_1_text,.unisco_slide_button_1_url,.unisco_slide_button_2_text,.unisco_slide_button_2_url').on('keyup', function(){
                        uniscoUpdateSliderValues();
                    });
                    $('#unisco_add_slide').on('click', function(e){
                        e.preventDefault();
                        var count = $('.unisco_slides_control').find('.unisco_slide_options').length;
                        var slide = $(this).prev('.unisco_slide_options').clone();
                        slide.find('.unisco_slide_count').text(count+1);
                        slide.find('.unisco_remove_slide').removeClass('hidden');
                        $(this).before(slide);
                        uniscoUpdateSliderValues();
                    });
                    $(document).on('click', '.unisco_remove_slide', function(e){
                        e.preventDefault();
                        $(this).parent().parent().remove();
                        uniscoUpdateSliderValues();
                    });
                    $(document).on('click', '.unisco_slide_label', function(e){
                        var $this = $(this);
                        $this.find('.dashicons').toggleClass('dashicons-arrow-up').toggleClass('dashicons-arrow-down');
                        $this.next('.unisco_slide_options_wrap').slideToggle('fast', function(){
                            $this.toggleClass('unisco_slide_fold');
                        });
                    });
                    $('.unisco_slides_control').sortable({
                        update: function () {
                            uniscoUpdateSliderValues();
                        }
                    });
                });
            })(jQuery);
        </script>
        <style>
            .unisco_slide_options {
                border: 1px solid #d8d8d8;
                padding: 10px 10px 0;
                margin: 0 0 10px;
            }
            .unisco_slide_options_wrap {
                margin-top: 10px;
            }
            .unisco_slide_label {
                color: #8f959a;
                margin-top: 0;
                margin-bottom: 0;
                border-bottom: 1px solid #d8d8d8;
                padding-bottom: 10px;
                cursor: pointer;
            }
            .unisco_slide_fold {
                border-bottom: 0;
                padding-bottom: 10px;
            }
            .unisco_remove_slide {
                margin-bottom: 10px!important;
            }
        </style>
		<div class="unisco_slider_repeater">
            <input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_html( $this->link() ); ?>>
            <label for="">
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            </label>
            <div class="unisco_slides_control">
                <?php
                $defaults = json_decode( $this->setting->default );
//                var_dump($defaults);
                $value = json_decode( $this->value() );
                if( is_array( $value ) ) {
	                foreach ( $value as $key => $slide ) {
	                    $default_slide = $defaults[$key];
		                $key = $key + 1;
		                ?>
                        <div class="unisco_slide_options">
                            <h3 class="unisco_slide_label">
				                <?php echo esc_html( 'Slide', 'unisco' ); ?>
                                <span class="unisco_slide_count"><?php echo esc_html( $key ); ?></span>
                                <span class="dashicons dashicons-arrow-up" style="float:right;"></span>
                            </h3>
                            <div class="unisco_slide_options_wrap">
                                <label class="customize-control customize-control-text">
                                    <span class="customize-control-title"><?php echo esc_html( 'Title', 'unisco' ); ?></span>
                                    <input type="text" class="unisco_slide_title"
                                           value="<?php echo esc_attr( $slide->title ); ?>">
                                </label>
                                <label class="customize-control customize-control-textarea">
                                    <span class="customize-control-title"><?php echo esc_html( 'Description', 'unisco' ); ?></span>
                                    <textarea rows="5"
                                              class="unisco_slide_description"><?php echo esc_attr( $slide->description ); ?></textarea>
                                </label>
                                <label>
                                    <span class="customize-control-title"><?php echo esc_html( 'Background Image', 'unisco' ); ?></span>
                                </label>
                                <div class="customize-control customize-control-image attachment-media-view">
                                    <input type="hidden" class="unisco_slide_background_image"
                                           value="<?php echo esc_attr( isset( $slide->background_image ) ? $slide->background_image : '' ); ?>">

                                    <div class="placeholder<?php echo esc_attr( isset( $slide->background_image ) && ! empty( $slide->background_image ) ? ' hidden' : '' ); ?>">
                                        <?php esc_html_e( 'No image selected', 'unisco' ); ?>
                                    </div>
                                    <div class="actions actions-no-image<?php echo esc_attr( isset( $slide->background_image ) && ! empty( $slide->background_image ) ? ' hidden' : '' ); ?>">
                                        <button type="button"
                                                class="button unisco_media_default_button" data-url="<?php echo esc_attr( $default_slide->background_image ); ?>"><?php esc_html_e( 'Default', 'unisco' ); ?></button>
                                        <button type="button"
                                                class="button unisco_media_upload_button"><?php esc_html_e( 'Select Image', 'unisco' ); ?></button>
                                    </div>

                                    <div class="thumbnail thumbnail-image<?php echo esc_attr( ! isset( $slide->background_image ) || isset( $slide->background_image ) && empty( $slide->background_image ) ? ' hidden' : '' ); ?>">
                                        <img class="attachment-thumb unisco_slide_background_image"
                                             src="<?php echo esc_attr( isset( $slide->background_image ) ? $slide->background_image : '' ); ?>"
                                             draggable="false" alt="">
                                    </div>
                                    <div class="actions actions-image-selected<?php echo esc_attr( ! isset( $slide->background_image ) || isset( $slide->background_image ) && empty( $slide->background_image ) ? ' hidden' : '' ); ?>">
                                        <button type="button"
                                                class="button unisco_media_remove_button"><?php esc_html_e( 'Remove', 'unisco' ); ?></button>
                                        <button type="button"
                                                class="button unisco_media_upload_button"><?php esc_html_e( 'Change Image', 'unisco' ); ?></button>
                                    </div>
                                </div>
                                <label class="customize-control customize-control-text">
                                    <span class="customize-control-title"><?php echo esc_html( 'Button 1', 'unisco' ); ?></span>
                                    <input type="text" class="unisco_slide_button_1_text"
                                           placeholder="<?php echo esc_attr( 'Text', 'unisco' ); ?>"
                                           value="<?php echo esc_attr( isset( $slide->button_1_text ) ? $slide->button_1_text : '' ); ?>">
                                    <input type="url" class="unisco_slide_button_1_url"
                                           placeholder="<?php echo esc_attr( 'Url', 'unisco' ); ?>"
                                           value="<?php echo esc_attr( isset( $slide->button_1_url ) ? $slide->button_1_url : '' ); ?>">
                                </label>
                                <label class="customize-control customize-control-text">
                                    <span class="customize-control-title"><?php echo esc_html( 'Button 2', 'unisco' ); ?></span>
                                    <input type="text" class="unisco_slide_button_2_text"
                                           placeholder="<?php echo esc_attr( 'Text', 'unisco' ); ?>"
                                           value="<?php echo esc_attr( isset( $slide->button_2_text ) ? $slide->button_2_text : '' ); ?>">
                                    <input type="url" class="unisco_slide_button_2_url"
                                           placeholder="<?php echo esc_attr( 'Url', 'unisco' ); ?>"
                                           value="<?php echo esc_attr( isset( $slide->button_2_url ) ? $slide->button_2_url : '' ); ?>">
                                </label>
                                <button type="button"
                                        class="button unisco_remove_slide <?php echo esc_attr( $key == 1 ? 'hidden' : '' ); ?>"><?php echo esc_html( 'Remove', 'unisco' ); ?></button>
                            </div>
                            <div class="clear"></div>
                        </div>
		                <?php
	                }
                }
                ?>
                <button type="button" id="unisco_add_slide" class="button button-primary unisco_add_slide"><?php echo esc_html('Add Slide','unisco'); ?></button>
            </div>
        </div>

		<?php
	}

}