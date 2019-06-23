<?php  

	$OpsProgressTracker = new OpsProgressTracker();
##getRow
    $user_id = get_current_user_id();
    $user_info = get_currentuserinfo(); //get user info

    $progress_tracker =  $OpsProgressTracker->getRow(['user_id' => $user_id ]);

    $data = unserialize($progress_tracker->details);
  // 		echo "<pre>";
		// print_r($data);
		// echo"</pre>";

?>

<div class="bootstrap-wrapper">
	<div class="progress-tracker-form">

		<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
			<input type="hidden" name="action" value="progress_tracker">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="user_name" value="<?= $user_info->user_login; ?>">
            <input type="hidden" name="is_final_submission" class="is_final_submission">

			<?php wp_nonce_field('progressTracker-nonce', 'progressTracker');?>

			<table class="table table-bordered">

				<!-- logged in user can only get access Beginning -->
				<?php
				   // $user_data = wp_get_current_user();
				    if (!is_user_logged_in()) : ?>
				        <div class="well" style="margin-top: 20px">
				            <span class="text-danger">You have to login to view the page. <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Click here to login</a>.</span> 
				        </div>
				<?php return false; endif;  ?>
				<!-- logged in user can only get access End -->

				<tbody>
					<tr>
						<td colspan="6" class="gray-bg" style="text-align: center; font-size: 18px; font-weight: bold;">PROGRESS TRACKER</td>
					</tr>
					<tr>
						<td class="name-input-td" colspan="3"><span>Name:</span><input type="text" class="name-table-input-control" style="width:90%;" name="name" 
						
							value="<?= (empty($data['name'])) ? $user_info->user_firstname.' '.$user_info->user_lastname : $data['name'] ; 
									// if (empty($data['name'])) {
									// 	echo $user_info->user_login;
									// 	// echo $user_info->user_firstname.' '.$user_info->user_lastname;
									// }else {
									// 	echo $data['name'];
									// }
								?>">

						</td>
						
						<td class="name-input-td" colspan="3"><span>Start Date:</span><input type="text" class="name-table-input-control datepicker" name="date" value="<?= $data['date']; ?>"></td>
					</tr>
					<tr>
						<td colspan="6">Enter data for markers you’d like to track.You can add other markers in spaces provided, if desired.</td>
					</tr>
					<tr>
						<td></td>
						<td class="gray-bg font-bold">Start</td>
						<td class="font-bold">Week 1</td>
						<td class="gray-bg font-bold">Week 2</td>
						<td class="font-bold">Week 3</td>
						<td class="gray-bg font-bold">Week 4</td>
						<td class="font-bold">Change</td>
						<td class="gray-bg font-bold">% Change</td>
					</tr>
					<tr>
						<td class="gray-bg font-bold">MEASUREMENTS</td>
						<td class="gray-bg font-bold" colspan="8">Waist is important for health tracking.</td>
					</tr>
					<tr>
					    <td>Bust/Chest</td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[bust/chest][start]" value="<?= $data['data']['bust/chest']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[bust/chest][week1]" value="<?= $data['data']['bust/chest']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[bust/chest][week2]" value="<?= $data['data']['bust/chest']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[bust/chest][week3]" value="<?= $data['data']['bust/chest']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[bust/chest][week4]" value="<?= $data['data']['bust/chest']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[bust/chest][start_change]" value="<?= $data['data']['bust/chest']['start_change']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[bust/chest][change]" value="<?= $data['data']['bust/chest']['change']; ?>"></td>
					</tr>
					<tr>
					    <td>Waist</td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[waist][start]" value="<?= $data['data']['waist']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[waist][week1]" value="<?= $data['data']['waist']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[waist][week2]" value="<?= $data['data']['waist']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[waist][week3]" value="<?= $data['data']['waist']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[waist][week4]" value="<?= $data['data']['waist']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[waist][start_change]" value="<?= $data['data']['waist']['start_change']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[waist][change]" value="<?= $data['data']['waist']['change']; ?>" ></td>
					</tr>
					<tr>
					    <td>Hips/Gut/Butt</td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[hips/gut/butt][start]" value="<?= $data['data']['hips/gut/butt']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[hips/gut/butt][week1]" value="<?= $data['data']['hips/gut/butt']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[hips/gut/butt][week2]" value="<?= $data['data']['hips/gut/butt']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[hips/gut/butt][week3]" value="<?= $data['data']['hips/gut/butt']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[hips/gut/butt][week4]" value="<?= $data['data']['hips/gut/butt']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[hips/gut/butt][start_change]" value="<?= $data['data']['hips/gut/butt']['start_change']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[hips/gut/butt][change]" value="<?= $data['data']['hips/gut/butt']['change']; ?>"></td>
					</tr>
					<tr>
					    <td>Weight (pounds)</td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[weight][start]" value="<?= $data['data']['weight']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[weight][week1]" value="<?= $data['data']['weight']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[weight][week2]" value="<?= $data['data']['weight']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[weight][week3]" value="<?= $data['data']['weight']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[weight][week4]" value="<?= $data['data']['weight']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[weight][start_change]" value="<?= $data['data']['bust/chest']['start_change']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[weight][change]" value="<?= $data['data']['weight']['change']; ?>"></td>
					</tr>
					<tr>
					    <td>Clothing Size</td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[clothing_size][start]" value="<?= $data['data']['clothing_size']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[clothing_size][week1]" value="<?= $data['data']['clothing_size']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[clothing_size][week2]" value="<?= $data['data']['clothing_size']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[clothing_size][week3]" value="<?= $data['data']['clothing_size']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[clothing_size][week4]" value="<?= $data['data']['clothing_size']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[clothing_size][start_change]" value="<?= $data['data']['clothing_size']['start_change']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[clothing_size][change]" value="<?= $data['data']['clothing_size']['change']; ?>"></td>
					</tr>
					<tr>
					    <td class="input-td"><input type="text" class="table-input-control" name="data[label1][name]" value="<?= $data['data']['label1']['name']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[label1][start]" value="<?= $data['data']['label1']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[label1][week1]" value="<?= $data['data']['label1']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[label1][week2]" value="<?= $data['data']['label1']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[label1][week3]" value="<?= $data['data']['label1']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[label1][week4]" value="<?= $data['data']['label1']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[label1][start_change]" value="<?= $data['data']['label1']['start_change']; ?>"></td>    
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[label1][change]" value="<?= $data['data']['label1']['change']; ?>"></td>
					</tr>
					<tr>
					    <td class="input-td"><input type="text" class="table-input-control" name="data[label2][name]" value="<?= $data['data']['label2']['name']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[label2][start]" value="<?= $data['data']['label2']['start']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w1" name="data[label2][week1]" value="<?= $data['data']['label2']['week1']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w2" name="data[label2][week2]" value="<?= $data['data']['label2']['week2']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control w3" name="data[label2][week3]" value="<?= $data['data']['label2']['week3']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control gray-bg w4" name="data[label2][week4]" value="<?= $data['data']['label2']['week4']; ?>"></td>
					    <td class="input-td"><input type="text" class="table-input-control start_change" name="data[label2][start_change]" value="<?= $data['data']['label2']['start_change']; ?>"></td>    
					    <td class="input-td"><input type="text" class="table-input-control gray-bg progress-track" name="data[label2][change]" value="<?= $data['data']['label2']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="gray-bg font-bold" colspan="8">SYMPTOMS: Use scale of 0 for lowest, to 10 for highest</td>
					</tr>
					<tr>
						<td class="gray-bg font-bold" colspan="8">HIGH numbers on these markers is GOOD; 0 is awesome; 10 is scary.</td>
					</tr>
					<tr>
						<td class="font-bold">Energy Level</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[energy_level][start]" value="<?= $data['data']['energy_level']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[energy_level][week1]" value="<?= $data['data']['energy_level']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[energy_level][week2]" value="<?= $data['data']['energy_level']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[energy_level][week3]" value="<?= $data['data']['energy_level']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[energy_level][week4]" value="<?= $data['data']['energy_level']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[energy_level][start_change]" value="<?= $data['data']['energy_level']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[energy_level][change]" value="<?= $data['data']['energy_level']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Sleep Quality</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[sleep_quality][start]" value="<?= $data['data']['sleep_quality']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[sleep_quality][week1]" value="<?= $data['data']['sleep_quality']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[sleep_quality][week2]" value="<?= $data['data']['sleep_quality']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[sleep_quality][week3]" value="<?= $data['data']['sleep_quality']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[sleep_quality][week4]" value="<?= $data['data']['sleep_quality']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[sleep_quality][start_change]" value="<?= $data['data']['sleep_quality']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[sleep_quality][change]" value="<?= $data['data']['sleep_quality']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Sexual Desire</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[sexual_desire][start]" value="<?= $data['data']['sexual_desire']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[sexual_desire][week1]" value="<?= $data['data']['sexual_desire']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[sexual_desire][week2]" value="<?= $data['data']['sexual_desire']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[sexual_desire][week3]" value="<?= $data['data']['sexual_desire']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[sexual_desire][week4]" value="<?= $data['data']['sexual_desire']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[sexual_desire][start_change]" value="<?= $data['data']['sexual_desire']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[sexual_desire][change]" value="<?= $data['data']['sexual_desire']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Sexual Stamina</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[sexual_stamina][start]" value="<?= $data['data']['sexual_stamina']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[sexual_stamina][week1]" value="<?= $data['data']['sexual_stamina']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[sexual_stamina][week2]" value="<?= $data['data']['sexual_stamina']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[sexual_stamina][week3]" value="<?= $data['data']['sexual_stamina']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[sexual_stamina][week4]" value="<?= $data['data']['sexual_stamina']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[sexual_stamina][start_change]" value="<?= $data['data']['sexual_stamina']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[sexual_stamina][change]" value="<?= $data['data']['sexual_stamina']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label3][name]" value="<?= $data['data']['label3']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[label3][start]" value="<?= $data['data']['label3']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[label3][week1]" value="<?= $data['data']['label3']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[label3][week2]" value="<?= $data['data']['label3']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[label3][week3]" value="<?= $data['data']['label3']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[label3][week4]" value="<?= $data['data']['label3']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[label3][start_change]" value="<?= $data['data']['label3']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text"class="table-input-control progress-track" name="data[label3][change]" value="<?= $data['data']['label3']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label4][name]" value="<?= $data['data']['label4']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[label4][start]" value="<?= $data['data']['label4']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[label4][week1]" value="<?= $data['data']['label4']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[label4][week2]" value="<?= $data['data']['label4']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[label4][week3]" value="<?= $data['data']['label4']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[label4][week4]" value="<?= $data['data']['label4']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[label4][start_change]" value="<?= $data['data']['label4']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label4][change]" value="<?= $data['data']['label4']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label5][name]" value="<?= $data['data']['label5']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[label5][start]" value="<?= $data['data']['label5']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[label5][week1]" value="<?= $data['data']['label5']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[label5][week2]" value="<?= $data['data']['label5']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[label5][week3]" value="<?= $data['data']['label5']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[label5][week4]" value="<?= $data['data']['label5']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[label5][start_change]" value="<?= $data['data']['label5']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label5][change]" value="<?= $data['data']['label5']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="gray-bg font-bold" colspan="8">LOW numbers on the following markers is GOOD; 0 is awesome, 10 is scary</td>
					</tr>
					<tr>
						<td class="font-bold">Compulsive eating</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[compulsive_eating][start]" value="<?= $data['data']['compulsive_eating']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[compulsive_eating][week1]" value="<?= $data['data']['compulsive_eating']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[compulsive_eating][week2]" value="<?= $data['data']['compulsive_eating']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[compulsive_eating][week3]" value="<?= $data['data']['compulsive_eating']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[compulsive_eating][week4]" value="<?= $data['data']['compulsive_eating']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[compulsive_eating][start_change]" value="<?= $data['data']['compulsive_eating']['start_change']; ?>"></td>					
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[compulsive_eating][change]" value="<?= $data['data']['compulsive_eating']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Craving for:</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[craving][start]" value="<?= $data['data']['craving']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[craving][week1]" value="<?= $data['data']['craving']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[craving][week2]" value="<?= $data['data']['craving']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[craving][week3]" value="<?= $data['data']['craving']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[craving][week4]" value="<?= $data['data']['craving']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[craving][start_change]" value="<?= $data['data']['craving']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[craving][change]" value="<?= $data['data']['craving']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Gas/Bloating</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[gas/bloating][start]" value="<?= $data['data']['gas/bloating']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[gas/bloating][week1]" value="<?= $data['data']['gas/bloating']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[gas/bloating][week2]" value="<?= $data['data']['gas/bloating']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[gas/bloating][week3]" value="<?= $data['data']['gas/bloating']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[gas/bloating][week4]" value="<?= $data['data']['gas/bloating']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[gas/bloating][start_change]" value="<?= $data['data']['gas/bloating']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[gas/bloating][change]" value="<?= $data['data']['gas/bloating']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Constipation</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[constipation][start]" value="<?= $data['data']['constipation']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[constipation][week1]" value="<?= $data['data']['constipation']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[constipation][week2]" value="<?= $data['data']['constipation']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[constipation][week3]" value="<?= $data['data']['constipation']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[constipation][week4]" value="<?= $data['data']['constipation']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[constipation][start_change]" value="<?= $data['data']['constipation']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[constipation][change]" value="<?= $data['data']['constipation']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Diarrhea</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[diarrhea][start]" value="<?= $data['data']['diarrhea']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[diarrhea][week1]" value="<?= $data['data']['diarrhea']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[diarrhea][week2]" value="<?= $data['data']['diarrhea']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[diarrhea][week3]" value="<?= $data['data']['diarrhea']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[diarrhea][week4]" value="<?= $data['data']['diarrhea']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[diarrhea][start_change]" value="<?= $data['data']['diarrhea']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[diarrhea][change]" value="<?= $data['data']['diarrhea']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="gray-bg" colspan="8"></td>
					</tr>
					<tr>
						<td class="font-bold">Depression</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[depression][start]" value="<?= $data['data']['depression']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[depression][week1]" value="<?= $data['data']['depression']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[depression][week2]" value="<?= $data['data']['depression']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[depression][week3]" value="<?= $data['data']['depression']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[depression][week4]" value="<?= $data['data']['depression']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[depression][start_change]" value="<?= $data['data']['depression']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[depression][change]" value="<?= $data['data']['depression']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Irritability/mood swings</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[irritability/mood_swings][start]" value="<?= $data['data']['irritability/mood_swings']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[irritability/mood_swings][week1]" value="<?= $data['data']['irritability/mood_swings']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[irritability/mood_swings][week2]" value="<?= $data['data']['irritability/mood_swings']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[irritability/mood_swings][week3]" value="<?= $data['data']['irritability/mood_swings']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[irritability/mood_swings][week4]" value="<?= $data['data']['irritability/mood_swings']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[irritability/mood_swings][start_change]" value="<?= $data['data']['irritability/mood_swings']['start_change']; ?>"></td>		
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[irritability/mood_swings][change]" value="<?= $data['data']['irritability/mood_swings']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Pain</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[pain][start]" value="<?= $data['data']['pain']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[pain][week1]" value="<?= $data['data']['pain']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[pain][week2]" value="<?= $data['data']['pain']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[pain][week3]" value="<?= $data['data']['pain']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[pain][week4]" value="<?= $data['data']['pain']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[pain][start_change]" value="<?= $data['data']['pain']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[pain][change]" value="<?= $data['data']['pain']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Stiffness</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[stiffness][start]" value="<?= $data['data']['stiffness']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[stiffness][week1]" value="<?= $data['data']['stiffness']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[stiffness][week2]" value="<?= $data['data']['stiffness']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[stiffness][week3]" value="<?= $data['data']['stiffness']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[stiffness][week4]" value="<?= $data['data']['stiffness']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[stiffness][start_change]" value="<?= $data['data']['stiffness']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[stiffness][change]" value="<?= $data['data']['stiffness']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Swelling</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[swelling][start]" value="<?= $data['data']['swelling']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[swelling][week1]" value="<?= $data['data']['swelling']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[swelling][week2]" value="<?= $data['data']['swelling']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[swelling][week3]" value="<?= $data['data']['swelling']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[swelling][week4]" value="<?= $data['data']['swelling']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[swelling][start_change]" value="<?= $data['data']['swelling']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[swelling][change]" value="<?= $data['data']['swelling']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Skin dryness/wrinkles</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[skin_dryness/wrinkles][start]" value="<?= $data['data']['skin_dryness/wrinkles']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[skin_dryness/wrinkles][week1]" value="<?= $data['data']['skin_dryness/wrinkles']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[skin_dryness/wrinkles][week2]" value="<?= $data['data']['skin_dryness/wrinkles']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[skin_dryness/wrinkles][week3]" value="<?= $data['data']['skin_dryness/wrinkles']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[skin_dryness/wrinkles][week4]" value="<?= $data['data']['skin_dryness/wrinkles']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[skin_dryness/wrinkles][start_change]" value="<?= $data['data']['skin_dryness/wrinkles']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[skin_dryness/wrinkles][change]" value="<?= $data['data']['skin_dryness/wrinkles']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Skin rashes/itching</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[skin_rashes/itching][start]" value="<?= $data['data']['skin_rashes/itching']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[skin_rashes/itching][week1]" value="<?= $data['data']['skin_rashes/itching']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[skin_rashes/itching][week2]" value="<?= $data['data']['skin_rashes/itching']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[skin_rashes/itching][week3]" value="<?= $data['data']['skin_rashes/itching']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[skin_rashes/itching][week4]" value="<?= $data['data']['skin_rashes/itching']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[skin_rashes/itching][start_change]" value="<?= $data['data']['skin_rashes/itching']['start_change']; ?>"></td>				
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[skin_rashes/itching][change]" value="<?= $data['data']['skin_rashes/itching']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label6][name]" value="<?= $data['data']['label6']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label6][start]" value="<?= $data['data']['label6']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label6][week1]" value="<?= $data['data']['label6']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label6][week2]" value="<?= $data['data']['label6']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label6][week3]" value="<?= $data['data']['label6']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label6][week4]" value="<?= $data['data']['label6']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label6][start_change]" value="<?= $data['data']['label6']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label6][change]" value="<?= $data['data']['label6']['change']; ?>"></td>
					</tr>

					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label7][name]" value="<?= $data['data']['label7']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label7][start]" value="<?= $data['data']['label7']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label7][week1]" value="<?= $data['data']['label7']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label7][week2]" value="<?= $data['data']['label7']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label7][week3]" value="<?= $data['data']['label7']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label7][week4]" value="<?= $data['data']['label7']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label7][start_change]" value="<?= $data['data']['label7']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label7][change]" value="<?= $data['data']['label7']['change']; ?>"></td>
					</tr>

					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label8][name]" value="<?= $data['data']['label8']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label8][start]" value="<?= $data['data']['label8']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label8][week1]" value="<?= $data['data']['label8']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label8][week2]" value="<?= $data['data']['label8']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label8][week3]" value="<?= $data['data']['label8']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label8][week4]" value="<?= $data['data']['label8']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label8][start_change]" value="<?= $data['data']['label8']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label8][change]" value="<?= $data['data']['label8']['change']; ?>"></td>
					</tr>

					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label9][name]" value="<?= $data['data']['label9']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label9][start]" value="<?= $data['data']['label9']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label9][week1]" value="<?= $data['data']['label9']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label9][week2]" value="<?= $data['data']['label9']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label9][week3]" value="<?= $data['data']['label9']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label9][week4]" value="<?= $data['data']['label9']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label9][start_change]" value="<?= $data['data']['label9']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label9][change]" value="<?= $data['data']['label9']['change']; ?>"></td>
					</tr>

					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label10][name]" value="<?= $data['data']['label10']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label10][start]" value="<?= $data['data']['label10']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label10][week1]" value="<?= $data['data']['label10']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label10][week2]" value="<?= $data['data']['label10']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label10][week3]" value="<?= $data['data']['label10']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label10][week4]" value="<?= $data['data']['label10']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label10][start_change]" value="<?= $data['data']['label10']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label10][change]" value="<?= $data['data']['label10']['change']; ?>"></td>
					</tr>

					<tr>
						<td class="gray-bg font-bold" colspan="8">READINGS</td>
					</tr>
					<tr>
						<td class="font-bold">Blood Pressure</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[blood_pressure][start]" value="<?= $data['data']['blood_pressure']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[blood_pressure][week1]" value="<?= $data['data']['blood_pressure']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[blood_pressure][week2]" value="<?= $data['data']['blood_pressure']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[blood_pressure][week3]" value="<?= $data['data']['blood_pressure']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[blood_pressure][week4]" value="<?= $data['data']['blood_pressure']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[blood_pressure][start_change]" value="<?= $data['data']['blood_pressure']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[blood_pressure][change]" value="<?= $data['data']['blood_pressure']['change']; ?>"></td>
					</tr>
					<tr>
						<td class="font-bold">Blood Sugar Level</td>
						<td class="input-td"><input type="text" class="table-input-control gray-bg start" name="data[blood_sugar][start]" value="<?= $data['data']['blood_sugar']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w1" name="data[blood_sugar][week1]" value="<?= $data['data']['blood_sugar']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w2" name="data[blood_sugar][week2]" value="<?= $data['data']['blood_sugar']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w3" name="data[blood_sugar][week3]" value="<?= $data['data']['blood_sugar']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w4" name="data[blood_sugar][week4]" value="<?= $data['data']['blood_sugar']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start_change" name="data[blood_sugar][start_change]" value="<?= $data['data']['blood_sugar']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[blood_sugar][change]" value="<?= $data['data']['blood_sugar']['change']; ?>"></td>

					</tr>
					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label11][name]" value="<?= $data['data']['label11']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label11][start]" value="<?= $data['data']['label11']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label11][week1]" value="<?= $data['data']['label11']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label11][week2]" value="<?= $data['data']['label11']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label11][week3]" value="<?= $data['data']['label11']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label11][week4]" value="<?= $data['data']['label11']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label11][start_change]" value="<?= $data['data']['label11']['start_change']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label11][change]" value="<?= $data['data']['label11']['change']; ?>"></td>

					</tr>

					<tr>
						<td class="input-td"><input type="text" class="table-input-control" name="data[label12][name]" value="<?= $data['data']['label12']['name']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control start" name="data[label12][start]" value="<?= $data['data']['label12']['start']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w1" name="data[label12][week1]" value="<?= $data['data']['label12']['week1']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w2" name="data[label12][week2]" value="<?= $data['data']['label12']['week2']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control w3" name="data[label12][week3]" value="<?= $data['data']['label12']['week3']; ?>"></td>
						<td class="input-td"><input type="text" class="table-input-control w4" name="data[label12][week4]" value="<?= $data['data']['label12']['week4']; ?>"></td>
						<td class="input-td"><input type="text" class="gray-bg table-input-control start_change" name="data[label12][start_change]" value="<?= $data['data']['label12']['start_change']; ?>"></td>						
						<td class="input-td"><input type="text" class="table-input-control progress-track" name="data[label12][change]" value="<?= $data['data']['label12']['change']; ?>"></td>
					</tr>
				</tbody>
			</table>
			<button class="table-cmn-btn table-save-btn">Save</button>
			<button class="table-cmn-btn table-submit-btn" type="submit">Submit</button>
		</form>
	</div>
