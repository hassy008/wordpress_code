<?php  
	$OpsAttendee = new OpsAttendee();
	$dietary_restrictions = $OpsAttendee->get(['is_dietary_restrictions' => '1']);
?>

<div class="form-group text-right">
	<a href="<?= admin_url('/admin-post.php?action=generate_dietary_csv')?>" class="export-btn"><span class="fa fa-file-excel-o"></span> Export As CSV</a> 
	<a href="" class="export-btn"><span class="fa fa-file-pdf-o"></span> Export As PDF</a>
	<div class="export-btn" data-toggle="modal" data-target="#sentByEmail"><span><i class="fa fa-envelope-o"></i></span> Send By Email</div>
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
				<!-- <td><?= $dietary_restriction->get; ?></td> -->
				<td><?= $dietary_restriction->type == 'Member' ? $dietary_restriction->first_name : ($dietary_restriction->type == 'Guest' ? get_user_meta( $dietary_restriction->user_id,'first_name',true) : '') ?></td>


				<td><?= $dietary_restriction->type == 'Member' ? $dietary_restriction->last_name : ($dietary_restriction->type == 'Guest' ? get_user_meta( $dietary_restriction->user_id,'last_name',true) : '') ; ?></td>
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



<!--
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
										Inside Abstract Folder create new Abstract Module	[class-AbstractExport.php]
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
-->
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

<!--
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
															class-OpsExport.php
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
-->


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
        $this->table = $wpdb->prefix . "c42scx_attendees";
    }

    function getAll()
    {
    	return $this->db->get_results("SELECT * FROM $this->table");
    }


}

?>

<!--
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
															OpsAction.php
####################################################################################################################################################
####################################################################################################################################################
####################################################################################################################################################
-->
<?php

	class OpsAction
	{

		
    public static function init()
    {
        $self = new self;
        add_action("admin_post_generate_dietary_csv", array($self, 'generateDietaryCsv'));
    }

      public function generateDietaryCsv()
    {

       $OpsAttendee = new OpsAttendee();
       $dietary_restrictions =  $OpsAttendee->get(['is_dietary_restrictions' => '1']);
           // echo "<pre>";
           // print_r($dietary_restrictions);
           // echo"</pre>";
           // die;

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
        //$this->csv($report);    
        (new OpsExport)->csv($report);
    }

}

?>    






