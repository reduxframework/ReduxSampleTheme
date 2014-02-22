<?php
/*-----------------------------------------------------------------------------------*/
// THEME OPTIONS - Redux
// Include theme options panel
/*-----------------------------------------------------------------------------------*/


add_theme_support( 'menus' );


/**
	Used only for a demo site if you're using the URE plugin (http://wordpress.org/plugins/user-role-editor/)

	Create a role called SimpleOptions and only give it rights to read and manage_options.

	This bit of code will hide everything else.  ;)
**/
if (current_user_can('demo')) {
	function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
	}
	add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

	function stop_access_profile() {
    remove_menu_page( 'profile.php', 'options.php' );
    remove_submenu_page( 'users.php', 'profile.php', 'options-general.php' );
	}
	add_action( 'admin_init', 'stop_access_profile' );

	function remove_menus () {
    if(is_user_logged_in() && current_user_can('demo')) {
      global $menu;
      $restricted = array(__('Posts'), __('Profile'), __('Settings'), __('Media'), __('Contact'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
      end ($menu);
      while (prev($menu)) {
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) { unset($menu[key($menu)]); }
      }
    }
	}
	add_action('admin_menu', 'remove_menus');

	/**
	 * Add a widget to the dashboard.
	 *
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	function example_add_dashboard_widgets() {
		wp_add_dashboard_widget(
	                 'example_dashboard_widget',         // Widget slug.
	                 'Simple Options Framework Demo',         // Title.
	                 'example_dashboard_widget_function' // Display function.
	        );	
	}
	add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function example_dashboard_widget_function() {
		?>
		<h2>Welcome to the Simple Options Framework demo site.</h2>
		<h2>To begin, click on <a href="./admin.php?page=simple-options">Simple Options</a> to the left.</h2>
		<h2>When you've finished saving some options, <a href="<?php echo get_bloginfo('url'); ?>">go to the front page</a> to see the array of saved values.</h2>
		<h2 style="text-align: center;">Don't forget to donate if you like what you see.<br /><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3WQGEY4NSYE38" target="_blank"><img src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" alt="Donate to the framework" /></a></h2>
		<?php	
	} 
	

	

}

	function prepopulate_username_js() { ?>
    <script type="text/javascript">
    window.onload = function() {
    	document.getElementById('user_login').value = 'demo';
    	document.getElementById('user_pass').value = 'demo';
			document.getElementById("rememberme").checked=true;
			window.document.forms[0].submit();
    	//rememberme
    }
     
    </script>
    <?php
	}
	add_action('login_head', 'prepopulate_username_js');

	add_filter( 'login_redirect', create_function( '$url,$query,$user', 'return admin_url()."index.php";' ), 10, 3 );	




update_option( 'ReduxFrameworkPlugin', array( 'demo' => true ) );	



/**

	REDUX SAMPLE STUFF 
	
	Here's a really basic theme to demonstrait how to use Redux.

	Inside the function.php file and other non-template based files, you can access your opt_name variable directly
	provided it is not inside a function. If it is inside a function, you will need to do a `global $opt_name` within
	each function.

**/


/**
	Include the TGM_Plugin_Activation class.
**/
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
function redux_sample_register_required_plugins() {
	$plugin = array(
		'name' 			=> 'Redux Framework',
		'slug' 			=> 'redux-framework',
		'required' 		=> true,
	);
	$config = array(
		'has_notices'     	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'nag_type'			=> 'error' // Determines admin notice type - can only be 'updated' or 'error'
	);
	tgmpa( array($plugin), $config );
}
add_action( 'tgmpa_register', 'redux_sample_register_required_plugins' );

/**

	Use this code to hide the activation notice telling users about a sample panel.

**/
if ( class_exists('ReduxFrameworkPlugin') ) {
	remove_action('admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );	
}
