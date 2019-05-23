<?php 
	 // $search_term = sanitize_text_field( stripslashes( $_GET['search_term']));
$search_term = esc_sql( $_GET['search_term'] );
$search_col = esc_sql( $_GET['search_col'] );

#### pagination began
	$urlPattern = '/dashboard/?section=members&pg=(:num)';
	$rowPerPage = 40;
	$currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
	$offset = ($currentPage - 1) * $rowPerPage;

	$args = array(
	'offset'       => $offset,
	'number'       => $rowPerPage, 
	'count_total'  => true,
	'fields'       => 'all',
 ); 
#### pagination 

#### search began
	# first name/ last_name from user-meta
	if ($search_col == 'first_name' || $search_col == 'last_name' || $search_col == 'Mobile_Phone' || $search_col == 'Country') {
		$args['meta_query'][] = array(
	        'key'     => $search_col,
	        'value'   => $search_term,
	        'compare' => 'LIKE'
	    );
	}

	// email 
	// $args['user_email'] = $email;
	if ($search_col == 'email') {
		$args = array(
			'search'         => $search_term,
			'search_columns' => array( 'user_email' )
		);
	}
	
	#role_in_club 
	if ($search_col == 'role_in_club') {
		$args = array(
		    'role' => $search_term
		);
	}
### search end	

	$getData   = $_GET['id']; //to get ID

	$wp_user_query = new WP_User_Query( $args );
	$members = $wp_user_query->get_results();
		// echo "<pre>";
	 //    print_r($members);
	 //    echo"</pre>";
	$totalCount = $wp_user_query->get_total();

	$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);
?>

<div class="early-bird-content">
	<div class="top-wrapper">
		<div class="search-frm-wrapper">
			<form class="form-inline" action="" style="float: right; margin-bottom: 15px" id="early-bird-registrant-filter">
				<div class="form-group">
					<div class="select-wrapper">
						<select class="select-style form-control" name="search_col">
							<option value="first_name" <?= $search_col == 'first_name' ? ' selected' : '' ?>>First Name</option>
							<option value="last_name" <?= $search_col == 'last_name' ? ' selected' : '' ?>>Last Name</option>
							<option value="email" <?= $search_col == 'email' ? ' selected' : '' ?>>Email</option>
							<option value="Mobile_Phone" <?= $search_col == 'Mobile_Phone' ? ' selected' : '' ?>>Phone</option>
							<option value="Country" <?= $search_col == 'Country' ? ' selected' : '' ?>>Country</option>
							<option value="club" <?= $search_col == 'club' ? ' selected' : '' ?>>Club</option>
							<option value="role_in_club" <?= $search_col == 'role_in_club' ? ' selected' : '' ?>>Role in Club</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="search_term" value="<?= $search_term ?>">
				</div>
				<button type="submit" class="btn btn-danger member-search">Search</button>
			</form>
		</div>
		<div class="add-transaction-right pull-right">
			<div class="btn btn-danger" data-toggle="modal" data-target="#addNewMember">Add New Member</div>
		</div>
	</div>

	<table class="table table-bordered table-striped early-birds-registrant-table">
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Country</th>
				<th>Club</th>
				<th>Role in Club</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($members as $member) {
					// echo "<pre>";
				 //    print_r( get_user_meta( $member->ID ) );
				 //    echo"</pre>";
			?>
			<tr>
				<td><?= $member->first_name ?></td>
				<td><?= $member->last_name ?></td>
				<td><?= $member->user_email ?></td>
				<td><?= $member->Mobile_Phone ?></td>
				<td><?= $member->Country ?></td>
				<td><?php echo "club"; ?></td>
				<td><?= implode(',', $member->roles); ?></td> 
				<td>
				<span data-toggle="modal" data-target="#addNewMember" class="edit-member" data-id="<?= $member->ID; ?>"><i class="fa fa-edit"></i></span>					
				<span><i class="fa fa-trash"></i></span>					
					<!-- <span class="delete-booking del-row" data-id="<?=$book->id;?>"> -->
						<!-- <i class="fa fa-trash"></i> -->

				</td>
			</tr>
		<?php } ?>

		</tbody>
	</table>
	<?= $OpsPaginator->toHtml(); ?>
</div>


<!-- Add New Member Modal Start-->
<div class="modal fade" id="addNewMember" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

<?php if (isset($_SESSION['message'])) : ?>
	<div class="alert alert-<?= $_SESSION['type'] ?>">
		<?= $_SESSION['message'] ?>
	</div>
