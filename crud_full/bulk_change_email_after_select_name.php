
###########################################################################################################################################################
#######################################################        bulk-payment.php     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################
<?php
$OpsEarlyBirdBooking = new OpsEarlyBirdBooking();
$no_of_person = $OpsEarlyBirdBooking->getBulkPersons(get_current_user_id())[0];

$total_deposit = $OpsEarlyBirdBooking->bulkTotal(get_current_user_id());



$OpsBulkBooking = new OpsBulkBooking();
$bulk_total = $OpsBulkBooking->bulkTotal(get_current_user_id())[0];

$balance = $total_deposit - $bulk_total;

$current_user = get_current_user_id();

$bulk_name = $OpsBulkBooking->get(['user_id' => $current_user]);

$args = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'orderby'      => 'login',
	'order'        => 'ASC',
	'fields'       => 'all',

 ); 
	$members = get_users( $args );  //to show member first_name, last_name
	// echo "<pre>";
 //    print_r($members);
 //    echo"</pre>";
	$getData   = $_GET['id'];
?>

<div class="row">
	<div class="col-md-8">
		<div class="single-box-wrapper">
			<div class="single-box">
				<div class="single-box-middle">
					<h1 class="display-1"><?= $no_of_person ?></h1>
					<p class="lead">Persons you registered as bulk</p>
				</div>
			</div>
		</div>
		<div class="single-box-wrapper">
			<div class="single-box">
				<div class="single-box-middle">
					<h1 class="display-1">$<?=number_format($total_deposit, 2) ?> </h1>
					<p class="lead">Total Deposit </p>
				</div>
			</div>
		</div>
		<div class="single-box-wrapper">
			<div class="single-box">
				<div class="single-box-middle">
					<h1 class="display-1">$<?= number_format($bulk_total, 2)  ?></h1>
					<p class="lead">Assigned</p>
				</div>
			</div>
		</div>
		<div class="single-box-wrapper">
			<div class="single-box">
				<div class="single-box-middle">
					<h1 class="display-1">$<?= number_format($balance, 2)  ?></h1>
					<p class="lead">Balance</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="balk-table">
	<div class="row">
		<div class="col-md-8">
			<?php if($balance > 0 ): ?>
			<div class="form-group text-right">
				<div class="btn btn-danger add-member-btn" data-toggle="modal" data-target="#addMemberModal">Add Member</div>
			</div>
		<?php endif ?>
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
				<input type="hidden" name="member_id">				
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


###########################################################################################################################################################
#######################################################        script.js     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################

<script>
	
    $('.delete-bulk').on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);   
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    type: 'post',
                    url: frontend_form_object.ajaxurl,
                    data: {
                        action: 'delete_bulk',
                        bulk_id: id,
                    },
                })
                .done(function(response) {
                    swal('Great!', 'Successfully deleted.', 'success');
                    // _parent.remove();
                    location.reload();
                });
            }
        });
    })

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
                    $("[name=member_id]").val(response.data.bulk_update.member_id);
                }
            })
            .fail(function() {
                console.log("error");
            })
    })

    $(document).on('change','.bulkMemberModal .member-name', function () {
        let id = $(this).val();
        console.log(id);

        $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_bulk_member',
                    id: $('.member-name').val(),
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


    $.ajax()

</script>




###########################################################################################################################################################
#######################################################        class-OpsAjaxAction.php     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################

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
        add_action("wp_ajax_delete_bulk", array($self, 'deleteBulk'));
    }    

    public function deleteBulk()
    {
        $OpsBulkBooking = new OpsBulkBooking();
        $delete_bulk = $OpsBulkBooking->delete(['id' => $_POST['bulk_id']]);
    }

    public function updateBulk()
    {
        if (!isset($_POST['updateBulk']) || !wp_verify_nonce($_POST['updateBulk'], 'updateBulk-nonce')) {
            die("You are not allowed to submit data.");
        }

        $bulk_id = intval($_POST['bulk_id']);

        $OpsBulkBooking = new OpsBulkBooking();
        $response = $OpsBulkBooking->getRow(['id' => $bulk_id]);
        
        $data = [];
        $data['first_name'] = get_user_meta( $response->user_id, 'first_name', true );
        $data['last_name'] = get_user_meta( $response->user_id, 'last_name', true );
        
        $user = get_user_by( 'ID', $response->user_id );
        
        $data['email'] = $user->user_email;
        $data['price'] = $response->amount; 
        $data['member_id'] = $response->member_id; 

        wp_send_json_success(['bulk_update' => $data]);

    }

    public function getBulkMember()
    {
    
        $member_id = intval($_POST['id']);
        $user = get_userdata( $member_id );

        $userdata = array(
                'user_email'            => $user->user_email,   
                'first_name'            => $user->first_name,   
                'last_name'             => $user->last_name,          
            ); 
                 

        wp_send_json_success(['bulk_member' => $userdata]);
    
    }

}

?>

###########################################################################################################################################################
#######################################################        class-OpsEarlyBirdBooking.php     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################


<?php
/**
 *
 */
class OpsEarlyBirdBooking extends AbstractModule {
	protected $table;
	public function __construct() {
		parent::__construct();
		$this->table = $this->db->prefix . "early_bird_booking";
		$this->early_bird_payment_table = $this->db->prefix . "early_bird_payment";
		$this->payments_table = $this->db->prefix . "payments";
		$this->usermeta = $this->db->prefix . "usermeta";
	}



	public function getBulkPersons($user_id)
	{
		$early_bird_option_3 = EARLY_BIRD_DEPOSIT_OPTION_3;
		return $this->db->get_col("SELECT COALESCE(SUM(no_of_person), 0)  as no_of_person FROM $this->table AS e 
		LEFT JOIN $this->early_bird_payment_table AS ep ON ep.early_bird_booking_id = e.id 
		LEFT JOIN $this->payments_table AS p ON ep.payment_id = p.id
		WHERE e.user_id = $user_id AND e.make_a_deposit = '{$early_bird_option_3}' AND p.status = 'paid'");
	}

	public function bulkTotal($user_id)
	{
		$early_bird_option_3 = EARLY_BIRD_DEPOSIT_OPTION_3;
		return $this->db->get_var("SELECT SUM(p.amount) FROM $this->table AS e 
		LEFT JOIN $this->early_bird_payment_table AS ep ON ep.early_bird_booking_id = e.id 
		LEFT JOIN $this->payments_table AS p ON ep.payment_id = p.id
		WHERE e.user_id = $user_id AND e.make_a_deposit = '{$early_bird_option_3}' AND p.status = 'paid'");

	}
}