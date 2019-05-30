<?php  
	$OpsHotelBooking = new OpsHotelBooking();
	$hotel_bookings = $OpsHotelBooking->getHotelBookingInfo();
		// echo "<pre>";
	 //    print_r($hotel_bookings);
	 //    echo"</pre>";
?>

<div class="form-group text-right">
	<a href="<?= admin_url('/admin-post.php?action=generate_hotel_booking_csv');?>" class="export-btn"><span class="fa fa-file-excel-o"></span> Export As CSV</a>
	<a href="<?= admin_url('/admin-post.php?action=generate_hotel_booking_pdf');?>" class="export-btn"><span class="fa fa-file-pdf-o"></span> Export As PDF</a>
	<div class="export-btn" data-toggle="modal" data-target="#sentByEmail1"><span><i class="fa fa-envelope-o"></i></span> Send By Email</div>
</div>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Member First Name</th>
			<th>Member Last Name</th>
			<th>Member Email</th>
			<th>Member Phone</th>
			<th>Hotel Name</th>
			<th>Booking ID</th>
			<th>Room Type</th>
			<th>Person</th>
			<th>Nights</th>
			<th>Room Rate</th>
			<th>Stay Value</th>
			<th>Check-In Date/Time</th>
			<th>Check-Out Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	  <?php foreach ($hotel_bookings as $hotel_booking) : ?>
		<tr>
			<td><?= $hotel_booking->first_name; ?></td>
			<td><?= $hotel_booking->last_name; ?></td>
			<td><?= $hotel_booking->email; ?></td>
			<td><?= $hotel_booking->phone; ?></td>
			<td><?= $hotel_booking->name; ?></td>
			<td><?= $hotel_booking->booking_id; ?></td>
			<td><?= $hotel_booking->category; ?></td>
			<td><?= $hotel_booking->persons; ?></td>
			<td><?= $hotel_booking->nights; ?></td>
			<td><?= $hotel_booking->room_rate; ?></td>
			<td><?= $hotel_booking->stay_value; ?></td>
			<td><?= $hotel_booking->check_id; ?></td>
			<td><?= $hotel_booking->check_out; ?></td>
			<td class="action">
				<span data-toggle="modal" data-target="#flight-details-modal"><i class="fa fa-edit"></i></span>
				<span><i class="fa fa-trash"></i></span>
			</td>
		</tr>
	  <?php endforeach ?>
	</tbody>
</table>


<!-- Modal Start-->
<div class="modal fade" id="flight-details-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Edit Hotel Booking</span>
			</div>
			<div class="modal-body">
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
							<div class="text-right">
								<div class="btn btn-danger">Update</div>
							</div>
						</div>
		</div>
	</div>
</div>
<!-- Modal end-->

<!-- Modal Start-->
<div class="modal fade" id="sentByEmail1" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Send Email</span>
			</div>
			<form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
		  		<input type="hidden" name="action" value="email_hotel_booking">
		  		<?php wp_nonce_field('emailHotelBooking-nonce', 'emailHotelBooking'); ?>
			  <div class="modal-body">
				<div class="form-group">
					<label>Send Email</label>
					<input type="email" class="form-control" name="email">
				</div>
				<div class="text-center">
					<button class="btn btn-danger">Send</button>
				</div>
		      </div>
			</form>
		</div>
	</div>
</div>
<!-- Modal end-->





##################################################################################################
###################################### 		OpsHotelBooking.php 		############################################################
##################################################################################################
##################################################################################################
##################################################################################################

<?php

class OpsHotelBooking extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->prefix . "hotel_booking";
        $this->htoel_table = $this->db->prefix . "htoel";
        $this->hotel_room_table = $this->db->prefix . "hotel_room";
        $this->usermeta = $this->db->prefix . "usermeta";
        $this->attendees = $this->db->prefix . "attendees";

    }

    public function getHotelBookingInfo()
    {

    	$fields = "hb.*, h.name, hr.category, a.first_name, a.last_name, a.email, a.phone";
    	$where  = "";
    	$query  = "SELECT $fields FROM $this->table AS hb
    	LEFT JOIN $this->htoel_table AS h ON h.id = hb.hotel_name
    	LEFT JOIN $this->hotel_room_table AS hr ON hr.id = hb.room_type 
    	LEFT JOIN $this->attendees AS a ON a.user_id = hb.user_id AND a.type = 'Member'
    	{$where}";

   		 return $this->db->get_results($query);

    }


}

