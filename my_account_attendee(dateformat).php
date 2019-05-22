<?php

$OpsAttendee = new OpsAttendee();
$OpsHotelBooking = new OpsHotelBooking();
$OpsFlight = new OpsFlight();
$OpsItem 	= new OpsItem();
$OpsProduct = new OpsProduct();
$OpsHotel 	  = new OpsHotel();	
$OpsPrice = new OpsPrice;
$attendees    = $OpsAttendee->getAllSoftDelete(['user_id' => $user_id]);

    // $general_info['user_id'] = $user_id;
    // $general_info['type'] = 'Member';
    // $hotel_info['user_id'] =  $user_id;
    // $flight_info['user_id'] =  $user_id;

##getRow
    $user_id = get_current_user_id();

    $attendee_member =  $OpsAttendee->getRow(['type' => 'Member', 'user_id' => $user_id ]);
    $general_info  = $OpsAttendee->getRow(['user_id' => $user_id, 'type' => 'Member']);
    	// echo "<pre>";
     //    print_r($general_info);
     //    echo"</pre>";

    // $OpsHotelBooking = new OpsHotelBooking();
    $hotel_booking = $OpsHotelBooking->getRow(['user_id' => $user_id]);
    $hotels = $OpsHotel->getAll('id');

    $flight = $OpsFlight->getRow(['user_id' => $user_id]);    
        // echo "<pre>";
        // print_r($flight);
        // echo"</pre>";

    # NON-CONGRESS ITEMS
    $nonCongressItems = $OpsProduct->nonCongressEvents();