</div>



##############################################################################################################################################
##################################################### OpsAction.php ########################################################
##############################################################################################################################################


<?php

/**
 *
 */
use Leafo\ScssPhp\Compiler;

require_once OP_PATH . "inc/vendor/leafo/scssphp/scss.inc.php";

class OpsAction
{
    public static function init()
    {
        $self = new self;
        //add_action('admin_post_', array($self, ''));
        //add_action('admin_post_nopriv_', array($self,'') );

        add_action('admin_post_progress_tracker', array($self, 'progressTracker'));
        add_action('admin_post_nopriv_progress_tracker', array($self, 'progressTracker'));
    }

    public function progressTracker()
    {
    	if (!isset($_POST['progressTracker']) || !wp_verify_nonce( $_POST['progressTracker'], 'progressTracker-nonce' )) {
    		die("You are not allowed to submit data.");
    	}

		if (!is_user_logged_in()) {
			die("You must log in");    		
		}

		$user_id = get_current_user_id();
		$OpsProgressTracker = new OpsProgressTracker();
		$progress_tracker = $OpsProgressTracker->getRow(['user_id' => $user_id]);


		$data = $_POST;
        echo "<pre>";
        print_r($data);
        echo"</pre>";
        die();

		$progress_info['user_id'] = $user_id;
		$data         			  = [];
        $data['user_id']          = intval($_POST['user_id']);
		$data['details']          = serialize($_POST);  //use serialize to save all data inside single col

		$progressInsert = $OpsProgressTracker->updateOrInsert($data, ['user_id' => $progress_info['user_id']] );
        
        //show success message
        setcookie('type', 'success', time() + (86400 * 30), "/");
        setcookie('message', 'Successfully Saved.', time() + (86400 * 30), "/");

		//send email began
		
        // $data = print_r($_POST, true);
        $data = $_POST;

        // error_log(print_r($_POST, true), 3, OP_PATH.'progress_tracker.log'); //create log file 
        // $OpsNotification->send('hasnathrumman1234@gmail.com, mehedee.but@gmail.com, akikramin@gmail.com', $subject, $content);
        
        if(intval($_POST['is_final_submission']) > 0){
        	$OpsNotification = new OpsNotification;
        	$content = get_view(OP_VIEW_PATH ."content-progress-tracker-email.php", compact('data')); //compact('data')-->[$data] used as an array ...
        	$subject = "Progress-Tracker";
        	$OpsNotification->send('akikramin@gmail.com, mehedee.but@gmail.com', $subject, $content);

            setcookie('message', 'Successfully Submitted.', time() + (86400 * 30), "/");
        }

		wp_redirect($_POST['_wp_http_referer'], 302);
        exit();		    

    }


}

