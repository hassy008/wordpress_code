<?php  
	$OpsHotel 	  = new OpsHotel();	
	$OpsHotelRoom = new OpsHotelRoom();
	
	##getRow
	$add_hotels = $OpsHotel->getAll('id');

	$hotel_rooms = $OpsHotelRoom->getAll('id');    
?>

<div class="bootstrap-wrapper">
	<div class="row">
		<div class="col-md-6">
			<div class="hotal-wrapper">
				<div class="hotel-booking-table">
					<div class="text-right form-group">
						<button class="btn btn-danger" data-toggle="modal" data-target="#addHotelModal">Add Hotel</button>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<!-- <th>Price</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($add_hotels as $hotel) {
							?>
							<tr>
								<td class="action"><?= $hotel->id; ?></td>
								<td><?= $hotel->name; ?></td>
								<td class="action">
									<span class="edit-hotel-name" data-toggle="modal" data-target="#addHotelModal" data-id="<?= $hotel->id; ?>"><i class="fa fa-edit"></i></span>
									<span class="delete-hotel-name" data-id="<?= $hotel->id; ?>"><i class="fa fa-trash"></i></span>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
				<div class="hotel-room-table">
					<div class="text-right form-group">
						<button class="btn btn-danger" data-toggle="modal" data-target="#addRoomModal">Add Room</button>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Hotel</th>
								<th>Category</th>
								<th>No of room</th>
								<th>Capacity</th>
								<th>Price</th>
								<th style="text-align: center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($hotel_rooms as $hotel_room) {
							?>
							<tr>
								<td class="action"><?= $hotel_room->id; ?></td>
								<td><?php $hotel = (new OpsHotel)->getRow(['id' => $hotel_room->hotel_id]); echo $hotel->name; ?></td> <!-- 'id' from hotel table id -->
								<td><?= $hotel_room->category; ?></td>
								<td><?= $hotel_room->no_of_room; ?></td>
								<td><?= $hotel_room->capacity; ?></td>
								<td class="price">$<?= $hotel_room->price; ?></td>
								<td class="action">
									<span class="edit-hotel-room" data-toggle="modal" data-target="#addRoomModal" data-id="<?= $hotel_room->id;?>"><i class="fa fa-edit"></i></span>
									<span class="delete-hotel-room" data-id="<?= $hotel_room->id;?>"><i class="fa fa-trash"></i></span>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Add Modal Start-->
<div class="modal fade" id="addHotelModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Hotel</span>
			</div>
			<div class="modal-body">
				<form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
					<input type="hidden" name="action" value="save_hotel">
					<input type="hidden" name="id">
					<?php wp_nonce_field('saveHotelName-nonce', 'saveHotelName');?>
					<?php if (isset($_SESSION['message_hotel'])) : ?>
						<div class="alert alert-<?= $_SESSION['type_hotel'] ?>">
							<?= $_SESSION['message_hotel'] ?>
						</div>
					<?php endif; unset($_SESSION['message_hotel']); unset($_SESSION['type_hotel']);  ?>	

					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="form-group">
								<label for="">Hotel Name</label>
								<input class="form-control" type="text" name="hotel_name" placeholder="Enter hotel name"/>
							</div>
						</div>
					</div>
					<div class="form-group text-right">
						<button class="btn btn-danger" type="submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Add Modal end-->

<!-- Add Room Modal Start-->
<div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Room</span>
			</div>
			<div class="modal-body">
				<?php if (isset($_SESSION['message'])) : ?>
					<div class="alert alert-<?= $_SESSION['type'] ?>">
						<?= $_SESSION['message'] ?>
					</div>
				<?php endif; unset($_SESSION['message']); unset($_SESSION['type']);  ?>	
				<form  class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
					<input type="hidden" name="action" value="save_hotel_room">
					<input type="hidden" name="id">	
					<?php wp_nonce_field('saveHotelRoom-nonce', 'saveHotelRoom');?>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Hotel Name</label>
								<div class="select-wrapper">
									<select class="form-control select-style" name="hotel_name">
										<?php foreach ($add_hotels as $hotel) { ?>
											<option value="<?= $hotel->id?>"><?= $hotel->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Category</label>
								<input type="text" class="form-control" name="category">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Price</label>
								<input type="text" class="form-control" name="price">
							</div>
							<div class="form-group">
								<label for="">Number of Room</label>
								<input type="text" class="form-control" name="no_of_room">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Capacity</label>
								<input type="text" class="form-control" name="capacity">
							</div>
						</div>
					</div>
					<div class="form-group text-right">
						<button class="btn btn-danger" type="submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Add Room Modal end-->




<?php 

###################################                             class OpsDashboardAction                                       ################
class OpsDashboardAction
{

    public function __construct()
    {
        # code...
    }

    public function init()
    {
        $self = new self;
        add_action('admin_post_save_hotel', array($self, 'saveHotel'));
        add_action('admin_post_save_hotel_room', array($self, 'saveHotelRoom'));

    }


    public function saveHotel()
    {
         if (!isset($_POST['saveHotelName']) || !wp_verify_nonce($_POST['saveHotelName'], 'saveHotelName-nonce')) {
            die("You are not allowed to submit data.");
        }

            // echo "<pre>";
            // print_r($_POST);
            // echo"</pre>"; die();

            $OpsHotel     = new OpsHotel(); 
            $data =[];
            $id           = intval($_POST['id']);
            $data['name'] = $_POST['hotel_name'];
            
            //$OpsHotel->insert($data);
            $OpsHotel->updateOrInsert($data, ['id' => $id]);
            
            $_SESSION['type_hotel']    = 'success';
            $_SESSION['message_hotel'] = 'Successfully saved';            
            wp_redirect($_POST['_wp_http_referer']);
            exit();  
    }

    public function saveHotelRoom()
    {
        if (!isset($_POST['saveHotelRoom']) || !wp_verify_nonce($_POST['saveHotelRoom'], 'saveHotelRoom-nonce')) {
            die("You are not allowed to submit data.");
        }

            // echo "<pre>";
            // print_r($_POST);
            // echo"</pre>"; die();
            
        $OpsHotelRoom     = new OpsHotelRoom(); 
        $data =[];
        $id           = intval($_POST['id']);
        $data['hotel_id'] = $_POST['hotel_name'];
        $data['category'] = $_POST['category'];
        $data['price'] = $_POST['price'];
        $data['no_of_room'] = $_POST['no_of_room'];

        $OpsHotelRoom->updateOrInsert($data, ['id' => $id]);
            // echo "<pre>"; print_r($data); echo "</pre>";
        $_SESSION['type']    = 'success';
        $_SESSION['message'] = 'Successfully saved hotel room';            
        wp_redirect($_POST['_wp_http_referer']);
        exit();
  
    }

}
?>


<!--      #####################    ########################        script.js                 ###########################          ###########################                                -->


<script>  
// Hotel room
   
     //$(document).on('click', '.edit-hotel-room', function () {
		$('.edit-hotel-room').on('click', function () {
     	 let id =  $(this).data('id');
          $('#addRoomModal').find("[name='id']").val(id);
         $.ajax({
            url: frontend_form_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_hotel_room', 
                hotel_cat_id: $(this).data('id'), 
                saveHotelRoom: $('#saveHotelRoom').val() ,
            },

        })
            .done(function (response) {
                if(response.success){
                    $("[name=hotel_name]").val(response.data.hotel.hotel_id);
                    $("[name=category]").val(response.data.hotel.category);
                    $("[name=price]").val(response.data.hotel.price);
                    $("[name=no_of_room]").val(response.data.hotel.no_of_room);
                    $("[name=capacity]").val(response.data.hotel.capacity);
                }
            })
            .fail(function () {
                console.log("error");
            })
     });

    // End Hotel room

    //Hotel Name
        $('.edit-hotel-name').on('click', function () {
            let id =  $(this).data('id'); 
            $('#addHotelModal').find("[name='id']").val(id);//$('#addHotelModal')-->class/id Name  .find("[name='id']")--> form <input type="hidden" name="id">	 .val(id)-->let id;
             $.ajax({
                url: frontend_form_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_hotel_name', // used at OpsDashAjaxAction file
                    hotel_name_id: id, 			// [hotel_name_id] is $_POST type from OpsDashAjaxAction file
                    saveHotelName: $('#saveHotelName').val()   // [saveHotelName] nonce field 
                },
            })
                .done(function (response) {
                    if(response.success){
                        $("[name=hotel_name]").val(response.data.hotel_name.name); //$("[name=hotel_name]")--><input type="text" [name]="category">  
                        														//.val(response.data.{hotel_name}.name)-->wp_send_json_success(['hotel_name' => $response]);
                        														//.val(response.data.hotel_name.{name})-->sql column name
                    }
                })
                .fail(function () {
                    console.log("error");
                })
     })
    //End Hotel Name

