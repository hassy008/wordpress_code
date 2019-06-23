<?php
$order = esc_sql($_GET['order']);
$orderBy = esc_sql($_GET['orderBy']);
$search_col = esc_sql($_GET['search_col']);
$search_term = esc_sql($_GET['search_term']);

$OpsEarlyBirdBooking = new OpsEarlyBirdBooking();
$EarlyBirdBooking = $OpsEarlyBirdBooking->getAllByStatus($search_col, $search_term, $orderBy, $order);
// echo "<pre>";
// print_r($EarlyBirdBooking);
// echo "</pre>";

	$delete = $OpsEarlyBirdBooking->delete(['id' => $_GET['delete']]);
?>
<script>
	// document.getElementById('early-bird-registrant-filter').setAttribute('action', 'somevalue');
</script>
<div class="early-bird-content">
	<form class="form-inline" action="" style="float: right; margin-bottom: 15px" id="early-bird-registrant-filter">
		<div class="form-group">
			<div class="select-wrapper">
				<select class="select-style form-control" name="search_col">
					<option value="first_name" <?= $search_col == 'first_name' ? ' selected' : '' ?>>First Name</option>
					<option value="last_name" <?= $search_col == 'last_name' ? ' selected' : '' ?>>Last Name</option>
					<option value="email" <?= $search_col == 'email' ? ' selected' : '' ?>>Email</option>
					<option value="phone" <?= $search_col == 'phone' ? ' selected' : '' ?>>Phone</option>
					<option value="country" <?= $search_col == 'country' ? ' selected' : '' ?>>Country</option>
					<option value="no_of_person" <?= $search_col == 'no_of_person' ? ' selected' : '' ?>>Number of Person</option>
					<option value="amount" <?= $search_col == 'amount' ? ' selected' : '' ?>>Deposit Amount</option>
					<option value="status" <?= $search_col == 'status' ? ' selected' : '' ?>>Payment Status</option>
					<option value="transaction_id" <?= $search_col == 'transaction_id' ? ' selected' : '' ?>>Transaction ID</option>
					<option value="created_at" <?= $search_col == 'created_at' ? ' selected' : '' ?>>Creadted At</option>
					<option value="modified_at" <?= $search_col == 'modified_at' ? ' selected' : '' ?>>Modified At</option>
				</select>
			</div>
		</div>
	  <div class="form-group">
	    <input type="text" class="form-control" name="search_term" value="<?= $search_term ?>">
	  </div>
	  <button type="submit" class="btn btn-danger early-bird-registrant">Search</button>
	</form>
	<table class="table table-bordered table-striped early-birds-registrant-table">
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Country</th>
				<th>Number of Person</th>
				<th>Deposit Amount</th>
				<th>Payment Status</th>
				<th>Transaction ID</th>
				<th>Creadted At</th>
				<th>Modified At</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($EarlyBirdBooking as $book) {
			?>
			<tr>
				<td><?=$book->first_name;?></td>
				<td><?=$book->last_name;?></td>
				<td><?=$book->email;?></td>
				<td><?=$book->phone;?></td>
				<td><?=$book->country;?></td>
				<td><?=$book->no_of_person;?></td>
				<td>$<?=$book->amount;?></td>
				<td><span class="label label-<?= $book->status == 'completed' ? 'success' : 'warning' ?>"><?= ucwords($book->status); ?></span></td>
				<td><?=$book->transaction_id;?></td>
				<td><?=$book->created_at;?>  </td>
          		<td><?=$book->modified_at;?> </td>
				<td>
					<!-- <a class="view-details-link" href="/early-bird-registrantion-details"><i class="fa fa-eye"></i></a> -->

					<a href="" class="text-danger delete-early-bird" data-early_bird_id='<?php echo ($book->id); ?>'><i class="fa fa-trash"></i></a>
					<a  class="view-details-link"  href="<?php echo home_url('/early-bird-registrantion-details'); ?>?view=<?php echo ($book->id); ?>"><i class="fa fa-eye"></i></a>

					<a href="<?php echo home_url('/early-bird-registrantion-details'); ?>?view=<?php echo ($book->id); ?>&edit=1"><span class="edit-row"><i class="fa fa-edit"></i></span></a>
					<!-- <a href="<?php echo home_url('dashboard/?section=early-birds-registrant');?>&delete=<?php echo ($book->id);?>"><span class="del-row"><i class="fa fa-trash"></i></span></a> -->

					<span class="delete-booking del-row" data-id="<?=$book->id;?>">
						<!-- <i class="fa fa-trash"></i> -->
					</span>
				</td>
			</tr>
		<?php }?>

		</tbody>
	</table>
