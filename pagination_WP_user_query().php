<?php 

#### pagination began
	$urlPattern = '/dashboard/?section=members&pg=(:num)';
	$rowPerPage = 40;
	$currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
	$offset = ($currentPage - 1) * $rowPerPage;

	$args = array(
	'offset'       => $offset,
	'number'       => $rowPerPage, 
	'count_total'  => true,
	'fields'       => 'all',
 ); 
#### pagination 

	$wp_user_query = new WP_User_Query( $args );
	$members = $wp_user_query->get_results();
	$totalCount = $wp_user_query->get_total(); //#### pagination end in here

	$OpsPaginator = new OpsPaginator($totalCount, $rowPerPage, $currentPage, $urlPattern);
?>




<!-- ####before the code ending -->

	<?= $OpsPaginator->toHtml(); ?>