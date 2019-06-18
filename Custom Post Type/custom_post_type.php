<?php
class OpsCustomPost
{

    public function __construct()
    {

    }

    public function init()
    {
       $self = new self();
       add_action('init', array($self, 'CustomPostType'));
       add_action('init', array($self, 'CustomPostType2'));
    }

    public function CustomPostType()
    {
        register_post_type(
            'customPost',
            array(
                'labels' => array(
                    'name' => __('Custom Posts'),
                    'singular_name' => __('Custom Post')
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
    }

    public function CustomPostType2() 
    {
        register_post_type( 'movies',
        // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Movies' ),
                    'singular_name' => __( 'Movie' )
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'movies'),
            )
        );
    }

}


?>




############################################################################################################################################################
############################################################################################################################################################
############################################################################################################################################################
############################################################################################################################################################
#######################################                app.php                                     #######################################
##############################################################################
############################################################################################################################################################
############################################################################################################################################################


<?php 
/*
Plugin Name: Opcodespace
Description: Custom coding and desgin
Plugin URI: http://opcodespace.com
Author: Md. Mehedee Rahman <mehedee@opcodespace.com>
Author URI: http://opcodespace.com
Version: 1.0
Text Domain: opcodespace
*/

define("OP_PATH", plugin_dir_path(__FILE__));
define("OP_VIEW_PATH", plugin_dir_path(__FILE__) . "view/");
define("OP_ASSETSURL", plugins_url("assets/", __FILE__));

spl_autoload_register(function ($class_name) {
    if (false !== strpos($class_name, 'Ops')) {
        include_once 'src/class-' .$class_name . '.php';
    }
});




// class Autoloader {
//     static public function loader($className) {
//         $filename = PFM_PATH . "src/" . str_replace("\\", '/', $className) . ".php";
//         if (file_exists($filename)) {
//             include($filename);
//             if (class_exists($className)) {
//                 return TRUE;
//             }
//         }
//         return FALSE;
//     }
// }
// spl_autoload_register('Autoloader::loader');

# abstract
include_once 'src/abstract/class-AbstractModule.php';
include_once 'src/abstract/class-AbstractNotification.php';

include_once 'functions.php';
include_once 'page-options.php';
require_once 'inc/vendor/autoload.php';


add_action('plugins_loaded', array('OpsShortCode', 'init'));
add_action('plugins_loaded', array('OpsAction', 'init'));
add_action('plugins_loaded', array('OpsEnqueue', 'init'));
add_action('plugins_loaded', array('OpsAjaxAction', 'init'));
add_action('plugins_loaded', array('OpsFilter', 'init'));
add_action('plugins_loaded', array('OpsCustomPost', 'init'));

# Install table
//register_activation_hook(__FILE__, array('OpsInstallTable', 'token'));
register_activation_hook(__FILE__, array('OpsInstallTable', 'crud_user'));
register_activation_hook(__FILE__, array('OpsInstallTable', 'crud_user_action'));

function register_session_customization() {
    if (!session_id())
        session_start();
}

add_action('init', 'register_session_customization');