<?php endif; unset($_SESSION['message']); unset($_SESSION['type']);  ?>

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add New Member</span>
			</div>
			<div class="modal-body">
			  <form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
				<input type="hidden" name="action" value="save_member">
				<input type="hidden" name="id" value="<?= $_GET['id']; ?>">
				<?php wp_nonce_field('saveMember-nonce', 'saveMember');?>
				  <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" name="first_name">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label>Country</label>
							<div class="select-wrapper">
								<select class="select-style form-control" value="<?=$EarlyBirdBooking->country;?>" name="country">
									<?php foreach (OpsSelectOption::CountryName() as $country): ?>
										<option <?=$country == $EarlyBirdBooking->country ? "selected" : "";?>><?=$country;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>Role in Club</label>
							<div class="select-wrapper">
								<select class="select-style form-control" value="<?=$EarlyBirdBooking->role_in_club;?>" name="role_in_club" >
									<?php foreach (OpsSelectOption::RoleInClub() as $role_club): ?>
										<option <?= $role_club == $EarlyBirdBooking->role_in_club ? "selected" : "";?>> <?= $role_club; ?> </option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="my-sqr-check-btn">
								<input type="checkbox" id="sent_by_email" name="sent_by_email">
								<label for="sent_by_email">Sent By Email</label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" name="last_name">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="tel" class="form-control" name="phone">
						</div>
						<div class="form-group">
							<label>Club</label>
							<div class="select-wrapper">
								<select class="select-style form-control" value="<?=$EarlyBirdBooking->club;?>" name="club" >ClubName
									<?php foreach (OpsSelectOption::ClubName() as $clubName): ?>
										<option <?=$clubName == $EarlyBirdBooking->club ? "selected" : "";?>><?=$clubName;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control"  name="password">
						</div>
					</div>
				  </div>
				<div class="text-right">
					<button class="btn btn-danger" type="submit">Save</button>
				</div>
			  </form>	
			</div>
		</div>
	</div>
</div>
<!-- Add New Member Modal end-->






###############################################################################################################################################################################################################################################################################################################################				for EDIT (dash_2.js)			#######################################################################################################################################						#######################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################

<script>

	    //members began
    $('.edit-member').on('click', function() {
        let id = $(this).data('id');
        $('#addNewMember').find("[name='id']").val(id);
        $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_member',
                    member_id: $(this).data('id'),
                    saveMember: $('#saveMember').val(),
                },

            })
            .done(function(response) {
                if (response.success) {
                    $("[name=first_name]").val(response.data.member.first_name);
                    $("[name=last_name]").val(response.data.member.last_name);
                    $("[name=email]").val(response.data.member.user_email);
                    $("[name=phone]").val(response.data.member.Mobile_Phone);
                    $("[name=country]").val(response.data.member.Country);
                    // $("[name=role_in_club]").val(response.data.member.role_in_club);
                    // $("[name=club]").val(response.data.member.club);
                }
            })
            .fail(function() {
                console.log("error");
            })
    });
    //members end

</script>




###########################################################################################################################################################################################################################################################################################################################################	            for AjaxAction (OpsDashAjaxAction.php)        	############################################################################################################################									#######################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################



<?php 

class OpsDashAjaxAction
{
	static public function init()
	{
		$self = new self();

		add_action( "wp_ajax_get_member", array($self, 'getMember') );

	}
	public function getMember()
	{
		if (!isset($_POST['saveMember']) || !wp_verify_nonce($_POST['saveMember'], 'saveMember-nonce')) {
            die("You are not allowed to submit data.");
        }

        $member_id = intval($_POST['member_id']);

        $user = get_userdata( $member_id );
        // $response = get_user_meta($member_id);

        $userdata = array(
        	//'sql_table' => $user->object(from ajax RESPONSE);

            'user_email'            => $user->user_email,   
            'first_name'            => $user->first_name,   
            'last_name'             => $user->last_name,  
            //'role'                 => $_POST['role_in_club'],   //(string) User's role.
            'Mobile_Phone'         => $user->Mobile_Phone,
            'Country'              => $user->Country,         
           // 'club'               => $_POST['club'],         
        );   

        wp_send_json_success(['member' => $userdata]);

	}


}

?>


##########################################################################################################################################################################################################################################################################################################################################				for ADD/UPDATE (OpsDashboardAction.php)	            #############################################################################################################################										#######################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################

<?php
/**
 *
 */
class OpsDashboardAction
{

    public function __construct()
    {
        # code...
    }

    public function init()
    {
        $self = new self;


        add_action('admin_post_save_member', array($self, 'saveMember'));
        add_action('admin_post_nopriv_save_member', array($self, 'saveMember'));

    }

        public function saveMember()
    {
        if (!isset($_POST['saveMember']) || !wp_verify_nonce($_POST['saveMember'], 'saveMember-nonce')) {
            die("You are not allowed to submit data.");
        }

        $user_id = $_POST['id'];
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
            //'role'                => $_POST['role_in_club'],   //(string) User's role.
            'Mobile_Phone'          => $_POST['phone'],
            'Country'               => $_POST['country'],         
           // 'club'                => $_POST['club'],         
        );   
        $user_id = wp_insert_user( $userdata ) ;
        ##add_user_meta to add value to usermeta table
        $is_success = add_user_meta( $user_id, 'Mobile_Phone', $_POST['phone'] );
        $is_success = add_user_meta( $user_id,'Country', $_POST['country'] );
        }
        else{
        $userdata = array(
            'ID'                    => $_POST['id'],
            'user_pass'             => $_POST['password'],
            'user_email'            => $_POST['email'],   
            'first_name'            => $_POST['first_name'],   
            'last_name'             => $_POST['last_name'],  
            //'role'                 => $_POST['role_in_club'],   //(string) User's role.
            'Mobile_Phone'          => $_POST['phone'],
            'Country'               => $_POST['country'],         
           // 'club'                => $_POST['club'],         
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


}        







#######################################################################################################################################################################################################################################################################################################################################################################################################################################################################						for EDIT (dash_2.js)									#######################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################
