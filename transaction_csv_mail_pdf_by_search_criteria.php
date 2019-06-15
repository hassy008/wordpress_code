<?php 
$total = null;
$urlPattern = '/dashboard/?section=transactions&pg=(:num)';
$rowPerPage = 40;

$search_col = esc_sql($_GET['search_col']);
$search_term = esc_sql($_GET['search_term']);

$currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
$offset = ($currentPage - 1) * $rowPerPage;

$OpsPayment = new OpsPayment();
$payments = $OpsPayment->getAllByStatus($search_col, $search_term , $rowPerPage, $offset, 'created_at DESC');

$totalCount = $OpsPayment->countAllByStatus($search_col, $search_term , $rowPerPage, $offset, 'created_at DESC')[0];
$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);

?>


<div class="top-wrapper">
	<div class="search-frm-wrapper">
		<form class="form-inline" action="/dashboard/?section=transactions" style="margin-bottom: 15px">
			<div class="form-group">
				<div class="select-wrapper">
					<select class="select-style form-control" name="search_col">
						<option value="amount" <?= $search_col == 'amount' ? ' selected' : '' ?>>Amount</option>
						<option value="transaction_id" <?= $search_col == 'transaction_id' ? ' selected' : '' ?>>Transaction ID</option>
						<option value="status" <?= $search_col == 'status' ? ' selected' : '' ?>>Payment Status</option>
						<option value="payment_method" <?= $search_col == 'payment_method' ? ' selected' : '' ?>>Payment Method</option>
						<option value="first_name" <?= $search_col == 'first_name' ? ' selected' : '' ?>>First Name</option>
						<option value="last_name" <?= $search_col == 'last_name' ? ' selected' : '' ?>>Last Name</option>
						<option value="created_at" <?= $search_col == 'created_at' ? ' selected' : '' ?>>Created at</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="search_term" value="<?= $search_term ?>">
			</div>
			<button type="submit" class="btn btn-danger dashboard-transaction-search">Search</button>
		</form>
	</div>
	<div class="add-transaction-right pull-right">
		<div class="btn btn-danger" data-toggle="modal" data-target="#addTransactionModal">Add Transaction</div>
	</div>
</div>
<div class="text-right form-group">
	<a href="<?= admin_url('admin-post.php?action=generate_transaction_csv&search_col='.$_GET['search_col'].'&search_term='.$_GET['search_term']); ?>" class="export-btn"><span class="fa fa-file-excel-o"></span> Export As CSV</a>
	<a href="<?= admin_url('admin-post.php?action=generate_transaction_pdf&search_col='.$_GET['search_col'].'&search_term='.$_GET['search_term']); ?>" class="export-btn"><span class="fa fa-file-pdf-o"></span> Export As PDF</a>
	<div class="export-btn mr-0" data-toggle="modal" data-target="#sentByEmail"><span><i class="fa fa-envelope-o"></i></span> Send By Email</div>
</div>


<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Payment Date</th>
			<th>Amount</th>
			<th>Transaction ID</th>
			<th>Payment Method</th>
			<th>Notes</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; foreach ($payments as $payment) : 
		$name = trim($payment->first_name .' '. $payment->last_name);
		?>
		<tr>
			<td><?= ++$i.'.'; ?></td>
			<td><?= $name ? $name : '-' ?></td>
			<td><?= $payment->created_at; ?></td>
			<td class="price"><?= $payment->amount; ?></td>
			<td><?= $payment->transaction_id ? $payment->transaction_id : '-'; ?></td>
			<td><?= $payment->payment_method; ?></td>
			<td class="action"><span data-toggle="modal" data-target="#viewNoteModal"><i class="fa fa-file-text-o"></i></span></td>
			<td><span class="label label-<?= $payment->status == 'paid' ? 'success' : 'warning' ?>"><?= ucwords($payment->status); ?></span></td>
			<td class="action">
				<span data-toggle="modal" data-target="#addNoteModal"><i class="fa fa-file-text-o"></i></span>
				<span data-toggle="modal" data-target="#addTransactionModal"><i class="fa fa-edit"></i></span>
				<span><i class="fa fa-trash"></i></span>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
    <?=$OpsPaginator->toHtml();?>



<!-- Add transaction Modal Start-->
<div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Transaction</span>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label for="">Amount</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Payment Date</label>
							<input type="text" id="checkDAta" class="form-control datepicker">
						</div>
						<div class="form-group">
							<label for="">Transaction ID</label>
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="text-right">
					<div class="btn btn-danger">Save</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add transaction Modal end-->



<!-- Add Note Modal Start-->
<div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Add Note</span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<textarea name="" id="" cols="30" rows="10" class="form-control" placeholder="Add Your Note"></textarea>
				</div>
				<div class="text-right">
					<div class="btn btn-danger">Save</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Note Modal end-->