</div>





###########################################################################################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
#######################################################        early-bird-registrant-details.php     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
###########################################################################################################################################################


<?php
	//for edit
	$isEdit = false;
	if (isset($_GET['edit']) && $_GET['edit']==1) {
		$isEdit = true;
	}

$OpsEarlyBirdBooking = new OpsEarlyBirdBooking();
$OpsNote = new OpsNote;
$EarlyBirdBooking = $OpsEarlyBirdBooking->getRow(['id' => $_GET['view']]);
$user             = get_user_by('ID', $EarlyBirdBooking->user_id);          // get users info exg. frist_name/last_name
$notes  = $OpsNote->get(['ref' => $_GET['view'], 'type' => 'early_bird']);
?>
<div class="bootstrap-wrapper">
	<?php if (isset($_SESSION['message'])) : ?>
	<div class="alert alert-<?= $_SESSION['type'] ?>">
		<?= $_SESSION['message'] ?>
	</div>
	<?php endif; unset($_SESSION['message']); unset($_SESSION['type']);  ?>
	<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
		<input type="hidden" name="action" value="update_early_bird_entry">
		<input type="hidden" name="id" value="<?= $_GET['view'] ?>">
		<?php wp_nonce_field('updateEarlyBirdEntry-nonce', 'updateEarlyBirdEntry');?>
		<div class="early-bird-reg-details">
			<div class="single-section-wrapper">
				<label for="" class="title-name">First Name</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$user->first_name;?></span>
					<input type="text" class="form-control details-input-control" name="first_name" value="<?=$user->first_name;?>">
				</div>
			</div>
			<div class="single-section-wrapper">
				<label for="" class="title-name">Last Name</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$user->last_name;?></span>
					<input type="text" class="form-control details-input-control" name="last_name" value="<?=$user->last_name;?>">
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">Role in club</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->role_in_club;?></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$EarlyBirdBooking->role_in_club;?>" name="role_in_club" >
							<?php foreach (OpsSelectOption::RoleInClub() as $role_club): ?>
							<option <?= $role_club == $EarlyBirdBooking->role_in_club ? "selected" : "";?>> <?= $role_club; ?> </option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?> ">
				<label for="" class="title-name">Club</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->club ?></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$EarlyBirdBooking->club;?>" name="club" >ClubName
							<?php foreach (OpsSelectOption::ClubName() as $clubName): ?>
							<option <?=$clubName == $EarlyBirdBooking->club ? "selected" : "";?>><?=$clubName;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?> ">
				<label for="" class="title-name">Country</label>
				<div class="val-input-wrapper">
					<span class="value"> <?=$EarlyBirdBooking->country;?></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$EarlyBirdBooking->country;?>" name="country">
							<?php foreach (OpsSelectOption::CountryName() as $country): ?>
							<option <?=$country == $EarlyBirdBooking->country ? "selected" : "";?>><?=$country;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">Phone</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->phone;?></span>
					<input type="text" class="form-control details-input-control" value="<?=$EarlyBirdBooking->phone;?>" name="phone">
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">Email</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->email;?></span>
					<input type="text" class="form-control details-input-control" value="<?=$EarlyBirdBooking->email;?>" name="email">
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">Number Of Person</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->no_of_person;?></span>
					<input type="text" class="form-control details-input-control" value="<?=$EarlyBirdBooking->no_of_person;?>" name="no_of_person">
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">I make a deposit</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->make_a_deposit;?></span>
					<div class="select-wrapper details-input-control">
						<select class="select-style form-control details-input-control" value="<?=$EarlyBirdBooking->make_a_deposit;?>" name="make_a_deposit">
							<option></option>
							<option <?= ($EarlyBirdBooking->make_a_deposit=='For myself only' ? ' selected' : '') ?>>For myself only</option>
							<option <?= ($EarlyBirdBooking->make_a_deposit=='For myself and a companion' ? ' selected' : '') ?>>For myself and a companion</option>
							<option <?= ($EarlyBirdBooking->make_a_deposit=='For a Club or National Committee' ? ' selected' : '') ?>>For a Club or National Committee</option>
						</select>
					</div>
				</div>
			</div>
			<div class="single-section-wrapper <?= ($isEdit ? ' active' : '') ?>">
				<label for="" class="title-name">Notes</label>
				<div class="val-input-wrapper">
					<span class="value"><?=$EarlyBirdBooking->notes;?></span>
					<textarea name="notes" id="" class="form-control details-input-control"><?=$EarlyBirdBooking->notes;?></textarea>
				</div>
			</div>
		</div>
		<?php if($isEdit) : ?>
		<div class="form-group">
			<button type="submit" class="btn btn-danger pull-right">UPDATE</button>
			
		</div>
	</form>
	<!-- <button type="submit" class="btn btn-success">UPDATE</button> -->
		<?php endif; ?>


	<div style="margin-bottom: 30px; margin-top: 30px">
		<?php if (isset($notes)) : ?>
		<?php foreach ($notes as $note) : ?>
		<div class="alert alert-success" data-note_id="<?= $note->id ?>">
			<a href="#" class="close delete-note" title="DELETE">&times;</a>
			<?= $note->content;  ?>
		</div>
		<?php endforeach;  ?>
		<?php endif;  ?>
		<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
			<input type="hidden" name="action" value="add_notes">
			<input type="hidden" name="type" value="early_bird">
			<input type="hidden" name="ref" value="<?= intval($_GET['view']) ?>">
			<?php wp_nonce_field('addNotes-nonce', 'addNotes');?>
			<div class="form-group">
				<label for="note">Add Note:</label>
				<textarea class="form-control" rows="5" id="note" name="content"></textarea>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-danger hide-btn">SAVE</button>
			</div>
		</form>
	</div>