?>





##############################################################################################################################################
##################################################### script.js ########################################################
##############################################################################################################################################
<script>

//cleave.js for only numeric digit
	$('.w1, .w2, .w3, .w4').toArray().forEach(function(field){
		new Cleave(field, {
		    numeral: true,
		    delimiter: '',
		})
	});

		$('.table-submit-btn').click(function() {
		$('.is_final_submission').val(1);	
		  })


	//##            change value began         ##
	$('.w1, .w4').on('keyup change', function (e) {
	// let current_progress = parseInt($(this).val());
	// if (isNaN(current_progress) || !current_progress) {
	// 	current_progress = 0;
	// }
	// let week = ;
	// let result = (week-week1)/week1;

	let _this = $(this).parents('tr');  		// $(this)-> .w1/ .w2 obj

	cal_change(_this);
	
	})

	function cal_change(_this){                         //(_this)-> [tr] from table
		let w1 = _this.find('.w1').val();
		let w4 = _this.find('.w4').val();
		let result = ((w4-w1)/w1) * 100;

		// _this.find('.progress-track').val(result);
		_this.find('.progress-track').val(result.toFixed(2));  // [find]->change class #### .val(result.toFixed(2))->toFixed(2) means digit after point(10.20/45.80)

		return result;
	}
	//##            change value end         ##