</script>


<!--      #####################    ########################        class-OpsDashAjaxAction.php      ###########################          ###########################                                -->
<?php
	class OpsDashAjaxAction
{
	
	static public function init()
	{
		$self = new self();
		add_action( "wp_ajax_get_hotel_room", array($self, 'getRoom') );
		add_action( "wp_ajax_get_hotel_name", array($self, 'getName') );
	}


	public function getRoom()
	{

		if (!isset($_POST['saveHotelRoom']) || !wp_verify_nonce($_POST['saveHotelRoom'], 'saveHotelRoom-nonce')) {
            die("You are not allowed to submit data.");
        }

		$hotel_cat_id = intval($_POST['hotel_cat_id']);

		$OpsHotelRoom = new OpsHotelRoom;
		$response = $OpsHotelRoom->getRow(['id' => $hotel_cat_id]);

		wp_send_json_success(['hotel' => $response]);
	}

	public function getName()
	{
		if (!isset($_POST['saveHotelName']) || !wp_verify_nonce($_POST['saveHotelName'], 'saveHotelName-nonce')) {
            die("You are not allowed to submit data.");
        }

        $hotel_name_id = intval($_POST['hotel_name_id']);

        $OpsHotel = new OpsHotel();
        $response = $OpsHotel->getRow(['id' => $hotel_name_id]);

        wp_send_json_success(['hotel_name' => $response]);
	}


}


















