<?php  
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	$search_col = esc_sql($_GET['search_col']);
	$search_term = esc_sql($_GET['search_term']);
	
	#####pagination 
	$total = null;
	$urlPattern ='/dashboard/?section=guests&pg=(:num)';
	$rowPerPage = 40;
	$currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
	$offset = ($currentPage - 1) * $rowPerPage;

	// $args = array(
	// 'offset'       => $offset,
	// 'number'       => $rowPerPage, 
	// 'count_total'  => true,
	// 'fields'       => 'all',
	// );

	// $wp_user_query = new WP_User_Query($args);
	// $totalCount = $wp_user_query->get_total();

	//$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);
	#######pagination end

	//$members = $wp_user_query->get_results();

	$OpsAttendee = new OpsAttendee();
	$guests = $OpsAttendee->get(['type' => 'Guest'], $rowPerPage, $offset);

	$totalCount = $OpsAttendee->totalCount(['type' => 'Guest']);

	$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);
?>

<div class="guest-table-wrapper">
	<div class="search-frm-wrapper">
		<form class="form-inline" action="/dashboard/?section=guests" style="margin-bottom: 15px">
			<div class="form-group">
				<div class="select-wrapper">
					<select class="select-style form-control" name="search_col">
						<option value=""></option>
						<!-- <option value="member_f_name" <?= $search_col == 'member_f_name' ? ' selected' : '' ?>>Member First Name</option>
						<option value="member_l_name" <?= $search_col == 'member_l_name' ? ' selected' : '' ?>>Member Last Name</option>
						<option value="guest_f_name" <?= $search_col == 'guest_f_name' ? ' selected' : '' ?>>Guest First Name</option>
						<option value="guest_l_name" <?= $search_col == 'guest_l_name' ? ' selected' : '' ?>>Guest Last Name</option>
						<option value="gender" <?= $search_col == 'gender' ? ' selected' : '' ?>>Gender</option> -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="search_term" value="<?= $search_term ?>">
			</div>
			<button type="submit" class="btn btn-danger dashboard-guest-search">Search</button>
		</form>
	</div>
	<div class="form-group text-right">
		<div class="btn btn-danger" data-toggle="modal" data-target="#addGuest2">Add Guest</div>
	</div>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Member First Name</th>
				<th>Member Last Name</th>
				<th>Guest First Name</th>
				<th>Guest Last Name</th>
				<th>Gender</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($guests as $guest) {
					// echo "<pre>";
				 //    print_r( get_user_meta( $guest->user_id,'first_name',ture) );
				 //    echo"</pre>";
			?>
			<tr>
				<!-- <td><?= $guest->first_name; ?></td> -->
				<td><?= get_user_meta( $guest->user_id,'first_name',ture) ?></td>	
				<td><?= get_user_meta( $guest->user_id,'last_name',ture) ?></td>
				<td><?= $guest->first_name ;?></td>
				<td><?= $guest->last_name ;?></td>
				<td><?= $guest->sex ;?></td>
				<td class="action">
					<span class="edit-guest" data-toggle="modal" data-target="#addGuest2" data-id="<?= $guest->id; ?>"><i class="fa fa-edit"></i></span>
					<span class="delete-guest" data-id="<?= $guest->id;?>"><i class="fa fa-trash"></i></span>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<?= $OpsPaginator->toHtml(); ?>

</div>


<!-- Modal Start-->
<div class="modal fade" id="addGuest2" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Guest</span>
			</div>
			<div class="modal-body">
				<form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
					<input type="hidden" name="action" value="save_guest">
					<input type="hidden" name="id">
					<?php wp_nonce_field('saveGuest-nonce', 'saveGuest');?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Add Member</label>
							<select class="chosen-select form-control" data-placeholder="Select Your Options" name="attendee_ids">
								<?php foreach ($guests as $guest) { ?>
										<option value="<?= $guest->user_id?>"><?= get_user_meta($guest->user_id,'first_name',ture) ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Guest First Name</label>
							<input type="text" class="form-control"  name="guest_first_name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Guest Last Name</label>
							<input type="text" class="form-control" name="guest_last_name">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Gender</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="male1" name="gender" value="Male"><label for="male1">Male</label>
								<input type="radio" id="female1" name="gender" value="Female"><label for="female1">Female</label>
							</div>
						</div>
					</div>
				</div>
				<div class="text-right">
					<div class="btn btn-danger" type="submit">Save</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal end-->







<!--  #######################################################     old_script.js       ##############################################################-->

<script>
	//edit guest 
    $('.edit-guest').on('click', function() {
        let id = $(this).data('id');
        //console.log(id);
        $('#addGuest2').find("[name='id']").val(id);
        $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_guest',
                    guest_id: id,
                    saveGuest: $('#saveGuest').val()
                },
            })
            .done(function(response) {
                if (response.success) {
                    $("[name=attendee_ids]").val(response.data.guest.user_id);
                    $("[name=guest_first_name]").val(response.data.guest.first_name);
                    $("[name=guest_last_name]").val(response.data.guest.last_name);
                    $(`[name=gender][value=${response.data.guest.sex}]`).prop('checked', true);  //select checkbox dynamically
                }
            })
            .fail(function() {
                console.log("error");
            })
    })
</script>




<!--  #######################################################     OpsDashboardAction.php       ##############################################################-->

<?php
class OpsDashboardAction
{

    public function init()
    {
        $self = new self;
        add_action('admin_post_save_guest', array($self, 'saveGuest'));
    }

    public function saveGuest()
    {
        if (!isset($_POST['saveGuest']) || !wp_verify_nonce($_POST['saveGuest'], 'saveGuest-nonce')) {
            die("You are not allowed to submit data.");
        }
            // echo "<pre>";
            // print_r($_POST);
            // echo"</pre>"; die();

        $OpsAttendee = new OpsAttendee();
        $data =[];
        $id           = intval($_POST['id']);
        $data['user_id'] = $_POST['attendee_ids'];
        $data['first_name'] = $_POST['guest_first_name'];
        $data['guest_last_name'] = $_POST['last_name'];
        $data['sex'] = $_POST['gender'];

        $OpsAttendee->updateOrInsert($data, ['id' => $id]);
            echo "<pre>";
            print_r($data);
            echo"</pre>";
                
        $_SESSION['type']    = 'success';
        $_SESSION['message'] = 'Successfully saved Guest'; 

        wp_redirect($_POST['_wp_http_referer']);
        exit();
    }

}