#####################################################################
###########################################################################################
############################################################################


	
	$('.start, .w4, .w2, .w3, .w1').on('keyup change', function (e) {
		let _this = $(this).parents('tr');
		percentage_change(_this);
	})

	function percentage_change(_this){
		let start = _this.find('.start').val();
		let w1 	  = _this.find('.w1').val();
		let w2 	  = _this.find('.w2').val();
		let w3 	  = _this.find('.w3').val();
		let w4 	  = _this.find('.w4').val();
		let end   = 0;

		if (w4) {
			end = w4;
		} else if (w3) {
			end = w3;
		} else if (w2) {
			end = w2;
		} else {
			end = w1;
		}
		console.log(end);
		let result = ((end-start) / start) * 100 ;

		_this.find('.progress-track').val(result.toFixed(2));
		return result;
	}





	// $('.start, .w4').on('keyup change', function (e) {
	// 	let _this = $(this).parents('tr');
	// 	star_calculation(_this);
	// })
	//
	// function star_calculation(_this){
	// 	let start = _this.find('.start').val();
	// 	let w4 	  = _this.find('.w4').val();
	// 	let result = (w4-start);
	// 	_this.find('.percentage').val(result.toFixed(2));
	//
	// 	return result;
	// }


	$('.start, .w1, .w2, .w3, .w4').on('keyup change', function () {
		let _this = $(this).parents('tr');
		start_calculation(_this);
	})

	function start_calculation(_this){
		let start = _this.find('.start').val();
		let w1 = _this.find('.w1').val();
		let w2 = _this.find('.w2').val();
		let w3 = _this.find('.w3').val();
		let w4 = _this.find('.w4').val();
		let end = 0;

		if (w4){
			end = w4;
		}  else if(w3){
			end = w3;
		} else if(w2){
			end = w2;
		} else {
			end = w1;
		}
		console.log(end);
		let result = (end-start);
		_this.find('.start_change').val(result.toFixed(2));

		return result;
		}