<!-- View Note Modal Start-->
<div class="modal fade" id="viewNoteModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Your Notes</span>
			</div>
			<div class="modal-body">
				<div class="single-notes">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque porro incidunt error nostrum, labore saepe pariatur similique officia voluptatem! Repellendus iure commodi aliquid nemo nisi rerum quasi sunt, ducimus libero!</p>
				</div>
				<div class="single-notes">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque porro incidunt error nostrum, labore saepe pariatur similique officia voluptatem! Repellendus iure commodi aliquid nemo nisi rerum quasi sunt, ducimus libero!</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- View Note Modal end-->


<!-- Modal Start-->
<div class="modal fade" id="sentByEmail" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title">Send Email</span>
			</div>
			  <form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
		  		<input type="hidden" name="action" value="email_transaction">
		  		<?php wp_nonce_field('emailTransaction-nonce', 'emailTransaction'); ?>
			<div class="modal-body">
				<div class="form-group">
					<label>Send Email</label>
					<input type="email" class="form-control" name="email">
				</div>
				<div class="text-center">
					<button class="btn btn-danger" type="submit">Send</button>
				</div>
			</div>
		  </form>

		</div>
	</div>
</div>
<!-- Modal end-->









##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       cls-OpsPayment.php                                           ########################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################

<?php
/**
 * Created by PhpStorm.
 * User: Mehedee
 * Date: 1/5/2019
 * Time: 12:22 PM
 */

class OpsPayment extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->prefix . "payments";      
        $this->usermeta = $this->db->prefix . "usermeta";
    }

    public function generateToken()
    {
    	return bin2hex( openssl_random_pseudo_bytes(32) );
    }

    public function paidTotalByUser($user_id)
    {
        $ebp = $this->db->prefix . "early_bird_payment";
        $eb = $this->db->prefix . "early_bird_booking";
//         return $this->db->get_row("SELECT SUM(amount) as total FROM $this->table WHERE user_id = $user_id AND (status = 'paid' or status = 'completed')");
        return $this->db->get_row(" 
            SELECT SUM(p.amount) as total
            FROM $this->table AS p
            LEFT JOIN $ebp AS ebp
            ON p.id =  ebp.payment_id
            LEFT JOIN $eb AS eb
            ON eb.id =  ebp.early_bird_booking_id
            WHERE (eb.make_a_deposit != 'For a Club or National Committee' OR eb.make_a_deposit IS NULL)
            AND p.user_id = $user_id AND (p.status = 'paid' or p.status = 'completed')"
        );
    }

    public function getAllByStatus($search_col = '', $search_term = '', $limit = 0, $offset = 0, $order_by = null)
    {
        $query = "";

        if($order_by != null){
            $query .= " ORDER BY p.$order_by ";
        }

        if($limit > 0){
            $query .= " LIMIT $limit OFFSET $offset ";
        }


        $meta_query = "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'first_name' AND $this->usermeta.user_id = p.user_id) AS first_name ,";     
        $meta_query .= "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'last_name' AND $this->usermeta.user_id = p.user_id) AS last_name";

        $fields = "p.*, $meta_query";

        $where  = "";

        if (!empty($search_col)) {
            $where = "WHERE {$search_col} LIKE '%$search_term%'";
        }

        $query = "SELECT $fields FROM $this->table AS p 
        {$where} {$query}";

        return $this->db->get_results($query);
    }

    public function countAllByStatus($search_col = '', $search_term = '', $limit = 0, $offset = 0, $order_by = null)
    {
        $query = "";

        if($order_by != null){
            $query .= " ORDER BY p.$order_by ";
        }

        if($limit > 0){
            $query .= " LIMIT $limit OFFSET $offset ";
        }


        $meta_query = "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'first_name' AND $this->usermeta.user_id = p.user_id) AS first_name ,";     
        $meta_query .= "(SELECT meta_value FROM $this->usermeta WHERE meta_key = 'last_name' AND $this->usermeta.user_id = p.user_id) AS last_name";

        $fields = "count(*)";

        $where  = "";

        if (!empty($search_col)) {
            $where = "WHERE {$search_col} LIKE '%$search_term%'";
        }

        $query = "SELECT $fields FROM $this->table AS p 
        {$where} {$query}";

        return $this->db->get_col($query);
    }

    function getUserBalance($user_id) {
        $OpsItem 	               = new OpsItem();
        $items                     = $OpsItem->itemTotalByUser($user_id);
        $items_total               = $items->itemsTotal;
        $processing_fee_percentage = .035;
        $processing_fee_total 	   = $items_total * $processing_fee_percentage;
        $grand_total               = $items_total + $processing_fee_total;
        $payments                  = $this->paidTotalByUser($user_id);

        $paid_total                = $payments->total;
        return $grand_total - $paid_total;
    }
}

