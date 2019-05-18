<?php  
	$search_col = esc_sql($_GET['search_col']);
	$search_term = esc_sql($_GET['search_term']);
	
	#####pagination 
	$total = null;
	$urlPattern ='/dashboard/?section=guests&pg=(:num)';
	$rowPerPage = 40;
	$currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
	$offset = ($currentPage - 1) * $rowPerPage;

	#######pagination end

	//$members = $wp_user_query->get_results();

	$OpsAttendee = new OpsAttendee();

	$guests = $OpsAttendee->getGuest($search_col, $search_term, $rowPerPage, $offset);
	$totalCount = $OpsAttendee->getGuest($search_col, $search_term, $rowPerPage, $offset, '', '', true);

	$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);

	//get all guest_name 
	$guests_name = $OpsAttendee->get(['type' => 'Guest']);

?>

<div class="guest-table-wrapper">
	<div class="search-frm-wrapper">
		<form class="form-inline" action="/dashboard/?section=guests" style="margin-bottom: 15px">
			<div class="form-group">
				<div class="select-wrapper">
					<select class="select-style form-control" name="search_col">
						<option value="">Select Column</option>
						<option value="m_first_name" <?= $search_col == 'm_first_name' ? ' selected' : '' ?>>Member First Name</option>
						<option value="m_last_name" <?= $search_col == 'm_last_name' ? ' selected' : '' ?>>Member Last Name</option>
						<option value="g_first_name" <?= $search_col == 'g_first_name' ? ' selected' : '' ?>>Guest First Name</option>
						<option value="g_last_name" <?= $search_col == 'g_last_name' ? ' selected' : '' ?>>Guest Last Name</option>
						<option value="gender" <?= $search_col == 'gender' ? ' selected' : '' ?>>Gender</option>
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
				<td><?= $guest->m_first_name ?></td>	
				<td><?= $guest->m_last_name ?></td>
				<td><?= $guest->first_name ;?></td>
				<td><?= $guest->last_name ;?></td>
				<td><?= $guest->sex ;?></td>
				<td class="action">
					<span class="edit-guest" data-toggle="modal" data-target="#addGuest2" data-id="<?= $guest->id; ?>"><i class="fa fa-edit"></i></span>
					<span class="guest-delete" data-id="<?= $guest->id; ?>"><i class="fa fa-trash"></i></span>
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
								<?php foreach ($guests_name as $guest_name) { ?>
									<option value="<?= $guest_name->user_id?>"><?= get_user_meta($guest_name->user_id,'first_name',ture).' '.get_user_meta($guest_name->user_id,'last_name',ture) ?></option>
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
					<button class="btn btn-danger" type="submit">Save</button>
				</div>
			  </form>
			</div>
		</div>
	</div>
</div>
<!-- Modal end-->



<!--
########################################################################################################################################################################
########################################################################################################################################################################
########################################################################################################################################################################
############################################################           script.js (for search)     		################################################################
-->

<script>
    $('.dashboard-guest-search').click(function(e) {
        e.preventDefault();
        let search_col = $('[name="search_col"]').val();
        let search_term = $('[name="search_term"]').val();

        let urlParams = new URLSearchParams(window.location.search);
        urlParams.set("search_col", search_col);
        urlParams.set("search_term", search_term);

        window.location.href = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    })

</script>

<!--
########################################################################################################################################################################
########################################################################################################################################################################
########################################################################################################################################################################
############################################################           classOpsAttendee.php      		################################################################
-->
<?php

class OpsAttendee extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->prefix . "attendees";
        $this->usermeta = $this->db->prefix . "usermeta";
    }
    
    public function getAllSoftDelete($where, $limit = 0, $offset = 0, $order_by = null)
    {
        $query = "";

        if($limit > 0){
            $query = "LIMIT $limit OFFSET $offset";
        }

        if($order_by != null){
            $query .= "ORDER BY $order_by";
        }

        $where_query = "";

        $and = '';
        $cnt = 0;
        foreach ($where as $key => $value){
            if ($cnt > 0) $and = " AND";

            $where_query .= "$and $key = '$value' ";
            $cnt++;
        }

        return $this->db->get_results("SELECT * FROM $this->table WHERE $where_query AND deleted_at IS NULL $query");
    }
 
    public function getGuest($search_col = '', $search_term = '', $limit = 40, $offset = 0, $orderBy = '', $order = '', $is_sum= false)
    {
    	//for attendee table 
        $table_cols = [
            'g_first_name'  => 'a.first_name',
            'g_last_name'  => 'a.last_name',
            'gender'  => 'a.sex',
        ]; 

        //usermeta tbale
        $user_meta = [
            'm_first_name'  => 'first_name',
            'm_last_name'  => 'last_name',
        ];

        //Order By 
        $orderBySyntax = '';

        if (!empty($orderBy)) {
            if (empty($order)) {
                $order = 'ASC';
            }
            $orderBySyntax = "ORDER BY {$table_cols[$orderBy]} {$order}";
        } else {
            $orderBySyntax = "ORDER BY a.created_at DESC";
        }

        //$meta_query for get usermeta f_name/l_name
        $meta_query = "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'first_name' AND $this->usermeta.user_id = a.user_id) AS m_first_name ,";     
        $meta_query .= "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'last_name' AND $this->usermeta.user_id = a.user_id) AS m_last_name";

        $fields = "a.*,  $meta_query"; //select col from table

        $where  = "WHERE type = 'Guest' "; // define the type 

        //logic for write attendee table
        if (!empty($search_col) && isset($table_cols[$search_col])) {
            $where .= "AND {$table_cols[$search_col]} LIKE '%$search_term%'";
        }
        //logic for write usermeta table
        if (!empty($search_col) && isset($user_meta[$search_col])) {
            $where .= "AND (SELECT meta_value FROM $this->usermeta WHERE meta_key = '$user_meta[$search_col]' AND $this->usermeta.user_id = a.user_id) LIKE '%$search_term%'";
        }

        if($is_sum){
            $fields = "COUNT(*)"; //COUNT() function returns the number of rows in a table satisfying the criteria specified 
        }

        $query = "SELECT $fields FROM $this->table AS a 
        {$where}
        {$orderBySyntax} LIMIT $offset, $limit";

        if($is_sum){
            return $this->db->get_var($query);
        }

        return $this->db->get_results($query);
    }

}



