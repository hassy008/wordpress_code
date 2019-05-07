<!-- edit link -->
<td>
	<a href="<?php echo home_url('/dashboard/?section=members&action=edit'); ?>&user_id=<?php echo ($member->ID); ?>&edit=1"><span class="edit-row"><i class="fa fa-edit"></i></span></a>
</td>
<!-- edit link -->


<!--edit & update page began-->
<?php 
	$isEdit = false;
	if (isset($_GET['edit']) && $_GET['edit']==1) {
		$isEdit = true;
	}

	$getData   = $_GET['user_id']; //to get ID
	$user_info = get_userdata($getData);
?>

<?php if (isset($_SESSION['message'])) : ?>
	<div class="alert alert-<?= $_SESSION['type'] ?>">
		<?= $_SESSION['message'] ?>
	</div>
<?php endif; unset($_SESSION['message']); unset($_SESSION['type']);  ?>

<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
    <input type="hidden" name="action" value="insert_update">
    <input type="hidden" name="user_id" value="<?= $_GET['user_id']; ?>"> <!--update purpose-->
    <?php wp_nonce_field('userAdd-nonce', 'userAdd');?>

<div class="container">
	<div class="bootstrap-wrapper">
		<div class="member-details">
			<div class="single-section-wrapper active">
				<label for="" class="title-name">First Name</label>
				<div class="val-input-wrapper">
					<span class="value"><?= $user_info->first_name?></span>
					<input type="text" class="form-control details-input-control" name="first_name" value="<?= $user_info->first_name?>">
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Last Name</label>
				<div class="val-input-wrapper">
					<span class="value"><?= $user_info->last_name?></span>
					<input type="text" class="form-control details-input-control" name="last_name" value="<?= $user_info->last_name?>">
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Email</label>
				<div class="val-input-wrapper">
					<span class="value"><?= $user_info->user_email?></span>
					<input type="text" class="form-control details-input-control" name="email" value="<?= $user_info->user_email?>">
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Phone</label>
				<div class="val-input-wrapper">
					<span class="value"><?= $user_info->Mobile_Phone?></span>
					<input type="tel" class="form-control details-input-control" name="phone" value="<?= $user_info->Mobile_Phone?>">
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Country</label>
				<div class="val-input-wrapper">
					<span class="value"><?= $user_info->Country?></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$user_info->Country;?>" name="country">
							<?php foreach (OpsSelectOption::CountryName() as $country): ?>
							<option <?=$country == $user_info->Country ? "selected" : "";?>><?=$country;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Club</label>
				<div class="val-input-wrapper">
					<span class="value"></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$user_info->club;?>" name="club" >ClubName
							<?php foreach (OpsSelectOption::ClubName() as $clubName): ?>
							<option <?=$clubName == $user_info->club ? "selected" : "";?>><?=$clubName;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Role in Club</label>
				<div class="val-input-wrapper">
					<span class="value"></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$user_info->role_in_club;?>" name="role_in_club" >
							<?php foreach (OpsSelectOption::RoleInClub() as $role_club): ?>
							<option <?= $role_club == $user_info->role_in_club ? "selected" : "";?>> <?= $role_club; ?> </option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Password</label>
				<div class="val-input-wrapper">
					<span class="value"></span>
					<input type="password" class="form-control details-input-control" name="password" value="">
				</div>
			</div>
			<div class="single-section-wrapper active">
				<label for="" class="title-name">Sent Email</label>
				<div class="val-input-wrapper">
					<span class="value">
						<div class="my-sqr-check-btn">
							<input type="checkbox" checked=""><label>Sent Email</label>
						</div>
					</span>
					<div class="details-input-control">
						<div class="my-sqr-check-btn">
							<input type="checkbox" id="sent_mail">
							<label for="sent_mail">Sent Email</label>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="form-group text-right">
				<?php if ($isEdit): ?>
				    <button type="submit" class="btn btn-danger">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn btn-danger">SAVE</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</form>


<!--edit & update page END-->


<!-- OPS-Action.php -->
<?php 
 public static function init(){
    add_action('admin_post_insert_update', array($self, 'insert_update'));
    add_action('admin_post_nopriv_insert_update', array($self, 'insert_update'));
}
	 public function insert_update()
    {
        if (!isset($_POST['userAdd']) || !wp_verify_nonce($_POST['userAdd'], 'userAdd-nonce')) {
            die("You are not allowed to submit data.");
        }
        
        $user_id = $_POST['user_id'];
            // echo "<pre>";
            // print_r($user_id);
            // echo"</pre>";
            // die;
            if ( !$user_id ) {
            
        $userdata = array(
            'user_login'            => $_POST['first_name'].$_POST['last_name'],   
            'user_pass'             => $_POST['password'],
            'user_email'            => $_POST['email'],   
            'first_name'            => $_POST['first_name'],   
            'last_name'             => $_POST['last_name'],  
            //'role'                 => $_POST['role_in_club'],   //(string) User's role.
            'Mobile_Phone'         => $_POST['phone'],
            'Country'              => $_POST['country'],         
           // 'club'               => $_POST['club'],         
        );   
        $user_id = wp_insert_user( $userdata ) ;

        ##add_user_meta to add value to usermeta table
        $is_success = add_user_meta( $user_id, 'Mobile_Phone', $_POST['phone'] );
        $is_success = add_user_meta( $user_id,'Country', $_POST['country'] );
        }
        else{
        $userdata = array(
            'ID' => $_POST['user_id'],
            // 'user_login'            => $_POST['first_name'].$_POST['last_name'],   
            'user_pass'             => $_POST['password'],
            'user_email'            => $_POST['email'],   
            'first_name'            => $_POST['first_name'],   
            'last_name'             => $_POST['last_name'],  
            //'role'                 => $_POST['role_in_club'],   //(string) User's role.
            'Mobile_Phone'         => $_POST['phone'],
            'Country'              => $_POST['country'],         
           // 'club'               => $_POST['club'],         
        );   
        $user_update = wp_update_user( $userdata ) ;

        ##add_user_meta to add value to usermeta table
        $is_success = update_user_meta( $user_update, 'Mobile_Phone', $_POST['phone'] );
        $is_success = update_user_meta( $user_update,'Country', $_POST['country'] );

        }
         if (! is_wp_error($is_success)) {
            $_SESSION['type']    = 'success';
            $_SESSION['message'] = 'Successfully updated.';
            wp_redirect($_POST['_wp_http_referer'], 302);
            exit();
        }

            $_SESSION['type']    = 'danger';
            $_SESSION['message'] = 'Something went wrong. Please try again later. If problem persists, please contact us.';
            wp_redirect($_POST['_wp_http_referer'], 302);
            exit();    
         
    }

?>
<!-- OPS-Action.php -->
