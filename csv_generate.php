<?php  

/**
################################        CLASS                    #######################
 */
class OpsDraftSubmission 
{

	protected $db;
	protected $table;
	
	public function __construct()
    {

    	global $wpdb; 

    	$this->db = $wpdb;
        $this->table = $wpdb->prefix . "gf_draft_submissions";
    }

    function getAll()
    {
    	return $this->db->get_results("SELECT * FROM $this->table");
    }

}







#####################################
##########################################      ######          OPSACTION          #############           ##########################################

  //  public static function init()
    {
        $self = new self();

        ##generate_Draft_Submission
        add_action('admin_post_generate_save_and_continue', array($self, 'generateDraftSubmission'));
    }



    function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'";');

            // open the "output" stream
            // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
            $f = fopen('php://output', 'w');

            foreach ($array as $line) {
                fputcsv($f, $line);
            }
        } 

   // public function generateDraftSubmission()
    {

        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        $OpsDraftSubmission = new OpsDraftSubmission();

        $results = $OpsDraftSubmission->getAll();

        $report = [];

    // Header 
        $report[] = [
            'created_at','First Name', 'Last Name', 'Email', 'Room', 'Category', 'Link'
        ];

        foreach ($results as $key => $value) {
            $arr = [];

            $submissions = json_decode($value->submission);
            $submitted = (array) $submissions->partial_entry;

            if(empty($submitted['6'] )) continue;     //if email is empty

           
            $arr['created_at'] = $value->date_created;
            $arr['first_name'] = $submitted['5'];
            $arr['last_name'] = $submitted['4'];
            $arr['email'] = $submitted['6'];
            $arr['room no'] = $submitted['126'];
            $arr['category'] = $submitted['119'];

            $arr['link'] = home_url("/congress-registration?gf_token={$value->uuid}");

            $report[]  = $arr;
        }




        $this->array_to_csv_download($report);
    }


