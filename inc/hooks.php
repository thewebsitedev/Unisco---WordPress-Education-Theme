<?php
/**
 * Unisco hook stub list.
 *
 * @package      unisco
 * @version      1.0
 * @since        1.0
 * @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */

/**
 * HTML <html> hook
 * Special case, useful for <DOCTYPE>, etc.
 * $unisco_supports[] = 'html;
 */
 function unisco_html_before() {
	 do_action( 'unisco_html_before' );
 }
/**
 * HTML <body> hooks
 * $unisco_supports[] = 'body';
 */
 function unisco_body_top() {
	 do_action( 'unisco_body_top' );
	 do_action( 'body_open' );
	 do_action( 'before' );
 }

 function unisco_body_bottom() {
	 do_action( 'unisco_body_bottom' );
 }

/**
 * HTML <head> hooks
 *
 * $unisco_supports[] = 'head';
 */
function unisco_head_top() {
	do_action( 'unisco_head_top' );
}

function unisco_head_bottom() {
	do_action( 'unisco_head_bottom' );
}

/**
 * Semantic <header> hooks
 *
 * $unisco_supports[] = 'header';
 */
function unisco_header_before() {
	do_action( 'unisco_header_before' );
}

function unisco_header_after() {
	do_action( 'unisco_header_after' );
}

function unisco_header_top() {
	do_action( 'unisco_header_top' );
}

function unisco_header_bottom() {
	do_action( 'unisco_header_bottom' );
}

/**
 * Semantic <content> hooks
 *
 * $unisco_supports[] = 'content';
 */
function unisco_content_before() {
	do_action( 'unisco_content_before' );
}

function unisco_content_after() {
	do_action( 'unisco_content_after' );
}

function unisco_content_top() {
	do_action( 'unisco_content_top' );
}

function unisco_content_bottom() {
	do_action( 'unisco_content_bottom' );
}

/**
 * Semantic <entry> hooks
 *
 * $unisco_supports[] = 'entry';
 */
function unisco_entry_before() {
	do_action( 'unisco_entry_before' );
}

function unisco_entry_after() {
	do_action( 'unisco_entry_after' );
}

function unisco_entry_top() {
	do_action( 'unisco_entry_top' );
}

function unisco_entry_title() {
	do_action( 'unisco_entry_title' );
}

function unisco_entry_bottom() {
	do_action( 'unisco_entry_bottom' );
}

/**
 * Comments block hooks
 *
 * $unisco_supports[] = 'comments';
 */
function unisco_comments_before() {
	do_action( 'unisco_comments_before' );
}

function unisco_comments_after() {
	do_action( 'unisco_comments_after' );
}

/**
 * Semantic <sidebar> hooks
 *
 * $unisco_supports[] = 'sidebar';
 */
function unisco_sidebars_before() {
	do_action( 'unisco_sidebars_before' );
}

function unisco_sidebars_after() {
	do_action( 'unisco_sidebars_after' );
}

function unisco_sidebar_top() {
	do_action( 'unisco_sidebar_top' );
}

function unisco_sidebar_bottom() {
	do_action( 'unisco_sidebar_bottom' );
}

/**
 * Semantic <footer> hooks
 *
 * $unisco_supports[] = 'footer';
 */
function unisco_footer_before() {
	do_action( 'unisco_footer_before' );
}

function unisco_footer_after() {
	do_action( 'unisco_footer_after' );
}

function unisco_footer_top() {
	do_action( 'unisco_footer_top' );
}

function unisco_footer_bottom() {
	do_action( 'unisco_footer_bottom' );
}