<?php
/**
 * Plugin Name: Typewheel Notice Demo
 * Plugin URI: https://typewheel.xyz/typewheel-notice
 * Description: This plugin is a demo of a simple way to trigger dismissable admin notices from your plugin or theme.
 * Author: Joshua Vandercar
 * Version: 1.0
 * Author URI: https://vandercar.net
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

// Step 1: Add the `typewheel-notice/` folder in root directory
// Step 2: Include the following code in your root file
// Step 3: Search & replace all instances of `your_prefix_` in your root file. (prefix should be unique to the project)
// Step 4: In the `register_deactivation_hook`, replace `typewheel-notice-demo.php` with the name of your root file.
// Step 5: Customize your notices

/* All of the following arguments can be customized in a notice array
*
*	$prefix . '-unique-notice-id'	=> array()			// this array id will be used to track dismissals and should be unique (do not modify $prefix)
*				'trigger' 		=> {true|false}					// this flags whether or not the notice should be shown
*				'time'			=> time() +/- {int}				// when should the notice be made active? replace {int} with number of seconds before/after activation
*				'dismiss'		=> array({week,month})			// whether to include an option to dismiss for one week or one month
*				'type'			=> {success|error|warning|info}	// (optional) whether to include WP notice styling
*				'icon'			=> {dashicon-slug}				// (optional) prepends a dashicon to the notice
*				'content'		=> ''							// (required) string with content of notice
*				'style'			=> array() or ''				// (optional) array of CSS parameters/values
*				'location'		=> array()						// (required) array of pages on which to show the notice
*				'capability'	=> ''							// (optional) to whom should the notice be shown? defaults to `read`.
*
*/

require_once( 'typewheel-notice/class-typewheel-notice.php' );

if ( ! function_exists( 'your_prefix_typewheel_notices' ) && apply_filters( 'show_typewheel_notices', true ) ) {

	add_action( 'admin_notices', 'your_prefix_typewheel_notices' );
	/**
	 * Display notices
	 *
	 * @since    1.0
	 */
	function your_prefix_typewheel_notices() {

		$prefix = str_replace( '-', '_', dirname( plugin_basename(__FILE__) ) );

		// Notice to show on plugin activation
		$activation_notice = array(
			'icon'       => 'admin-plugins',
			'content'    => '<strong>Typewheel Notice Demo</strong> is now active. Head on over to <a href="/wp-admin/index.php" style="text-decoration:none;"><i class="dashicons dashicons-dashboard"></i> your dashboard</a> to see it in action.',
			'style'      => array( 'border-left-color' => '#3F3F3F', 'background-image' => 'linear-gradient( to bottom right, rgb(215, 215, 215), rgb(231, 211, 186) )' ),
			'capability' => 'activate_plugins',
		);

		// Define the notices
		$typewheel_notices = array(
			$prefix . '-support' => array(
				'trigger' => true,
				'time' => time() - 5,
				'dismiss' => array( 'month' ),
				'type' => '',
				'icon' => 'paperclip',
				'content' => 'This notice (scheduled for five seconds before plugin activation) is visible only on the dashboard. Another will be visible on the <a href="tools.php">Tools</a> and <a href="users.php">Users</a> page one minute after plugin activation.',
				'style' => array( 'border-left-color' => '#3F3F3F', 'background-image' => 'linear-gradient( to bottom right, rgb(215, 215, 215), rgb(231, 211, 186) )' ),
				'location' => array( 'index.php' ),
				'capability' => 'update_plugins',
			),
			$prefix . '-give' => array(
				'trigger' => true,
				'time' => time() + 60,
				'dismiss' => array( 'week' ),
				'type' => '',
				'icon' => '',
				'content' => 'So, what do you think? Questions or concerns? <a href="https://github.com/uamv/typewheel-notice-demo/" style="text-decoration:none;"><i class="dashicons dashicons-format-chat"></i> Connect on GitHub</a>. If you like this tool, please consider <a href="https://twitter.com/intent/tweet/?url=https%3A%2F%2Fgithub.com%2Fuamv%2Ftypewheel-notice-demo%2F&via=uamv" target="_blank"><i class="dashicons dashicons-twitter"></i> tweeting your support</a> or giving a <a href="https://typewheel.xyz/give/?ref=Typewheel%20Notice%20Demo" target="_blank"><i class="dashicons dashicons-heart"></i> small donation</a> to encourage further development. Thanks! <a href="https://twitter.com/uamv/">@uamv</a>',
				'style' => array( 'border-left-color' => '#3F3F3F', 'background-image' => 'linear-gradient( to bottom right, rgb(215, 215, 215), rgb(231, 211, 186) )' ),
				'location' => array( 'tools.php', 'users.php' ),
				'capability' => 'update_plugins',
			),
		);

		// get the notice class
		$notices = new Typewheel_Notice( $prefix, $typewheel_notices, $activation_notice );

	} // end display_plugin_notices
}

/**
 * Deletes activation marker so it can be displayed when the plugin is reinstalled or reactivated
 *
 * @since    1.0
 */
if ( ! function_exists( 'your_prefix_remove_activation_marker' ) ) {

	function your_prefix_remove_activation_marker() {

		$prefix = str_replace( '-', '_', dirname( plugin_basename(__FILE__) ) );

		delete_option( $prefix . '_activated' );

	}
	register_deactivation_hook( dirname(__FILE__) . '/typewheel-notice-demo.php', 'your_prefix_remove_activation_marker' );

}
