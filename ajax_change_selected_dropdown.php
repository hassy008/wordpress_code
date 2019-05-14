<?php

$OpsAttendee = new OpsAttendee();
$OpsHotelBooking = new OpsHotelBooking();
$OpsFlight = new OpsFlight();
$OpsItem 	= new OpsItem();
$OpsProduct = new OpsProduct();
$OpsHotel 	  = new OpsHotel();	
$attendees    = $OpsAttendee->getAllSoftDelete(['user_id' => $user_id]);

    // $general_info['user_id'] = $user_id;
    // $general_info['type'] = 'Member';
    // $hotel_info['user_id'] =  $user_id;
    // $flight_info['user_id'] =  $user_id;

##getRow
    $user_id = get_current_user_id();
    $general_info  = $OpsAttendee->getRow(['user_id' => $user_id]);
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
?>

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
					<input type="text" class="form-control datepicker" name="data[hotelBooking][check_id]" value="<?php echo $hotel_booking->check_id; ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="">Check-Out Date</label>
					<input type="text" class="form-control datepicker" name="data[hotelBooking][check_out]" value="<?php echo $hotel_booking->check_out; ?>">
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




<!-- change room_type when selected hotel_name -->

<!-- ####################################### script.js ######################################## -->

<script>
	
	 //  #hotel_room_type_began
    $('.hotel-name').change(function(e) {
        get_hotel_category();
    })

    get_hotel_category();  //when this function load 

    function get_hotel_category(){
        $.ajax({
                type: 'POST',
                url: frontend_form_object.ajaxurl,
                data: {
                    action: 'hotel_change_details',
                    id: $('.hotel-name').val(),  //(this) is not working here caz we use function

                },
            })
            .done(function(response) {
                console.log(response);
                if (response.success) {
                    $('.room-type').html(response.data.cat); //.html-> caz we using inside <option>
                  
                }
            })

            .fail(function () {
                console.log("error");
            })
    }

  // #hotel_room_type_end  

</script>



<!-- ####################################### OpsAjaxAction.php ######################################## -->
<?php
	class OpsAjaxAction
{
	
	static public function init()
	{
		$self = new self();
		add_action( "wp_ajax_hotel_change_details", array($self, 'hotelChangeDetails') );
		//add_action( "wp_ajax_nopriv_linked_banks", array($self, '') );
	}

	public function hotelChangeDetails()
	{
		$OpsHotel 	= new OpsHotel();	
		$id 		= intval($_POST['id']);
		$categories = (new OpsHotelRoom)->get(['hotel_id' => $id]);

		$user_id = get_current_user_id();

		$hotel_booking = (new OpsHotelBooking)->getRow(['user_id' => $user_id]);

		 $categotyOptions = '<option></option>';
		 foreach ($categories as $category) {

		 	$selected = $hotel_booking->room_type == $category->id ? 'selected' : '';

		  	$categotyOptions .= "<option data-price='{$category->price}' data-cap='{$category->capacity}' value='{$category->id}' {$selected} >{$category->category} (&#36;{$category->price}  CAD)</option>";
		 }
	  
	  wp_send_json_success(['cat' => $categotyOptions]);
	}

