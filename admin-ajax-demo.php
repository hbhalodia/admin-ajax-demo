<?php
/**
 * Admin Ajax
 *
 * @package           admin-ajax
 * @author            Hit Bhalodia
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Ajax
 * Plugin URI:        https://github.com/hbhalodia/admin-ajax-demo
 * Description:       This is the Example plugin to show the admin-ajax demo.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Hit Bhalodia
 * Author URI:        https://hitbhalodia.wordpress.com/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       admin-ajax-demo
 */

/**
 * This function is used to add the submenu page inside the settings menu page.
 *
 * @return void
 */
function admin_ajax_settings_page() {

	global $admin_ajax;
	$admin_ajax = add_options_page(
		__( 'Admin Ajax Demo', 'admin-ajax-demo' ),
		__( 'Admin Ajax', 'admin-ajax-demo' ),
		'manage_options',
		__( 'admin_ajax', 'admin-ajax-demo' ),
		'admin_ajax_settings_html',
	);

}

add_action( 'admin_menu', 'admin_ajax_settings_page' );

/**
 * This function is used to create the UI part of the custom settings page of the admin-ajax-plugin.
 *
 * @return void
 */
function admin_ajax_settings_html() {

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form id="admin_ajax_form" action="" method="POST">
			<div>
				<?php

					submit_button( __( 'Get Posts', 'admin-ajax' ) );

				?>
			</div>
		</form>
		<div id="response">
		</div>
	</div>
	<?php

}

/**
 * Function is used to load the javascript file.
 *
 * @param string $hook - The page at which it loads.
 *
 * @return void
 */
function admin_ajax_load_scripts( $hook ) {

	global $admin_ajax;

	if ( $hook !== $admin_ajax ) {

		return;

	}

	wp_enqueue_script( 'admin-ajax-demo', plugin_dir_url( __FILE__ ) . 'js/admin-ajax-js.js', array( 'jquery' ), '1.0', true );
	wp_localize_script(
		'admin-ajax-demo',
		'admin_ajax_var',
		array(
			'ajax_action' => 'admin_ajax_action',
			'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'  => wp_create_nonce( 'admin-ajax-demo-nonce' ),
		)
	);
}

add_action( 'admin_enqueue_scripts', 'admin_ajax_load_scripts' );

/**
 * This function is used to get the results and return the response.
 *
 * @return void
 */
function admin_ajax_action_result() {

	if ( ! ( isset( $_POST['add_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['add_nonce'] ) ), 'admin-ajax-demo-nonce' ) ) ) {

		die( 'Permission denied!!!' );

	}

	$args_get_posts = array(
		'post_type'     => 'post',
		'post_status'   => 'publish',
		'post_per_page' => 5,
		'fields'        => 'ids',
	);

	$result = new WP_Query( $args_get_posts );
	$result = $result->posts;

	?>

	<ol>
	<?php
	foreach ( $result as $post_id ) {

		?>

		<h3><li><?php printf( '<a href="%s">%s</a>', esc_url( get_permalink( $post_id ) ), esc_html( get_the_title( $post_id ) ) ); ?></li><h3>

		<?php

	}

	?>
	</ol>

	<?php

	die();
}

add_action( 'wp_ajax_admin_ajax_action', 'admin_ajax_action_result' );