?>
<div class="attendee">
	<div class="alert alert-info" style="border-left: 4px solid #e8794c; border-top: 0px; border-right: 0px; border-bottom: 0px; color: #de561f; background-color: #e8784c21; border-radius: 0px;">
		You have due amount of $<?= $balance ?>. <a href="<?= home_url('/my-account/?section=payments'); ?>" style=" text-decoration: underline; color: #de561f;">Pay now</a>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="congress-reg-wrapper well">
				<h2> Congress Registration</h2>
				<!-- Nav tabs -->
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a data-target="#genInfo" aria-controls="genInfo" role="tab" data-toggle="tab">General Information</a></li>
					<li role="presentation"><a data-target="#address" aria-controls="address" role="tab" data-toggle="tab">Address</a></li>
					<li role="presentation"><a data-target="#items" aria-controls="items" role="tab" data-toggle="tab">Items</a></li>
					<li role="presentation"><a data-target="#hotelBooking" aria-controls="hotelBooking" role="tab" data-toggle="tab">Hotel Booking</a></li>
					<li role="presentation"><a data-target="#flightDetails" aria-controls="flightDetails" role="tab" data-toggle="tab">Flight Details</a></li>
					<li role="presentation"><a data-target="#guest" aria-controls="guest" role="tab" data-toggle="tab">Guest</a></li>
				</ul>

				<!-- Tab panes -->
		<?php if (isset($_SESSION['message'])) : ?>
			<div class="alert alert-<?= $_SESSION['type'] ?>">
				<?= $_SESSION['message'] ?>
			</div>
		<?php endif; unset($_SESSION['message']); unset($_SESSION['type']);  ?>
		<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
		    <input type="hidden" name="action" value="congress_registration">
		    <input type="hidden" name="attendee_id" value="<?= $_GET['attendee_id']; ?>">
		    <input type="hidden" name="hotel_booking_id" value="<?= $_GET['hotel_booking_id']; ?>">
		    <input type="hidden" name="flight_id" value="<?= $_GET['flight_id']; ?>">
		    <?php wp_nonce_field('CongressRegistration-nonce', 'CongressRegistration');?>
	
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="genInfo">
						<div class="gen-info-content">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">First Name</label>
										<input type="text" class="form-control" name="data[general][first_name]" value="<?= $general_info->first_name; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Last Name</label>
										<input type="text" class="form-control" name="data[general][last_name]" value="<?= $general_info->last_name; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Gender at Birth</label>
										<div class="radio-btn radio-btn-inline">
											<input type="radio" id="male" name="data[general][sex]" value="male" <?= $general_info->sex == 'male' ? ' checked' : '' ?>><label for="male">Male</label>
											<input type="radio" id="female" name="data[general][sex]" value="female" <?= $general_info->sex == 'female' ? ' checked' : '' ?>><label for="female">Female</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Dietary Restrictions</label>
										<input type="text" class="form-control" name="data[general][dietary_restrictions]" value="<?=$general_info->dietary_restrictions; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Food Allergies</label>
										<input type="text" class="form-control" name="data[general][food_allergies]" value="<?=$general_info->dietary_restrictions?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="display: block;">Language spoken at home</label>
										<div class="radio-btn radio-btn-inline">
											<input type="radio" id="french" name="data[general][language]" value="french" <?= $general_info->language == 'french' ? 'checked' : '' ?>><label for="french">French</label>
											<input type="radio" id="spanish" name="data[general][language]" value="spanish" <?= $general_info->language == 'spanish' ? 'checked' : '' ?>><label for="spanish">Spanish</label>
											<input type="radio" id="other_lang" name="data[general][language]" value="other_lang" <?= $general_info->language == 'other_lang' ? 'checked' : '' ?>><label for="other_lang">Other_lang</label>
										</div>
										<input type="text" class="form-control other-lang" placeholder="Type your spoken language">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Skål Member No</label>
										<input type="text" class="form-control" name="data[general][skal_member_no]" value="<?=$general_info->skal_member_no?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Country</label>
										<div class="select-wrapper">
											<select class="select-style form-control" value="<?=$general_info->country;?>" name="data[general][country]">
												<?php foreach (OpsSelectOption::CountryName() as $country): ?>
													<option <?=$country == $general_info->country ? "selected" : "";?>><?=$country;?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Club Name</label>
										<div class="select-wrapper">
											<select class="select-style form-control details-input-control" value="<?=$general_info->club;?>" name="data[general][club]" >ClubName
												<?php foreach (OpsSelectOption::ClubName() as $clubName): ?>
													<option <?=$clubName == $general_info->club ? "selected" : "";?>><?=$clubName;?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Function in club</label>
										<div class="select-wrapper">
											<select class="select-style form-control details-input-control" value="<?=$general_info->function_in_club;?>" name="data[general][function_in_club]" >FunctionInClub
												<?php foreach (OpsSelectOption::FunctionInClub() as $functionInClub): ?>
													<option <?=$functionInClub == $general_info->function_in_club ? "selected" : "";?>><?=$functionInClub;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<input type="text" class="form-control other-function" placeholder="Type your position">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Attending Congress as</label>
										<div class="select-wrapper">									
											<select class="select-style form-control details-input-control" value="<?=$general_info->attending_congress_as;?>" name="data[general][attending_congress_as]" >AttendingCongress
												<?php foreach (OpsSelectOption::AttendingCongress() as $attendingCongress): ?>
													<option <?=$attendingCongress == $general_info->attending_congress_as ? "selected" : "";?>><?=$attendingCongress;?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Organization ID on Badge</label>
										<input type="text" class="form-control" name="data[general][organization_id]" value="<?=$general_info->organization_id?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Title on Badge</label>
										<input type="text" class="form-control" name="data[general][title_on_badge]" value="<?=$general_info->title_on_badge?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" class="form-control" name="data[general][email]" value="<?=$general_info->email?>"> 
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Mobile Phone</label>
										<input type="tel" class="form-control" name="data[general][mobile_phone]" value="<?=$general_info->mobile_phone?>">
									</div>
								</div>
							</div>
							<div class="next-prev-btn-wrapper form-group">
								<div class="btn btn-danger next-btn">Next</div>
								<button class="btn btn-danger">Save</button>
							</div>
						</div>
					</div> <!-- general info ending tag -->

					<div role="tabpanel" class="tab-pane" id="address">
						<div class="address-content-wrapper">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Company Name</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Title</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Address</label>
										<input type="text" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">City</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">State</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Postal Code</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Company Phone No</label>
										<input type="tel" class="form-control">
									</div>
								</div>
							</div>
							<div class="next-prev-btn-wrapper form-group">
								<div class="btn btn-danger prev-btn">Prev</div>
								<div class="btn btn-danger next-btn">Next</div>
								<button class="btn btn-danger">Save</button>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="items">
						<div class="items-wrapper">
							<div class="form-group">
								<label for="">1st Timer</label>
								<div class="radio-btn radio-btn-inline">
									<input type="radio" id="timer_yes" name="data[general][is_first_timer]" value="1" <?= (!empty($general_info->is_first_timer) ? ' checked' : '') ?>><label for="timer_yes">Yes</label>
									<input type="radio" id="timer_no" name="data[general][is_first_timer]" value="0"<?= (empty($general_info->is_first_timer) ? ' checked' : '') ?>><label for="timer_no" >No</label>
								</div>
							</div>
							<div class="form-group">
								<label for="">Paid by Skål</label>
								<div class="radio-btn radio-btn-inline">
									<input type="radio" id="paid_by_skal_yes" name="data[general][paid_by_skal]" value="1" <?= (!empty($general_info->paid_by_skal) ? ' checked' : '') ?>><label for="paid_by_skal_yes">Yes</label>
									<input type="radio" id="paid_by_skal_no" name="data[general][paid_by_skal]" value="0" <?= (empty($general_info->paid_by_skal) ? ' checked' : '') ?>><label for="paid_by_skal_no">No</label>
								</div>
							</div>
							<div class="form-group">
								<label for="">Participation</label>
								<div class="radio-btn radio-btn-inline">
									<input type="radio" id="participation_yes" name="data[general][participation]" value="Full Congress" <?= ($general_info->participation=="Full Congress" ?  ' checked' : '') ?>><label for="participation_yes">Full Congress - $ <?= $OpsPrice->congressMember($user_id, $general_info->id) ?></label>
									<input type="radio" id="participation_no" name="data[general][participation]" value="A la Carte" <?= ($general_info->participation=="A la Carte" ? ' checked' : '') ?>><label for="participation_no">A la Carte</label>
								</div>
								<div class="a-la-carte-wrapper<?= ($general_info->participation=="A la Carte" ? ' active' : '') ?>">
									<div class="my-sqr-check-btn">
										<?php

                                        $OpsItem = new OpsItem();
                                        $member_items = $OpsItem->get(['attendee_id' => $attendee_member->id]);
                                        $member_selected_items[] = array_map(function ($v)
                                        {
                                            return $v->product_id;
                                        }, $member_items);

                                        foreach ($nonCongressItems as $nonCongressItem) : ?>
											<input type="checkbox" id="<?= $nonCongressItem->id ?>" value="<?= $nonCongressItem->id ?>" name='items[]' <?= (in_array( $nonCongressItem->id, $member_selected_items[0]) ? ' checked' : '')?>>
											<label for="<?= $nonCongressItem->id ?>"><?= $nonCongressItem->name ?> - $<?= $OpsPrice->general($user_id, $general_info->id, $nonCongressItem->id) ?></label>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="">Dietary Restrictions</label>
								<div class="radio-btn radio-btn-inline">
									<input type="radio" id="dietary_yes2" name="data[general][is_dietary_restrictions]" value="1" <?= (!empty($general_info->is_dietary_restrictions) ? ' checked' : '') ?>><label for="dietary_yes2">Yes</label>
									<input type="radio" id="dietary_no2" name="data[general][is_dietary_restrictions]" value="0"<?= (empty($general_info->is_dietary_restrictions) == 'no' ? ' checked' : '') ?>><label for="dietary_no2">No</label>
								</div>
								<div class="row">
									<div class="col-md-6">
										<textarea class="form-control dietary_restrictions_input<?= (!empty($general_info->is_dietary_restrictions) ? ' active' : '') ?>" name="data[general][dietary_restrictions]"><?= $general_info->dietary_restrictions ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="">Food Allergies</label>
								<div class="radio-btn radio-btn-inline">
									<input type="radio" id="food_allergies_yes2" name="data[general][is_food_allergies]" value="1" <?= (!empty($general_info->is_food_allergies) ? ' checked' : '') ?>><label for="food_allergies_yes2">Yes</label>
									<input type="radio" id="food_allergies_no2" name="data[general][is_food_allergies]" value="0" <?= (empty($general_info->is_food_allergies) ? ' checked' : '') ?>><label for="food_allergies_no2">No</label>
									<div class="row">
										<div class="col-md-6">
											<textarea class="form-control food_allergies_input<?= (!empty($general_info->is_food_allergies) ? ' active' : '') ?>" name="data[general][food_allergies]"><?= $general_info->food_allergies ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="">Accomodation required</label>
								<div class="radio-btn radio-btn-inline">

									<input type="radio" id="accomodation_yes" name="data[general][accomodation_required]" value="1"<?= (!empty($general_info->accomodation_required) ? ' checked' : '') ?>><label for="accomodation_yes" >Yes</label>
									<input type="radio" id="accomodation_no" name="data[general][accomodation_required]" value="0"<?= (empty($general_info->accomodation_required) ? ' checked' : '') ?>><label for="accomodation_no" >No</label>
								</div>
							</div>
							<div class="next-prev-btn-wrapper form-group">
								<div class="btn btn-danger prev-btn">Prev</div>
								<div class="btn btn-danger next-btn">Next</div>
								<button class="btn btn-danger">Save</button>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="hotelBooking">
						<div class="hotel-booking-wrapper">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Hotel Name</label>
										<div class="select-wrapper">
											<select class="select-style form-control details-input-control hotel-name" name="data[hotelBooking][hotel_name]">
												<option value=""></option>
											<?php foreach ($hotels as  $hotel) { ?>
												<option <?= $hotel->id == $hotel_booking->hotel_name ? 'selected' : '' ?> value="<?=$hotel->id ?>"><?= $hotel->name; ?></option>	
											<?php } ?>
			
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Booking ID</label>
										<input type="text" class="form-control" name="data[hotelBooking][booking_id]" value="<?php echo $hotel_booking->booking_id; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Room Type</label>
										<div class="select-wrapper">
											<select class="select-style form-control details-input-control room-type" name="data[hotelBooking][room_type]">
												<!-- <option value="1" <?=$hotel_booking->room_type == '1' ? 'selected' : '' ?>>1</option>
												<option value="2" <?=$hotel_booking->room_type == '2' ? 'selected' : ''?>>2</option>
												<option value="3" <?=$hotel_booking->room_type == '3' ? 'selected' : '' ?>>3</option> -->
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Person</label>
										<input type="text" class="form-control" name="data[hotelBooking][persons]" value="<?php echo $hotel_booking->persons; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Nights</label>
										<input type="text" class="form-control" name="data[hotelBooking][nights]" value="<?php echo $hotel_booking->nights; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Room Rate</label>
										<input type="text" class="form-control room-rate" name="data[hotelBooking][room_rate]" value="<?php echo $hotel_booking->room_rate; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Stay Value</label>
										<input type="text" class="form-control" name="data[hotelBooking][stay_value]" value="<?php echo $hotel_booking->stay_value; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Check-In Date/Time</label>
										<!--to view date with format from sql-->
										<?php  
											if (!empty($hotel_booking->check_id)) {
												$date = new DateTime($hotel_booking->check_id);
												$check_in = $date->format("Y-m_d H:i:s");
											}
										?>
										<input type="text" class="form-control datepicker" name="data[hotelBooking][check_id]" value="<?php echo $check_in; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Check-Out Date</label>
										<?php 
											if (!empty($hotel_booking->check_out)) {
											$date = new DateTime($hotel_booking->check_out); 
											$check_out = $date->format("Y-m-d H:i:s");
											//print_r($check_out);
											}					
										?>
										<input type="text" class="form-control datepicker" name="data[hotelBooking][check_out]" value="<?php echo $check_out ; ?>"
										>
									</div>
								</div>
							</div>
							<div class="next-prev-btn-wrapper form-group">
								<div class="btn btn-danger prev-btn">Prev</div>
								<div class="btn btn-danger next-btn">Next</div>
								<button class="btn btn-danger">Save</button>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="flightDetails">
						<div class="flight-details-wrapper">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Arrival Date/Time</label>
										<?php 
											if (!empty($hotel_booking->arrival)) {
											$date = new DateTime($hotel_booking->arrival); 
											$arrival = $date->format("Y-m-d H:i:s");
											//print_r($arrival);
											}					
										?>
										<input type="text" class="form-control datepicker" name="data[flightDetails][arrival]"  value="<?php echo $arrival; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Airline</label>
										<input type="text" class="form-control" name="data[flightDetails][arrival_airline]" value="<?php echo $flight->arrival_airline; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Flight Number</label>
										<input type="text" class="form-control" name="data[flightDetails][arrival_flight_number]" value="<?php echo $flight->arrival_flight_number; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Departure Date/Time</label>
										<?php 
											if (!empty($hotel_booking->departure)) {
											$date = new DateTime($hotel_booking->departure); 
											$departure = $date->format("Y-m-d H:i:s");
											//print_r($departure);
											}					
										?>
										<input type="text" class="form-control datepicker"  name="data[flightDetails][departure]" value="<?php echo $departure; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Airline</label>
										<input type="text" class="form-control" name="data[flightDetails][departure_arrival_airline]" value="<?php echo $flight->departure_arrival_airline; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Flight Number</label>
										<input type="text" class="form-control" name="data[flightDetails][departure_flight_number]" value="<?php echo $flight->departure_flight_number; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="next-prev-btn-wrapper form-group">
							<div class="btn btn-danger prev-btn">Prev</div>
							<div class="btn btn-danger next-btn">Next</div>
							<button class="btn btn-danger">Save</button>
						</div>
					</div>
					<?php
					// yasar 
					$guests = $OpsAttendee->get(['type' => 'Guest', 'user_id' => $user_id]);
					?>
					<div role="tabpanel" class="tab-pane" id="guest">
						<div class="guest-wrapper">
							<div class="form-group text-right">
							<div class="btn btn-danger add-guest-btn" data-toggle="modal" data-target="#addGuestModal">Add Guest</div>
						</div>
						<table class="table table-bordered table-striped guest-table">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Registration for</th>
									<th>Gender</th>
									<th>Dietary Restrictions</th>
									<th>Food Allergies</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($guests as $guest) : ?>
								<tr class="<?= "guest-{$guest->id}" ?>">
									<td><?= $guest->first_name ?></td>
									<td><?= $guest->last_name ?></td>
									<td><?= $guest->participation ?></td>
									<td><?= $guest->sex ?></td>
									<td><?= $guest->dietary_restrictions ?></td>
									<td><?= $guest->food_allergies ?></td>
									<td data-id=<?= $guest->id ?>>
										<span class="edit-row edit-guest" data-toggle="modal" data-target="#addGuestModal"><i class="fa fa-edit"></i></span>
										<span href="" class="text-danger delete-guest"><i class="fa fa-trash"></i></span>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						</div>
						<div class="next-prev-btn-wrapper form-group">
							<div class="btn btn-danger prev-btn">Prev</div>
							<button class="btn btn-danger">Save</button>
						</div>
					</div>

				</div>
		</form>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Add Guest Modal Start-->