?>



##################################################################################################
###################################         class-OpsDashboardAction.php         ###############################################################
##################################################################################################
##################################################################################################
<?php
/**
 *
 */
class OpsDashboardAction
{

    public function __construct()
    {
        # code...
    }

    public function init()
    {
        $self = new self;
        
    //generate csv    
        add_action("admin_post_generate_dietary_csv", array($self, 'generateDietaryCsv'));

        add_action("admin_post_generate_hotel_booking_csv", array($self, 'generateHotelBookingCsv'));

    //generate email
        add_action("admin_post_email_hotel_booking", array($self, 'emailHotelBooking'));
        add_action("admin_post_email_transaction", array($self, 'emailTransaction'));

    //generate pdf
        add_action("admin_post_generate_hotel_booking_pdf", array($self, 'generateHotelBookingPdf'));

    }


    public function generateHotelBookingCsv()
    {
        $OpsExport = new OpsExport();
        $hotel_booking = $OpsExport->hotelBooking();
        $timestamp = date("Y-m-d_H:i:s");
        $filename = "Hotel_Booking_".$timestamp.".csv";
        $OpsExport->csv($hotel_booking, $filename);
    }

        public function emailHotelBooking()
    {
        if (!isset($_POST['emailHotelBooking']) || !wp_verify_nonce( $_POST['emailHotelBooking'], 'emailHotelBooking-nonce' )) {
            die("You are not allowed to submit data.");
        }

        $email = sanitize_email( $_POST['email'] );

        $OpsExport = new OpsExport();
        $hotel_booking = $OpsExport->hotelBooking();
        $timestamp = date("Y-m-d_H:i:s");
        $filename = "Hotel_Booking_".$timestamp.".csv";
        $upload_dir = \wp_upload_dir();
        $upload_base_dir = $upload_dir['basedir'];
        $upload_path = $upload_base_dir . '/Hotel_Booking_CSVs';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0700);
        }
        $OpsExport->csv($hotel_booking, $filename, false, $upload_path.'/'.$filename);

        $attachments = [$upload_path.'/'.$filename];
        (new OpsNotification)->send($email, 'Winnipeg Hotel Booking CSV', 'Please download the report', $attachments);
        wp_redirect( $_POST['_wp_http_referer'], 302);
        exit();
    }

    public function generateHotelBookingPdf()
    {
        $OpsPdf = new OpsPdf();
        $OpsPdf->hotelBooking();
    }

}

?>




##################################################################################################
##################################     class-AbstractExport.php   ################################################################
##################################################################################################
##################################################################################################

<?php

/**
 * 
 */
abstract class AbstractExport
{
	
	 public function csv($data, $filename = "export.csv", $direct_download = true, $path = "") {
	 	if($direct_download){
	 		header('Content-Type: application/csv');
	        header('Content-Disposition: attachment; filename="'.$filename.'";');

	        // open the "output" stream
	        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
	        $f = fopen('php://output', 'w');

	        foreach ($data as $line) {
	            fputcsv($f, $line);
	        }
	 	}
	 	else{
	 		 $f = fopen($path, 'w');

	        foreach ($data as $line) {
	            fputcsv($f, $line);
	        }
	 	}
        
    } 

    

}

?>


##################################################################################################
##################################     class-OpsExport.php   ################################################################
##################################################################################################
##################################################################################################

<?php 

/**
 * 
 */
class OpsExport extends AbstractExport
{
	
	protected $db;
	protected $table;
	
	public function __construct()
    {
    	global $wpdb; 

    	$this->db = $wpdb;
        $this->table = $wpdb->prefix . "attendees";
    }


    public function transaction()
    {
        $OpsPayment = new OpsPayment();
        $payments = $OpsPayment->getAllByStatus($search_col, $search_term , $rowPerPage, $offset, 'created_at DESC');

        $report = [];

        $report[] = [
            'Name', 'Payment Date', 'Amount', 'Transaction ID', 'Payment Method', 'Status'
        ];

        foreach ($payments as $payment) {
            $arr = [];

            $arr['Name'] = $payment->first_name.' '.$payment->last_name ;
            $arr['Payment_date'] = $payment->created_at ;
            $arr['Amount'] = $payment->amount ;
            $arr['Transaction_ID'] = $payment->transaction_id ? $payment->transaction_id : '-' ;
            $arr['Payment_method'] = $payment->payment_method ;
            $arr['Status'] = $payment->status ;

            $report[] = $arr; 
        }

        return $report;
    }

