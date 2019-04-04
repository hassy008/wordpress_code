<?php
//totalCount use for pagination
public function totalCount($where = [], $where_not = []) 
    {
        $where_query = ""; //if no condition needed 

        $and = '';
        $cnt = 0;
        if (!empty($where)) {
            foreach ($where as $key => $value){
                if ($cnt > 0) $and = " AND";

                $where_query .= "$and $key = '$value' ";
                $cnt++;
            }
        }
        if (!empty($where_not)) {
            foreach ($where_not as $key => $value){
                if ($cnt > 0) $and = " AND";

                $where_query .= "$and $key != '$value' ";
                $cnt++;
            }
        }
        // $where_query = empty($where_query) ? '' : "WHERE {$where_query}";  //using this line of code when we get data by any specification
        return $this->db->get_col("SELECT count(*) FROM $this->table $where_query");
    }

?>





  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////
    //where you want to use the pagination
-->
<?php
//for pagination we need $total, $offset, $limit(here we use $rowPerPage ), $currentPage
  $total           = null;
  $urlPattern      = '/wp-admin/admin.php?page=payment_history&pg=(:num)'; //'/page_url&pg=(:num)'
  $rowPerPage      = 10;

  $currentPage = isset($_GET['pg']) ? intval($_GET['pg']) : 1; //if isset($_GET['pg']) is not execute when you open first page of pagination OR intval($_GET['pg']) : 1 execute as 1st page of pagination 
  $offset      = ($currentPage - 1) * $rowPerPage;

  $order = new OpsOrder(); //instance class

  $totalCount = $order->totalCount()[0]; // totalCount() from AbstractModule and we can put any logic inside totalCount(logic)

   $OpsPaginator = new OpsPaginator($totalCount , $rowPerPage, $currentPage, $urlPattern);
   $orderHistory = $order->getAll('created_at DESC', $rowPerPage, $offset);
  // echo '<pre>'; print_r($totalCount); echo '</pre>';
?>



  </table>

   <?=  $OpsPaginator->toHtml(); ?> <!-- //toHtml() function on [OpsPaginator() class]
  
    -->
  </div>