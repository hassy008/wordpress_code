<?php
    $user_data = wp_get_current_user();
    if (!is_user_logged_in()) : ?>
    	<div class="well" style="margin-top: 20px">
			<span class="text-danger">You have to login to view the page. <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Click here to login</a>.</span> 
    	</div>
<?php
    return false; elseif (!in_array('webmaster', (array) $user_data->roles) &&  !in_array('administrator', (array) $user_data->roles) &&  !in_array('editor', (array) $user_data->roles))   : ?>
	<h2 class="text-danger">
		<b>Unauthorized action!</b> You don't have permission to view this page.
	</h2>
<?php
    return false;
    endif; 
?>	




<!-- SHOW LOGIN OPTION IF YOU"RE NOT LOGGED IN -->
<?php
$user_id = get_current_user_id();
   // $user_data = wp_get_current_user();
    if (!is_user_logged_in()) : ?>
        <div class="well" style="margin-top: 20px">
            <span class="text-danger">You have to login to view the page. <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Click here to login</a>.</span> 
        </div>
<?php endif; ?>
<!-- SHOW LOGIN OPTION IF YOU"RE NOT LOGGED IN -->





<!-- Success message use $_SESSION beginning-->
                            <!-- Accessing SESSION Values -->
<?php if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-<?= $_SESSION['type'] ?>">
        <?= $_SESSION['message'] ?>
    </div>
<?php endif; unset($_SESSION['message']); unset($_SESSION['type']); ?>
    
                            <!-- $_SESSION function -->
    <?
         if (! is_wp_error($is_success)) {
            $_SESSION['type']    = 'success';
            $_SESSION['message'] = 'Successfully updated.';
            wp_redirect($_POST['_wp_http_referer'], 302);
            exit();
        }

            $_SESSION['type']    = 'danger';
            $_SESSION['message'] = 'Something went wrong. Please try again later. If problem persists, please contact us.';
?>
<!-- Success message use $_SESSION end-->




<!-- Success message use $_COOKIE beginning-->
                                    <!-- Accessing Cookies Values -->
    <?php if (isset($_COOKIE['message'])) : ?>
        <div class="alert alert-<?= $_COOKIE['type'] ?>">
            <?= $_COOKIE['message'] ?>
        </div>
    <?php endif; 
        unset($_COOKIE['message']); unset($_COOKIE['type']); 
        setcookie('message', "", time() - 3600, '/'); setcookie('type', "", time() - 3600, '/'); //this line to delete cookie
    ?>


                                    <!-- $_COOKIE function -->
        <!-- //show success message Setting a cookie -->
        <?
//      setcookie(name, value, expire, path, domain, secure);

        setcookie('type', 'success', time() + (86400 * 30), "/");
        setcookie('message', 'Successfully Saved.', time() + (86400 * 30), "/");

        ?>
<!-- Success message use $_COOKIE end-->