    public function hotelBooking()
    {
        $OpsHotelBooking = new OpsHotelBooking();
        $hotel_bookings = $OpsHotelBooking->getHotelBookingInfo();

        $report = [];

        // Header in csv file
        $report[] = [
            'Member First Name', 'Member Last Name', 'Member Email', 'Member Phone', 'Hotel Name', 'Booking ID', 'Room Type', 'Persons', 'Nights', 'Room Rate', 'Stay Value', 'Check-In Date/Time', 'Check-Out Date'
        ];

        foreach ($hotel_bookings as $hotel_booking) {
            $arr = [];

            $arr['Member_first_name'] = $hotel_booking->first_name ;
            $arr['Member_last_name'] = $hotel_booking->last_name;
            $arr['Member_email'] = $hotel_booking->email;
            $arr['Member_phone'] = $hotel_booking->phone;
            $arr['Hotel Name'] = $hotel_booking->name ;
            $arr['Booking ID'] = $hotel_booking->booking_id ;
            $arr['Room Type'] = $hotel_booking->category ;
            $arr['Persons'] = $hotel_booking->persons ;
            $arr['Nights'] = $hotel_booking->nights ;
            $arr['Room Rate'] = $hotel_booking->room_rate ;
            $arr['Stay Value'] = $hotel_booking->stay_value ;
            $arr['Check-In Date/Time'] = $hotel_booking->check_id ;
            $arr['Check-Out Date'] = $hotel_booking->check_out ;

            $report[] = $arr;
        }
        return $report;

    }

    public function flightDetails()
    {
        $OpsFlight = new OpsFlight();
        $flight_details = $OpsFlight->getFlightDetails();

        $report = [];

    // Header in csv file
        $report[] = [
            'Member First Name', 'Member Last Name', 'Member Email', 'Member Phone', 'Arrival Date/Time', 'Arrival Airline', 'Arrival Flight Number', 'Departure Date/Time', 'Departure Airline', 'Departure Flight Number'
        ];    

        foreach ($flight_details as $flight_detail) {
            $arr = [];

            $arr['Member_first_name'] = $flight_detail->first_name ;
            $arr['Member_last_name'] = $flight_detail->last_name;
            $arr['Member_email'] = $flight_detail->email;
            $arr['Member_phone'] = $flight_detail->phone;
            $arr['Arrival_date_time'] = $flight_detail->arrival;
            $arr['Arrival_airline'] = $flight_detail->arrival_airline;
            $arr['Arrival_flight_number'] = $flight_detail->arrival_flight_number;
            $arr['Departure_date_time'] = $flight_detail->departure;
            $arr['Departure_airline'] = $flight_detail->departure_arrival_airline;
            $arr['Departure_flight_number'] = $flight_detail->departure_flight_number;

             $report[]  = $arr;
        }

        return $report;
    }

    public function foodAllergy()
    {
        $OpsAttendee = new OpsAttendee();
        $food_allergies = $OpsAttendee->get(['is_food_allergies' => '1']);

        $report = [];

        //Header in CSV File
        $report[] = ['Member First Name', 'Member Last Name', 'Guest First Name', 'Guest Last Name', 'Food Allergy'];      

        foreach ($food_allergies as $food_allergy) {
            $arr = [];
            $arr['Member_first_name'] =  get_user_meta( $food_allergy->user_id,'first_name', true);
            $arr['Member_last_name'] = get_user_meta( $food_allergy->user_id,'last_name', true);
            $arr['Guest_first_name'] = $food_allergy->type == 'Guest' ? $food_allergy->first_name : '-' ;
            $arr['Guest_last_name'] = $food_allergy->type == 'Guest' ? $food_allergy->last_name : '-' ;
            $arr['Food_allergy'] = $food_allergy->food_allergies;

            $report[] = $arr;
          }  
          return $report;
    }

