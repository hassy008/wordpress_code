<?php 
	 // $search_term = sanitize_text_field( stripslashes( $_GET['search_term']));
$search_term = esc_sql( $_GET['search_term'] );
$search_col = esc_sql( $_GET['search_col'] );

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

?>

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








	<!--script.js-->
	<script>
	    /*members search */
        $('.member-search').click(function(e) {
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