</script>


##############################################################################################################################################
##################################################### Add cleave.js ########################################################
##############################################################################################################################################

/wp-content/plugins/opcodespace/assets/add-on -> create new folder[cleave]-->add [cleave.js & cleave.min.js] from git

[Enqueue this cleave.js file]
								##### 			class-OpsEnqueue.php			###

<?
    public function wp_scripts()
    {
        $this->wp_scss();
        wp_enqueue_style('font-awesome', OP_ASSETSURL . "add-on/font-awesome/css/font-awesome.min.css");
        wp_enqueue_style('bootstrap-css', OP_ASSETSURL . "add-on/bootstrap/css/bootstrap-wrapper.css", false, '1.0.0');
        wp_enqueue_style('jquery-ui-css', OP_ASSETSURL . "add-on/jquery-ui/jquery-ui.min.css", false, '1.0.0');
        //wp_enqueue_style('sweet-alert', "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.3/sweetalert2.css");
        wp_enqueue_style('form-style', OP_ASSETSURL . "css/style.css", array(), time());

        //wp_enqueue_script('sweet-alert', "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.3/sweetalert2.js", array(), '1.0.0', true);
        wp_enqueue_script('cleave-js', OP_ASSETSURL . "add-on/cleave/cleave.min.js", array(), '1.0.0', true);
        

        wp_enqueue_script('jquery-ui-js', OP_ASSETSURL . "add-on/jquery-ui/jquery-ui.min.js", array(), '1.0.0', true);
        wp_enqueue_script('form-script', OP_ASSETSURL . "js/script.js", array(),  time(), true);

        wp_localize_script(
            'form-script',
            'frontend_form_object',
            array(
                'ajaxurl' => admin_url('admin-ajax.php')
            )
        );
    }