<div class="modal fade" id="addGuestModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Guest</span>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" class="form-control" name="first_name" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" class="form-control" name="last_name" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Registration for</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="reg_for_full" name="reg_for" value="Full Congress"><label for="reg_for_full">Full Congress - $ <?= $OpsPrice->congressMember($user_id, $general_info->id) ?></label>
								<input type="radio" id="reg_for_carte" name="reg_for" value="la Carte"><label for="reg_for_carte">A la Carte</label>
							</div>
							<div class="a-la-carte-wrapper">
								<div class="my-sqr-check-btn">
                                    <?php foreach ($nonCongressItems as $nonCongressItem) : ?>
                                        <input type="checkbox" id="guest-<?= $nonCongressItem->id ?>" value="<?= $nonCongressItem->id ?>" name='items[]'>
                                        <label for="guest-<?= $nonCongressItem->id ?>"><?= $nonCongressItem->name ?> - $<?= $OpsPrice->general($user_id, $general_info->id, $nonCongressItem->id) ?></label>
                                    <?php endforeach; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Gender at Birth</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="guest_male" name="guest_gender" value="male"><label for="guest_male">Male</label>
								<input type="radio" id="guest_female" name="guest_gender" value="female"><label for="guest_female">Female</label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Timer</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="guest_timer_yes" name="guest_timer" value="yes"><label for="guest_timer_yes">Yes</label>
								<input type="radio" id="guest_timer_no" name="guest_timer" value="no"><label for="guest_timer_no">No</label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Dietary Restrictions</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="dietary_yes" name="dietary_restrictions" value="yes"><label for="dietary_yes">Yes</label>
								<input type="radio" id="dietary_no" name="dietary_restrictions" value="no"><label for="dietary_no">No</label>
							</div>
							<textarea class="form-control dietary_restrictions_input"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Food Allergies</label>
							<div class="radio-btn radio-btn-inline">
								<input type="radio" id="food_allergies_yes" name="food_allergies" value="yes"><label for="food_allergies_yes">Yes</label>
								<input type="radio" id="food_allergies_no" name="food_allergies" value="no"><label for="food_allergies_no">No</label>
								<textarea class="form-control food_allergies_input"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="text-right">
					<button class="btn btn-danger save_guest" type="submit">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Guest Modal end-->