    public function dietaryRestrictions()
    {
       $OpsAttendee = new OpsAttendee();
       $dietary_restrictions =  $OpsAttendee->get(['is_dietary_restrictions' => '1']);

        $report = [];

    // Header in csv file
        $report[] = [
            'Member First Name', 'Member Last Name', 'Guest First Name', 'Guest Last Name', 'Dietary Restriction'
        ];

        foreach ($dietary_restrictions as $dietary_restriction) {
            $arr = [];

            $arr['Member_first_name'] = get_user_meta( $dietary_restriction->user_id,'first_name', true);
            $arr['Member_last_name'] = get_user_meta( $dietary_restriction->user_id,'last_name', true);
            $arr['Guest_first_name'] = $dietary_restriction->type == 'Guest' ? $dietary_restriction->first_name : '-' ;
            $arr['Guest_last_name'] = $dietary_restriction->type == 'Guest' ? $dietary_restriction->last_name : '-' ;
            $arr['Dietary_restriction'] = $dietary_restriction->dietary_restrictions;

            $report[]  = $arr;
        }

        return $report;
    }


}
?>



##################################################################################################
##################################     class-OpsPdf.php   ################################################################
##################################################################################################
##################################################################################################

<?php
/**
 *##################### CREATED pdf by https://mpdf.github.io/ 
 */
class OpsPdf
{
    protected $mpdf;
    protected $stylesheet;

    public function __construct()
    {
        $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'orientation' => 'L']);
        $this->mpdf->AddPage('L');
        $this->mpdf->shrink_tables_to_fit = 1;

        if (file_exists(OP_VIEW_PATH . "pdf/pdf-style.css")){
            $this->stylesheet = file_get_contents(OP_VIEW_PATH . "pdf/pdf-style.css");
        }

//        $this->mpdf->WriteHTML($this->stylesheet, 1);
    }

    public function transaction($fillterred_data = null)
    {
        $this->setViewContents("transaction");
        $file_name = "Transaction-".date("Y-m-d"). ".pdf";

        if ($fillterred_data['send_by_email']) {
            return $file_path = $this->save($file_name, $fillterred_data);
        }
        else {
            $this->download($file_name);
        }
    }

    public function  flightDetails($fillterred_data = null)
    {
        $this->setViewContents("flight-details");
        $file_name = "Flight-Details-" .date("Y-m-d"). ".pdf";
        if ($fillterred_data['send_by_email']) {
            return $file_path = $this->save($file_name, $fillterred_data);
        }
        else {
            $this->download($file_name);
        }
    }

    public function hotelBooking($fillterred_data = null)
    {
        $this->setViewContents("hotel-booking");
        $file_name = "Hotel-Booking-" .date("Y-m-d"). ".pdf"; //create unique for each download

        if ($fillterred_data['send_by_email']) {
            return $file_path = $this->save($file_name, $fillterred_data);
         } 
         else{
            $this->download($file_name);
         }
    }


    public function foodAllergy($fillterred_data=null)
    {
        $this->setViewContents("food-allergy");
        $file_name = "Food-Allergy-" .date("Y-m-d"). ".pdf";

        if ($fillterred_data['send_by_email']) {
            return $file_path = $this->save($file_name, $fillterred_data);
         } 
         else{
            $this->download($file_name);
         }
    }

    public function dietaryRestriction($fillterred_data = null)
    {
        $this->setViewContents("dietary-restriction");

        $file_name = "Dietary-Restriction-" . date("Y-m-d") . ".pdf";

        if($fillterred_data['send_by_email']){
            return $file_path = $this->save($file_name, $fillterred_data);
        }
        else{
            $this->download($file_name);
        }
    }

    public function setViewContents($view)
    {
        ob_start();
        include_once OP_VIEW_PATH . "pdf/content-{$view}.php";
        $content = ob_get_contents();
        ob_end_clean();
        $this->mpdf->WriteHTML($content);
    }

    public function save($file_name, $fillterred_data)
    {
        $this->mpdf->Output( OP_PATH. $file_name, \Mpdf\Output\Destination::FILE);
        $pdf_path = OP_PATH . $file_name;
        return $pdf_path;
    }

    public function download($file_name)
    {
        $this->mpdf->Output($file_name, \Mpdf\Output\Destination::INLINE);
    }
}
?>