?>



##############################################################################################################################################
##################################################### /wp-content/plugins/opcodespace/view (content-progress-tracker-email.php)  ########################################################
##############################################################################################################################################


<style>
/* .table-input-control{
	position: absolute;
	height: 100%;
	width: 100%;
	left: 0;
	top: 0;
	padding: 5px;
	font-size: 14px;
	line-height: 1.42857143;
	color: #555;
	background-color: #fff;
	background-image: none;
	border: none;
	border-radius: 0px;
}
.name-input-td {
	position:relative;
}
.name-table-input-control{
	position: absolute;
	height: 100%;
	width: 80%;
	right: 0;
	top: 0;
	padding: 5px;
	font-size: 14px;
	line-height: 1.42857143;
	color: #555;
	background-color: #fff;
	background-image: none;
	border: none;
	border-radius: 0px;
} */
</style>


<div class="progress-tracker-form">
	<table style="width: 100%;	border: 1px solid #ddd;	border-collapse: collapse;">
		<tbody>
			<tr>
				<td colspan="6" class="gray-bg" style="background-color: #f2f2f2; text-align: center; font-size: 18px; font-weight: bold; border: 1px solid #ddd;padding: 8px;height: 30px;">PROGRESS TRACKER</td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;" class="name-input-td" colspan="3"><span>Name:</span> <?= $data['name']; ?> </td>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;" class="name-input-td" colspan="3"><span>Start Date:</span> <?= $data['date']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;" colspan="6">Enter data for markers you’d like to track.You can add other markers in spaces provided, if desired.</td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;"></td>
				<td  style="border: 1px solid #ddd;padding: 8px;height: 30px;"class="gray-bg">Week 1</td>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Week 2</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Week 3</td>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Week 4</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Change</td>
			</tr>
			<tr>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">MEASUREMENTS</td>
				<td class="gray-bg" colspan="5" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Waist is important for health tracking.</td>
			</tr>
			<tr>
				<td>Bust/Chest</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['bust/chest']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['bust/chest']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['bust/chest']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['bust/chest']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['bust/chest']['change']; ?> </td>
			</tr>
			<tr>
				<td>Waist</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['waist']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['waist']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['waist']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['waist']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['waist']['change']; ?></td>
			</tr>
			<tr>
				<td>Hips/Gut/Butt</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['hips/gut/butt']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['hips/gut/butt']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['hips/gut/butt']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['hips/gut/butt']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['hips/gut/butt']['change']; ?> </td>
			</tr>
			<tr>
				<td>Weight (pounds)</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['weight']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['weight']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['weight']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['weight']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['weight']['change']; ?> </td>
			</tr>
			<tr>
				<td>Clothing Size</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['clothing_size']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['clothing_size']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['clothing_size']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['clothing_size']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['clothing_size']['change']; ?> </td>
			</tr>
			<tr>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['name']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label1']['change']; ?> </td>
			</tr>
			<tr>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['name']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label2']['change']; ?> </td>
			</tr>
			<tr>
				<td class="gray-bg" colspan="6" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">SYMPTOMS: Use scale of 0 for lowest, to 10 for highest</td>
			</tr>
			<tr>
				<td class="gray-bg" colspan="6" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">HIGH numbers on these markers is GOOD; 0 is awesome; 10 is scary.</td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Energy Level</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['energy_level']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['energy_level']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['energy_level']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['energy_level']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['energy_level']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Sleep Quality</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sleep_quality']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sleep_quality']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sleep_quality']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sleep_quality']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sleep_quality']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Sexual Desire</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_desire']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_desire']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_desire']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_desire']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_desire']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Sexual Stamina</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_stamina']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_stamina']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_stamina']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_stamina']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['sexual_stamina']['change']; ?> </td>
			</tr>
			
			<tr>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['name']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label3']['change']; ?> </td>
			</tr>
			<tr>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['name']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label4']['change']; ?> </td>
			</tr>
			<tr>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['name']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['label5']['change']; ?> </td>
			</tr>

			<tr>
				<td class="gray-bg" colspan="6" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">LOW numbers on the following markers is GOOD; 0 is awesome, 10 is scary</td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Compulsive eating</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['compulsive_eating']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['compulsive_eating']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['compulsive_eating']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['compulsive_eating']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['compulsive_eating']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Craving for:</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['craving']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['craving']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['craving']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['craving']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['craving']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Gas/Bloating</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['gas/bloating']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['gas/bloating']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['gas/bloating']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['gas/bloating']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['gas/bloating']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Constipation</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['constipation']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['constipation']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['constipation']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['constipation']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['constipation']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Diarrhea</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['diarrhea']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['diarrhea']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['diarrhea']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['diarrhea']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['diarrhea']['change']; ?> </td>
			</tr>
			<tr>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;"></td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Week 1</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Week 2</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Week 3</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Week 4</td>
				<td class="gray-bg" style="background-color: #f2f2f2; border: 1px solid #ddd;padding: 8px;height: 30px;">Change</td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Depression</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['depression']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['depression']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['depression']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['depression']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['depression']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Irritability/mood swings</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['irritability/mood_swings']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['irritability/mood_swings']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['irritability/mood_swings']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['irritability/mood_swings']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['irritability/mood_swings']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Pain</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['pain']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['pain']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['pain']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['pain']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['pain']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Stiffness</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['stiffness']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['stiffness']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['stiffness']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['stiffness']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['stiffness']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Swelling</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['swelling']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['swelling']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['swelling']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['swelling']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['swelling']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Skin dryness/wrinkles</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_dryness/wrinkles']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_dryness/wrinkles']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_dryness/wrinkles']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_dryness/wrinkles']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_dryness/wrinkles']['change']; ?> </td>
			</tr>
			<tr>
				<td style="border: 1px solid #ddd;padding: 8px;height: 30px;">Skin rashes/itching</td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_rashes/itching']['week1']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_rashes/itching']['week2']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_rashes/itching']['week3']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_rashes/itching']['week4']; ?> </td>
				<td class="input-td" style="border: 1px solid #ddd;padding: 8px;height: 30px;"> <?= $data['data']['skin_rashes/itching']['change']; ?> </td>
			</tr>
		</tbody>
	</table>
</div>