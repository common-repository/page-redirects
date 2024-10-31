<?php
/**
 * Plugin Name:       Page Redirects
 * Plugin URI:        https://wpxss.com/
 * Description:       Set a custom redirect URL for posts, pages and WooCommerce products. Current redirects can be viewed, deleted or searched from an admin page.
 * Version:           1.2
 * Author:            plugins.club
 * Author URI:        https://pejcic.rs
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 5.0
 * Tested up to: 	  6.1.1
*/

// Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Include the Settings Page
require_once plugin_dir_path( __FILE__ ) . 'includes/settings-page.php';

// Add redirect URL field to post/page/product edit screen
function pluginsclub_redirect_url_meta_box() {
    add_meta_box(
        'pluginsclub_redirect_url',
        'Redirect URL',
        'pluginsclub_redirect_url_meta_box_callback',
        'post',
        'side',
        'default'
    );
    add_meta_box(
        'pluginsclub_redirect_url',
        'Redirect URL',
        'pluginsclub_redirect_url_meta_box_callback',
        'page',
        'side',
        'default'
    );
    add_meta_box(
        'pluginsclub_redirect_url',
        'Redirect URL',
        'pluginsclub_redirect_url_meta_box_callback',
        'product',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'pluginsclub_redirect_url_meta_box' );

function pluginsclub_redirect_url_meta_box_callback( $post ) {
    wp_nonce_field( 'pluginsclub_redirect_url_meta_box', 'pluginsclub_redirect_url_meta_box_nonce' );
    $value = get_post_meta( $post->ID, 'pluginsclub_redirect_url', true );
    echo '<label for="pluginsclub_redirect_url">Enter a URL to redirect to:</label>';
    echo '<input type="text" id="pluginsclub_redirect_url" name="pluginsclub_redirect_url" value="' . esc_attr( $value ) . '" size="25" />';
}

// Save the redirect URL when the post/page/product is saved
function pluginsclub_redirect_url_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['pluginsclub_redirect_url_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['pluginsclub_redirect_url_meta_box_nonce'], 'pluginsclub_redirect_url_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['pluginsclub_redirect_url'] ) || empty( $_POST['pluginsclub_redirect_url'] ) ) {
        delete_post_meta( $post_id, 'pluginsclub_redirect_url' );
        return;
    }
    $pluginsclub_redirect_url = sanitize_text_field( $_POST['pluginsclub_redirect_url'] );
update_post_meta( $post_id, 'pluginsclub_redirect_url', $pluginsclub_redirect_url );
}
add_action( 'save_post', 'pluginsclub_redirect_url_save_meta_box_data' );

// Redirect to the custom URL if one is set
function pluginsclub_redirect_url() {
if ( is_singular( array( 'post', 'page', 'product' ) ) ) {
global $post;
$pluginsclub_redirect_url = get_post_meta( $post->ID, 'pluginsclub_redirect_url', true );
if ( $pluginsclub_redirect_url ) {
wp_redirect( $pluginsclub_redirect_url );
exit;
}
}
}
add_action( 'template_redirect', 'pluginsclub_redirect_url' );

// Add the admin page to view all current redirects
function pluginsclub_redirect_url_admin_page() {
add_submenu_page(
'options-general.php',
'Redirects',
'Redirects',
'manage_options',
'pluginsclub_redirect_url',
'pluginsclub_redirect_url_admin_page_callback'
);
}
add_action( 'admin_menu', 'pluginsclub_redirect_url_admin_page' );
