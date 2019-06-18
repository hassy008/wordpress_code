<?php 
/**
* 

uses 3name must be same 


	add_shortcode( string ('same_name'), callable array($self, 'same_name'));

	public function same_name()
	{
		return get_view(OP_VIEW_PATH."phpfilename.php", compact('var'));
	}

	##############
	then create new page and add the function to specific folder 

	[same_name]

*/

class OpsShortCode
{

	public static function init()
	{
		$self = new self;

		// add_shortcode( string $tag, callable $callback )

		add_shortcode( 'crud1',array($self, 'crud1') );
		add_shortcode( 'crud2',array($self, 'crud2') );
		add_shortcode( 'crud_update', array($self, 'crud_update') );
		add_shortcode( 'crud_delete', array($self, 'crud_delete') );

		add_shortcode( 'crud_action_select',array($self, 'crud_action_select') );
		add_shortcode( 'crud_action_add',array($self, 'crud_action_add') );

		add_shortcode( 'crud_action_add2',array($self, 'crud_action_add2') );
		
		add_shortcode( 'crud_action_edit',array($self, 'crud_action_edit') );
		add_shortcode( 'crud_action',array($self, 'crud_action') );

		add_shortcode( 'users', array($self, 'users') );
		add_shortcode( 'insert_update', array($self, 'insert_update') );

	}

	public function crud()
	{
		echo "string";
	}

	public function crud1()
	{
		return get_view(OP_VIEW_PATH . "crud.php", compact('var'));
	}

	public function crud2()
	{
		return get_view(OP_VIEW_PATH . "create.php", compact('var'));
	}

	public function crud_update()
	{
		return get_view(OP_VIEW_PATH . "update.php", compact('var'));
	}

	public function crud_delete()
	{
		return get_view(OP_VIEW_PATH . "delete.php", compact('var'));
	}

	public function crud_action_select()
	{
		return get_view(OP_VIEW_PATH . "crud_action.php", compact('var'));
	}

	public function crud_action_add()
	{
		return get_view(OP_VIEW_PATH . "crud_action_add.php", compact('var'));
	}

	public function crud_action_add2()
	{
		return get_view(OP_VIEW_PATH . "crud_action_add.php", compact('var'));
	}

	public function crud_action_edit()
	{
		return get_view(OP_VIEW_PATH . "crud_action_edit.php", compact('var'));
	}


	public function users()
	{
		return get_view(OP_VIEW_PATH . "users.php", compact('var'));
	}

	public function insert_update()
	{
		return get_view(OP_VIEW_PATH . "insert_update.php", compact('var'));
	}





	public function ViewEvents() {
		return get_view(OP_VIEW_PATH . "content-dropbox-callback.php", compact('var'));
	}

	
}

?>