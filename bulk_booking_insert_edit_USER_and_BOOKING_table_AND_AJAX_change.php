<?php
$OpsEarlyBirdBooking = new OpsEarlyBirdBooking();
$no_of_person = $OpsEarlyBirdBooking->getBulkPersons(get_current_user_id())[0];

//show SUM total amount against how many member_id created 
$OpsBulkBooking = new OpsBulkBooking();
$bulk_total = $OpsBulkBooking->bulkTotal(get_current_user_id());
	
// $OpsBulkBooking = new OpsBulkBooking();
//$members_name = $OpsBulkBooking->get(['id']);

	##members name by get_users
	$args = array(
		'blog_id'      => $GLOBALS['blog_id'],
		'orderby'      => 'login',
		'order'        => 'ASC',
		'fields'       => 'all',
	); 
	$members = get_users( $args );

	$getData   = $_GET['id'];

	## get all data from bulk_booking_table
	$current_user = get_current_user_id();
	$bulk_name = $OpsBulkBooking->get(['user_id' => $current_user]);
?>

<div class="row">
	<div class="col-md-3" style="padding-left: 0px">
		<div class="well" style="background-color: white;">
			<h1 class="display-1" style="text-align: center"><?= $no_of_person ?></h1>
			<p class="lead" style="text-align: center">Persons you registered as bulk</p>
		</div>
	</div>
	<div class="col-md-3" style="padding-left: 0px">
		<div class="well" style="background-color: white;">
			<h1 class="display-1" style="text-align: center">$<?= number_format($bulk_total[0], 2)  ?></h1> <!--number_format/show with array[0]-->
			<p class="lead" style="text-align: center">Total bulk amount</p>
		</div>
	</div>
</div>

<div class="balk-table">
	<div class="row">
		<div class="col-md-8">
			<div class="form-group text-right">
				<div class="btn btn-danger add-member-btn" data-toggle="modal" data-target="#addMemberModal">Add Member</div>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Price</th>
						<!-- <th>Date</th> -->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($bulk_name as $bulk ) :  $user = get_userdata($bulk->user_id); ?>	
					<tr>
						<td><?= $user->first_name ?></td>
						<td><?= $user->last_name ?></td>
						<td><?= $user->user_email ?></td>
						<td class="price">$<?= $bulk->amount; ?></td>
						<!-- <td class="action">12.40.2019</td> -->
						<td>
							<span class="edit-bulk" data-toggle="modal" data-target="#editMemberModal" data-id="<?= $bulk->id;?>"><i class="fa fa-edit"></i></span>
							<span class="delete-bulk" href="" class="text-danger" data-id="<?= $bulk->id; ?>"><i class="fa fa-trash"></i></span>
						</td>
					</tr>
				<?php endforeach; ?>	

				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Start-->