<!-- ########################################################################################################################
########################################################################################################################
########################################################### 			OpsAction.php						#################################################################################
########################################################################################################################
######################################################################################################################## -->

<?php 
    public function congress_registration()
    {
        if (!isset($_POST['CongressRegistration']) || !wp_verify_nonce( $_POST['CongressRegistration'], 'CongressRegistration-nonce' ) ) {
             die("You are not allowed to submit data.");
        }

        if(!is_user_logged_in()){
            die("You must log in ");
        }

        $user_id = get_current_user_id();

        $OpsPrice        = new OpsPrice();
        $OpsItem        = new OpsItem();
        $OpsAttendee     = new OpsAttendee();
        $attendee_member =  $OpsAttendee->getRow(['type' => 'Member', 'user_id' => $user_id ]);
        $OpsItem->delete(['attendee_id' => $attendee_member->id]);

        $user_selected_item_ids = [];
        if ($_POST['data']['general']['participation'] == 'Full Congress') {
            $user_selected_item_ids = [15];
        } elseif  ($_POST['data']['general']['participation'] == 'A la Carte') {
             $user_selected_item_ids = $_POST['items'];
        }
        foreach ($user_selected_item_ids as $user_selected_item_id) {
            $price = $user_selected_item_id == 15 ? $OpsPrice->congressMember($user_id, $attendee_member->id) : $OpsPrice->general($user_id, $attendee_member->id, $user_selected_item_id);
            $OpsItem->insert(
                [
                    'attendee_id' => $attendee_member->id,
                    'user_id'     => $user_id,
                    'product_id'  => $user_selected_item_id,
                    'has_paid'    => false,
                    'price'       => $price
                ]
            );
        }
        

            // echo "<pre>";
            // print_r($_POST);
            // echo"</pre>";
            // die();

        $general_info = $_POST['data']['general'];
        $hotel_info = $_POST['data']['hotelBooking'];
        $flight_info = $_POST['data']['flightDetails'];

        $general_info['type'] = 'Member';
        $general_info['user_id'] = $user_id;
        $hotel_info['user_id'] =  $user_id;
        $flight_info['user_id'] =  $user_id;

        foreach ($general_info as $key => $value) {
            $general_info[$key] = esc_sql($value);
        }

        foreach ($hotel_info as $key => $value) {

            if($key == 'check_id'){
                if(!empty($value)){
                    $date = new DateTime($value);
                    $value = $date->format("Y-m-d H:i:s");
                }
            }
            if ($key == 'check_out') {
                if (!empty($value)) {
                    $date = new DateTime($value);
                    $value = $date->format("Y-m-d H:i:s");
                }
            }

            $hotel_info[$key] = esc_sql($value);
        }

        foreach ($flight_info as $key => $value) {
            if($key == 'arrival'){
                if(!empty($value)){
                    $date = new DateTime($value);
                    $value = $date->format("Y-m-d H:i:s");
                }
            }
            if ($key == 'departure') {
                if (!empty($value)) {
                    $date = new DateTime($value);
                    $value = $date->format("Y-m-d H:i:s");
                }
            }
            $flight_info[$key] = esc_sql($value);
        }

////////////////// This code for set Date time to SQL  //////////////////////////////
        // if($key == 'arrival'){
        //         if(!empty($value)){
        //             $date = new DateTime($value);
        //             $value = $date->format("Y-m-d H:i:s");
        //         }
        //     }

        #attendee 


        # Check record for member If have update otherwise insert> ''
        $attendeeUpdate = $OpsAttendee->updateOrInsert($general_info, ['user_id' => $general_info['user_id'], 'type' => 'Member'] );


        #HotelBooking
        $OpsHotelBooking = new OpsHotelBooking();
        $OpsHotelBooking->updateOrInsert($hotel_info,['user_id' => $user_id] );
    

        #flight
        $OpsFlight = new OpsFlight();
        $OpsFlight->updateOrInsert($flight_info,['user_id' => $user_id] );

        wp_redirect($_POST['_wp_http_referer'], 302);
        exit();

    }

    ?>