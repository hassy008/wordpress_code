###################################################################################################
################################# user-login.php[front-end] #######################################################

<?php 
	$args = array(
		'blog_id'      => $GLOBALS['blog_id'],
		'role'         => '',
		'orderby'      => 'login',
		'order'        => 'ASC',
		'fields'       => 'all',
	 ); 

	$all_users = get_users( $args ); 
/*		echo '<pre>';
		print_r($all_users);
		echo '</pre>';*/

?>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Admin User Login</label>
        </div>

        <form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
            <input type="hidden" name="action" value="send_user_email" >
            <?php wp_nonce_field('sendUserEmail-nonce', 'sendUserEmail'); ?>

            <select class="chosen-select form-control" data-placeholder="Select Your User" name="user_info">
                <?php foreach ($all_users as $all_user) { ?>
                    <!-- <option value=""></option> -->
                    <option value="<?= $all_user->ID; ?>"><?= get_user_meta($all_user->ID,'first_name',ture).' '.get_user_meta($all_user->ID,'last_name',ture) ?>
                    </option>
                <?php } ?>
            </select>
          
            <div class="modal-body">
                <div class="text-left">
                    <button class="btn btn-danger">Send</button>
                </div>
            </div>
        </form>

    </div>          
</div>





###################################################################################################
################################# class-OpsAction.php #######################################################
<?php

/**
 *
 */

require_once OP_PATH . "inc/vendor/leafo/scssphp/scss.inc.php";

class OpsAction
{

    public function __construct()
    {
    }

    public static function init()
    {
        $self = new self;

        add_action("admin_post_send_user_email", array($self, 'sendUserEmail'));
        add_action("admin_post_auto_login", array($self, 'autoLogin'));

    }

    public function autoLogin()
    {
        // for autologin we need [TOKEN, USERNAME, USER_ID]

        $token = $_GET['token']; // we passed token $param
        $uername = $_GET['username']; // we passed token $param

        $user = get_user_by( 'login', $uername );
        $saved_token = get_user_meta( $user->ID, 'verify_token', true );

        if ( $saved_token == $token ) {
            $user_id = $user->ID; 
            wp_set_current_user($user_id, $uername);
            wp_set_auth_cookie($user_id); 
            do_action('wp_login', $uername); 
            wp_redirect( get_option( 'siteurl' ). '/my-account' );
            exit();
        }
        die("Sorry this link is not valid");

    }



    // Send Email with  link
    public function sendUserEmail()
    {
        if (!isset($_POST['sendUserEmail']) || !wp_verify_nonce( $_POST['sendUserEmail'], 'sendUserEmail-nonce' )) {
            die('You are not allow to submit data');
        }

        $user_id           = intval($_POST['user_info']);
        $user              = get_user_by('ID', $user_id);
        // $token             = bin2hex(random_bytes( 32 ));
        $token =  md5(uniqid(rand(), TRUE));

        
        //save the token and date for verify email
        $verify_link_token = update_user_meta( $user_id, 'verify_token', $token);
        $verify_link_date  = update_user_meta( $user_id, 'date',  date('Y-m-d H:i:s') );
        $link              = get_site_url() . '/wp-admin/admin-post.php?action=auto_login';
        

        // @param is using for passing data through [ http_build_query() ] 
        $param = [
            'token' => $token,
            'username' => $user->user_login
        ];

        $OpsNotification   = new OpsNotification;

        $mail_arr = [
            'first_name'   => get_user_meta($user_id, 'first_name', true) ,
            'last_name'    => get_user_meta($user_id, 'last_name', true) ,
            //'link'         => $link.'='.$verify_link_date, //// if you get return 1 then [update_user_meta] save successfully 
            // 'link'         => $link.'='.$token,
            'link'         => $link . '&' . http_build_query($param),
        ];

        // echo '<pre>';
        // echo print_r($mail_arr);
        // echo '<pre>';
        // die();

        $subject = $OpsNotification->replace($mail_arr, get_field('subject', 4417));
        $message = $OpsNotification->replace($mail_arr, get_field('content', 4417));
        
        $email_address = $user->user_email;

        $OpsNotification->send($email_address, $subject, $message);
    
        wp_redirect($_POST['_wp_http_referer'], 302);
        exit(); 
    }

}

?>




###################################################################################################
################################# class-OpsNotification.php #######################################################



<?php
/**
 * 
 */
class OpsNotification extends AbstractNotification
{
	
	function __construct()
	{
		# code...
	}


}


?>


###################################################################################################
################################# class-AbstractNotification.php #######################################################

<?php
/**
 *
 */
class AbstractNotification
{

    public function send($to, $subject, $body, $attachments = null)
    {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers[] = 'From: Winnipeg 2020 NASC <info@winnipeg2020nasc.com>';

        wp_mail( $to, $subject, $body, $headers, $attachments );
    }

    public function shortCode($data)
    {
        $short_codes = [];
        foreach ($data as $key => $value){
            $short_codes["{".$key ."}"] = $value;
        }

        return $short_codes;
    }


    public function replace($data, $subject)
    {
        $short_codes = $this->shortCode($data);
        return str_replace(array_keys($short_codes), array_values($short_codes), $subject);
    }
}

?>