<div class="modal fade bulkMemberModal" id="addMemberModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Member</span>
			</div>
			<div class="modal-body">
			  <form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
				<input type="hidden" name="action" value="save_bulk">
				<input type="hidden" name="id" value="<?= $_GET['id']?>">				
				<?php wp_nonce_field('saveBulk-nonce', 'saveBulk');?>	
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Members</label>
							<select class="chosen-select form-control member-name" data-placeholder="Select Your Options" name="member_name">
								<option value="" disabled selected>please select member</option>
								<?php foreach ($members as $member) { ?>
									<option value="<?= $member->ID?>"><?= get_user_meta($member->ID,'first_name',ture).' '.get_user_meta($member->ID,'last_name',ture); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" class="form-control m_first_name" name="first_name">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" class="form-control m_last_name" name="last_name">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" class="form-control email" name="email">
						</div>
					</div>

					<div class="col-md-6">						
						<div class="form-group">
							<label for="">Price</label>
							<input type="text" class="form-control" name="price">
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
<!-- Modal end-->

<!-- Modal Start-->
<div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Edit Member</span>
			</div>
			<div class="modal-body">
			  <form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
				<input type="hidden" name="action" value="update_bulk">
				<input type="hidden" name="id">				
				<input type="hidden" name="member_id">	<!-- get member_id-->			
				<?php wp_nonce_field('updateBulk-nonce', 'updateBulk');?>
					
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" class="form-control m_first_name" name="first_name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" class="form-control m_last_name" name="last_name">			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Email</label>
							<input type="text" class="form-control" name="email">
						</div>
					</div>
					<div class="col-md-6">						
						<div class="form-group">
							<label for="">Price</label>
							<input type="text" class="form-control" name="price">
						</div>
					</div>
				</div>
				<div class="text-right">
					<button class="btn btn-danger" type="submit">Update</button>
				</div>
			  </form>	
			</div>
		</div>
	</div>
</div>
<!-- Modal end-->



<!-- #################################################################################################################
#################################################################################################################
############################################## 				OpsBulkBooking										###################################################################
#################################################################################################################
################################################################################################################# -->

<?php
/**
 * Created by PhpStorm.
 * User: Mehedee
 * Date: 1/5/2019
 * Time: 12:22 PM
 */

class OpsBulkBooking extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->prefix . "bulk_booking";
    }

    public function bulkTotal($user_id)
    {
    	return $this->db->get_col("SELECT COALESCE(SUM(amount), 0) from $this->table Where user_id = {$user_id} ");
    }
    
}


/////////
//How do I get SUM function in MySQL to return '0' if no values are found?
/*SELECT COALESCE(SUM(column),0)
FROM   table
WHERE  ...*/


?>

<!-- #################################################################################################################
#################################################################################################################
############################################## 				OpsAction										###################################################################
#################################################################################################################
################################################################################################################# -->

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

        add_action('admin_post_save_bulk', array($self, 'saveBulk'));
        add_action('admin_post_nopriv_save_bulk', array($self, 'saveBulk'));

        add_action('admin_post_update_bulk', array($self, 'updateBulk'));
        add_action('admin_post_nopriv_update_bulk', array($self, 'updateBulk'));
    }

        public function updateBulk()
    {
        if (!isset($_POST['updateBulk']) || !wp_verify_nonce( $_POST['updateBulk'], 'updateBulk-nonce' )) {
            die('You are not allow to submit data');
        }

        $member_id = $_POST['member_id'];
        $email  = sanitize_email( $_POST['email'] );
        $user   = get_user_by('email', $email);
        $current_user_id = get_current_user_id();

        $userdata = array(
                'user_email'    => $_POST['email'],
                'first_name'    => $_POST['first_name'],
                'last_name'     => $_POST['last_name'],
            );  
 
        if($user){
            $user_id = $user->ID;
            wp_update_user( $userdata );
        }

         $OpsBulkBooking     = new OpsBulkBooking();
            $data               = [];
            $data['amount']     = floatval($_POST['price']);
            $data['member_id']  = $member_id;
            $data['user_id']    = $current_user_id;

            $return             = $OpsBulkBooking->updateOrInsert($data, ['member_id' => $member_id]);

            # assigned to payment table

            $OpsPayment = new OpsPayment;
            $OpsPayment->updateOrInsert(
                [
                    'user_id' => $user_id,
                    'payment_method' => 'bulk',
                    'status' => 'paid',
                    'amount' => $data['amount']
                ],
                ['user_id' => $user_id]
            );

            wp_redirect($_POST['_wp_http_referer'], 302);
            exit(); 

    }



    public function saveBulk()
    {
        if (!isset($_POST['saveBulk']) || !wp_verify_nonce( $_POST['saveBulk'], 'saveBulk-nonce' )) {
            die('You are not allow to submit data');
        }

	//check user by email
        $email = sanitize_email( $_POST['email'] );
        $user   = get_user_by('email', $email); //

        $userdata = array(
                'user_email'    => $_POST['email'],
                'first_name'    => $_POST['first_name'],
                'last_name'     => $_POST['last_name'],
            );  

        if (!$user) {
            $userdata['user_login']  = $_POST['first_name'].$_POST['last_name'];

            $user_id = wp_insert_user( $userdata ) ;          
        }
        else{
            $user_id = $user->ID;
            wp_update_user( $userdata );   
   		}
   	}	
}