</div>







###########################################################################################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
#######################################################        class-OpsEarlyBirdBooking.php     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
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

	public function getAllByStatus($search_col = '', $search_term = '', $orderBy = '', $order = '')
	{
		$table_cols = [
			'first_name'  => 'first_name',
			'last_name'  => 'last_name',
			'email'  => 'e.email',
			'phone'  => 'e.phone',
			'country'  => 'e.country',
			'no_of_person'  => 'e.no_of_person',
			'amount'  => 'e.amount',
			'status'  => 'p.status',
			'transaction_id'  => 'p.transaction_id',
			'created_at'  => 'e.created_at',
			'modified_at'  => 'e.modified_at',
		]; 

		$orderBySyntax = '';
		if (!empty($orderBy)) {
			if (empty($order)) {
				$order = 'ASC';
			}
			$orderBySyntax = "ORDER BY {$table_cols[$orderBy]} {$order}";
		} else {
			$orderBySyntax = "ORDER BY e.created_at DESC";
		}

		$meta_query = "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'first_name' AND $this->usermeta.user_id = p.user_id) AS first_name ,";		
		$meta_query .= "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'last_name' AND $this->usermeta.user_id = p.user_id) AS last_name";

		$fields = "e.*, p.status, p.transaction_id, $meta_query";

		$where  = "";

		if (!empty($search_col)) {
			$where = "WHERE {$table_cols[$search_col]} LIKE '%$search_term%'";
		}

		$query = "SELECT $fields FROM $this->table AS e 
		LEFT JOIN $this->early_bird_payment_table AS ep ON ep.early_bird_booking_id = e.id 
		LEFT JOIN $this->payments_table AS p ON ep.payment_id = p.id
		{$where}
		{$orderBySyntax}";

		return $this->db->get_results($query);
	}

	public function generateToken() {
		return bin2hex(openssl_random_pseudo_bytes(32));
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

?>



###########################################################################################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
#######################################################        script.js     ############################################################################################
############################################################## 										#############################################################################################
###########################################################################################################################################################
###########################################################################################################################################################
###########################################################################################################################################################


	<!--script.js-->
	<script>
	    /*members search */
        $('.early-bird-registrant').click(function(e) {
        e.preventDefault();
        let search_col = $('[name="search_col"]').val();
        let search_term = $('[name="search_term"]').val();

        let urlParams = new URLSearchParams(window.location.search);
        urlParams.set("search_col", search_col);
        urlParams.set("search_term", search_term);
        console.log(urlParams.toString());

        window.location.href = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    })

     </script>   