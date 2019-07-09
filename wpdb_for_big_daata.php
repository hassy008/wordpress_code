<?php

/**
 *
	using action for testing 

 */

require_once OP_PATH . "inc/vendor/leafo/scssphp/scss.inc.php";

define('BULK_DATA_API', 'http://axisws.idxre.com:8080/axis2/services/IHFPartnerServices?wsdl');
class OpsAction
{
	private $username;
	private $password;
	public function __construct()
	{

		$this->username = 'DemoTest'; // your iHomefinder account username
		$this->password = 'testihf2013'; // your iHomefinder account password
	}
	public static function init()
	{
		$self = new self;

		add_action('admin_post_properties_modified_date', array($self, 'propertiesModifiedDate'));
	}

	public function propertiesModifiedDate()
	{

/*//		ini_set('display_errors', 1);
//		ini_set('display_startup_errors', 1);
//		error_reporting(E_ALL);

		// $date = new DateTime();
		//	$date->setTimestamp(mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

		//$date = date('Y-m-d H:i:s', strtotime("-1 days"));  // 1 day ago

		$args = array(
			'post_status'   => 'publish',
			'posts_per_page' => -1,
			'orderby'      => 'date',
			'order'        => 'DESC',
			'post_type'        => 'estate_property',
            'date_query' => array(
                'before' => '2019-06-28'
            ),
			// 'date_query' => array(
			// 	'before' => array(
			// 		'year' => $date->format('Y'),
			// 		'month' => $date->format('m'),
			// 		'day' => $date->format('d')
			// 	)
			// )
		);*/

//		$query = get_posts($args);

		// using $WPDB for BIG DATA 
		// CONDITION: post_type = 'estate_property' and show all the [modified data] before 2019-06-28
        global $wpdb;
        $query =  $wpdb->get_results( "SELECT * FROM $wpdb->posts where post_status = 'publish' and post_modified < '2019-06-28' and post_type = 'estate_property' ORDER BY post_modified DESC " );


		echo "<pre>";
//		print_r($query);
		print_r(count($query));
		echo "</pre>";
	}









	#################################################################
	http://demo.scoutrealty.com/wp-admin/admin-post.php?action=properties_modified_date