?>





##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       cls-OpsDashboardAction.php                                           ########################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################
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
        add_action("admin_post_generate_transaction_csv", array($self, 'generateTransactionCsv'));

    //generate email
        add_action("admin_post_email_transaction", array($self, 'emailTransaction'));

    //generate pdf
        add_action("admin_post_generate_transaction_pdf", array($self, 'generateTransactionPdf'));

    }

    public function emailTransaction()
    {
        if (!isset($_POST['emailTransaction']) || !wp_verify_nonce( $_POST['emailTransaction'], 'emailTransaction-nonce' )) {
            die("You are not allowed to submit data.");
        }
        
        //
        $search_col = esc_sql($_GET['search_col']);
        $search_term = esc_sql($_GET['search_term']);

        $email = sanitize_email($_POST['email']);

        $OpsExport = new OpsExport();
        $transaction = $OpsExport->transaction($search_col, $search_term);
        $timestamp = date("Y-m-d_H:i:s");
        $filename = "Transaction-".$timestamp.".csv";
        $upload_dir = \wp_upload_dir();
        $upload_base_dir = $upload_dir['basedir'];
        $upload_path = $upload_base_dir . '/Transaction_CSVs';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0700);
        }

        $OpsExport->csv($transaction, $filename, false, $upload_path.'/'.$filename);

        $attachments = [$upload_path.'/'.$filename];
        (new OpsNotification)->send($email, 'Winnipeg Transaction CSV', 'Please download the report', $attachments);

        wp_redirect( $_POST['_wp_http_referer'], 302);
        exit();
    }

    public function generateTransactionCsv()
    {

        $search_col = esc_sql($_GET['search_col']);
        $search_term = esc_sql($_GET['search_term']);

        $OpsExport = new OpsExport();
        $transaction = $OpsExport->transaction($search_col, $search_term);
        $timestamp = date("Y-m-d_H:i:s");
        $filename = "Transaction-".$timestamp.".csv";
        $OpsExport->csv($transaction, $filename);
    }

        public function generateTransactionPdf()
    {

        $search_col = esc_sql($_GET['search_col']);
        $search_term = esc_sql($_GET['search_term']);

        $OpsPdf = new OpsPdf();
        $OpsPdf->transaction($search_col, $search_term);
    }
}

?>








##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       cls-OpsExport.php                                           ########################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################


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

   public function transaction($search_col, $search_term)
    {
        $OpsPayment = new OpsPayment();
        $payments = $OpsPayment->getAllByStatus($search_col, $search_term , 0, 0, 'created_at DESC');

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

}

?>






##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       cls-AbstractExport.php                                           #############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################

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

##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       cls-OpsPdf.php                                           ########################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################


<?php
/**
 *
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

    public function transaction($search_col, $search_term)
    {

        $this->setViewContents("transaction", $search_col, $search_term);
        $file_name = "Transaction-".date("Y-m-d"). ".pdf";

        if ($fillterred_data['send_by_email']) {
            return $file_path = $this->save($file_name, $fillterred_data);
        }
        else {
            $this->download($file_name);
        }
    }


    public function setViewContents($view, $search_col = null, $search_term = null)
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



##############################################################################################################################################################################################################################################################################################################################################################################################################################################################################################       view->content-transaction.php                                           ########################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################################
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
        'Name', 'Payment Date', 'Amount', 'Transaction ID', 'Payment Method', 'Status'
    ];
   // $payments =  (new OpsPayment)->getAllByStatus($search_col, $search_term , $rowPerPage, $offset, 'created_at DESC');
   $payments =  (new OpsPayment)->getAllByStatus($search_col, $search_term , 0, 0, 'created_at DESC');

?>
<div class="title-wrapper">
	<div class="logo">
		<img src="<?php echo OP_ASSETSURL."images/logo.png"?>" alt="">
	</div>
	<div class="title">
		<h1>Transactions</h1>
		<h3>Winnipeg 2020</h3>
		<div class="date"><?= date("d.m.Y"); ?></div>
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
        foreach ($payments as $payment) : ?>
		<tr>
			<td><?= $payment->first_name.' '.$payment->last_name ; ?></td>
			<td><?= $payment->created_at; ?></td>
			<td><?= $payment->amount; ?></td>
			<td><?= $payment->transaction_id ? $payment->transaction_id : '-'; ?></td>
			<td><?= $payment->payment_method; ?></td>
			<td><?= $payment->status; ?></td>
		</tr>
	  <?php endforeach; ?>
	</tbody>
</table>