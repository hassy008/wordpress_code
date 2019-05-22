<?php  
	$OpsAttendee = new OpsAttendee();
	$dietary_restrictions = $OpsAttendee->get(['is_dietary_restrictions' => '1']);
?>

<div class="form-group text-right">
	<a href="" class="export-btn"><span class="fa fa-file-excel-o"></span> Export As CSV</a>
	<a href="" class="export-btn"><span class="fa fa-file-pdf-o"></span> Export As PDF</a>
	<div class="export-btn" data-toggle="modal" data-target="#sentByEmail"><span><i class="fa fa-envelope-o"></i></span> Sent By Email</div>
</div>
<div class="dietary-restriction-wrapper">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Member First Name</th>
				<th>Member Last Name</th>
				<th>Guest First Name</th>
				<th>Guest Last</th>
				<th>Dietary Restriction</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($dietary_restrictions as $dietary_restriction) : 
					// echo "<pre>";
				 //    print_r( get_user_meta( $dietary_restriction->user_id,'first_name',ture) );
				 //    echo"</pre>";
				?>
			<tr>
				<!-- if $dietary_restriction->type == 'name' ? then have first_name -->
				<td><?= $dietary_restriction->type == 'Member' ? $dietary_restriction->first_name : ($dietary_restriction->type == 'Guest' ? get_user_meta( $dietary_restriction->user_id,'first_name',ture) : '') ?></td><!--if guest has name then put Member name from user_id --> 
				<td><?= $dietary_restriction->type == 'Member' ? $dietary_restriction->last_name : ($dietary_restriction->type == 'Guest' ? get_user_meta( $dietary_restriction->user_id,'last_name',ture) : '') ; ?></td>
				<td><?= $dietary_restriction->type == 'Guest' ? $dietary_restriction->first_name : '-' ; ?></td>
				<td><?= $dietary_restriction->type == 'Guest' ? $dietary_restriction->last_name : '-' ; ?></td>
				<td><?= $dietary_restriction->dietary_restrictions; ?></td>
			</tr>
		<?php endforeach ; ?>
		</tbody>
	</table>
</div>

<!-- Modal Start-->
<div class="modal fade" id="sentByEmail" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Sent Email</span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Sent Email</label>
					<input type="email" class="form-control">
				</div>
				<div class="text-center">
					<button class="btn btn-danger">Sent</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal end-->