?>



<!-- #################################################################################################################
#################################################################################################################
############################################## 				dash_2.js										###################################################################
#################################################################################################################
################################################################################################################# -->
<script>
	
	jQuery(function ($) {

  	//update bulk 
    $('.edit-bulk').on('click', function() {
        let id = $(this).data('id');
        console.log(id);
        $('#editMemberModal').find("[name='id']").val(id);
        $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'update_bulk',
                    bulk_id: id,
                    updateBulk: $('#updateBulk').val()
                },
            })
            .done(function(response) {
                if (response.success) {
                    $("[name=first_name]").val(response.data.bulk_update.first_name);
                    $("[name=last_name]").val(response.data.bulk_update.last_name);
                    $("[name=email]").val(response.data.bulk_update.email);
                    $("[name=price]").val(response.data.bulk_update.price);
                    $("[name=member_id]").val(response.data.bulk_update.member_id);  //get member_id to update by member_id for update bulk by member_id
                }
            })
            .fail(function() {
                console.log("error");
            })
    })

    //change member-name
    $(document).on('change','.bulkMemberModal .member-name', function () {
        let id = $(this).val();
        console.log(id);

        $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_bulk_member',
                    id: $('.member-name').val(), //get member ID
                    saveBulk: $('#saveBulk').val(),
                },

            })
            .done(function(response) {
                if (response.success) {
                    $("[name=first_name]").val(response.data.bulk_member.first_name);
                    $("[name=last_name]").val(response.data.bulk_member.last_name);
                    $("[name=email]").val(response.data.bulk_member.user_email);
                }
            })
            .fail(function() {
                console.log("error");
            })
    })


}

</script>



<!-- #################################################################################################################
#################################################################################################################
############################################## 				OpsAjaxAction										###################################################################
#################################################################################################################
################################################################################################################# -->

<?php

/**
 *
 */
class OpsAjaxAction
{

    static public function init ()
    {
        $self = new self();

        add_action("wp_ajax_get_bulk_member", array($self, 'getBulkMember'));
        add_action("wp_ajax_update_bulk", array($self, 'updateBulk'));

    }

    public function updateBulk()
    {
        if (!isset($_POST['updateBulk']) || !wp_verify_nonce($_POST['updateBulk'], 'updateBulk-nonce')) {
            die("You are not allowed to submit data.");
        }

        $bulk_id = intval($_POST['bulk_id']);

        $OpsBulkBooking = new OpsBulkBooking();
        $response = $OpsBulkBooking->getRow(['id' => $bulk_id]);
        
        //show first_name/last_name by $user_id..........
        $data = [];
        $data['first_name'] = get_user_meta( $response->user_id, 'first_name', true );
        $data['last_name'] = get_user_meta( $response->user_id, 'last_name', true );
        $user = get_user_by( 'ID', $response->user_id );
        $data['email'] = $user->user_email;//get email by user_id
        
        $data['price'] = $response->amount; 
        $data['member_id'] = $response->member_id;  //get member_id to update by member_id

        wp_send_json_success(['bulk_update' => $data]);

    }

    public function getBulkMember()
    {
    
    $member_id = intval($_POST['id']);
    $user 	   = get_userdata( $member_id ); //get all users list

    $userdata = array(
            'user_email'            => $user->user_email,   
            'first_name'            => $user->first_name,   
            'last_name'             => $user->last_name,          
        );   

    wp_send_json_success(['bulk_member' => $userdata]);
    
    }
}

?>    