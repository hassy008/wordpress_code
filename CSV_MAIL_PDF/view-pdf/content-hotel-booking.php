<style>
table {
	width: 100%;
	border-collapse: collapse;
}

table, th, td {
	border: 1px solid black;
	padding: 8px;
}
table th{
	background-color: #666;
	color: #fff;
	border-bottom-color: #dadada;
	font-weight: bold;
}
table td{
	font-weight: normal;
	font-size: 14px;
}
.logo{
	width: 35%;
	float: left;
}
.title{
	width: 30%;
	text-align: center;
}
.title h1{
	margin: 0;
	padding-bottom: 10px;
}
.title h3{
	margin: 0;
	padding-bottom: 10px;
}
.title .date{
	padding-bottom: 50px;
	margin: 0;
}
</style>
<?php
    $headers = [
        'Member First Name', 'Member Last Name', 'Member Email', 'Member Phone', 'Hotel Name', 'Booking ID', 'Room Type', 'Persons', 'Nights', 'Room Rate', 'Stay Value', 'Check-In Date/Time', 'Check-Out Date'
    ];
   $hotel_bookings =  (new OpsHotelBooking)->getHotelBookingInfo();

?>
<div class="title-wrapper">
	<div class="logo">
		<img src="<?php echo OP_ASSETSURL."images/logo.png"?>" alt="">
	</div>
	<div class="title">
		<h1>Hotel Booking</h1>
		<h3>Winnipeg 2020</h3>
		<div class="date"><?= date("Y-m-d"); ?></div> <!-- Dymanic Date time-->
	</div>
</div>
<table>
	<thead>
		<tr>
			<?php foreach ($headers as $header) : ?>
				<th><?= $header ?></th>
			<?php endforeach; ?>

		</tr>
	</thead>
	<tbody>
	  <?php 
        foreach ($hotel_bookings as $hotel_booking) : ?>
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
		</tr>
	  <?php endforeach; ?>
	</tbody>
</table>