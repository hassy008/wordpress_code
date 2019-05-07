<?php 
	######### get data from users & user_meta table by WP_User_Query()
	$args = array(
		'meta_key'     => 'user_level',
		'meta_value'   => '0',
		'meta_compare' => '!=',
		'blog_id'      => 0
	)
	$wp_user_query = new WP_User_Query( $args );
	$members = $wp_user_query->get_results();

?>

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
				 //    print_r( get_user_meta( $member->ID) );
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

					<a href="<?php echo home_url('/dashboard/?section=members&action=edit'); ?>&user_id=<?php echo ($member->ID); ?>&edit=1"><span class="edit-row"><i class="fa fa-edit"></i></span></a>
					
					<!-- <span class="delete-booking del-row" data-id="<?=$book->id;?>"> -->
						<!-- <i class="fa fa-trash"></i> -->

				</td>
			</tr>
		<?php } ?>

		</tbody>
	</table>