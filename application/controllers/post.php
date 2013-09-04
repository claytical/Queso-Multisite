<?php


class Post_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	
	/*
	* list of posts that are marked for the front page
	*/ 


	public function get_index() {
		$group = Group::find(Session::get('current_course'));
		if ($group) {
			$posts = Group::find(Session::get('current_course'))
			->posts()
			->where('frontpage', '=', 1)
			->order_by('position', 'desc')
			->order_by('created_at', 'desc')
			->get();
			if ($posts) {
				//need a separate index page for non-logged in people
				return View::make('posts.index')
				->with('posts', $posts);
			}
			else {
				return View::make('posts.index');
			
			}
		}
		else {
			return Redirect::to('login');
		}

	
	}

	/* 
		list of all posts for the administration menu
	
	*/
	public function get_admin() {
		//Msg::add('info', "Admin Page!");

		return View::make('posts.admin')
		->with('posts', Group::find(Session::get('current_course'))
		->posts()
		->get());
	
	}
	
	public function get_update($id) {
		$postInfo = Post::find($id);
		if($postInfo->filename) {
			$encoded_files = explode(",", $postInfo->filename);

			foreach($encoded_files as $file) {
				$files[] = array("encoded" => $file,
							 "friendly" => Filepicker::metadata($file)->filename);
			}
			$postInfo->files = $files;
		}

		return View::make('posts.update')
		->with('post',$postInfo);
		// Post::find($id));
	}
	
	public function post_update() {
		$post = Post::find(Input::get('post_id'));
		$post->headline = Input::get('headline');
		$post->post = Input::get('body');
		$post->menu = Input::has('menuitem');
		$post->frontpage = Input::has('frontpage');
		if (Input::get('existingFiles')) {
			$newFiles = explode(",", Input::get('files'));
			$existingFiles = Input::get('existingFiles');
			$post->filename = implode(",", array_merge($newFiles, $existingFiles));		
		}
		else {
			$post->filename = Input::get('files');
		}
		$post->save();
		return Redirect::to('admin/posts')
		->with_message(Input::get('headline') . " has been updated!", 'success');
	}
	/*
		view post
	*/
	public function get_details($id) {
		return View::make('posts.details')
		->with('post', Post::find($id));
	
	}
	
	/*
		create a post, form
	*/
	public function get_create() {
		return View::make('posts.create');
	}
	
	/* add post to database
	*
	*/
	public function post_create() {

			$post = Post::create(
				array('headline' => Input::get('headline'),
					  'post' => Input::get('body'),
					  'menu' => Input::has('menuitem'),
					  'frontpage' => Input::has('frontpage'),
					  'filename' => Input::get('files'),
					  'user_id' => Session::get('uid'),
					  'group_id' => Session::get('current_course')
					  ));
			return Redirect::to('post/'.$post->id)
				->with_message(Input::get('headline') . " has been created!", 'success');
		
	}
	
	/*
	 *
	 */
	
	public function get_promote($id) {
		$post = Post::find($id);
		if ($post->group_id == Session::get('current_course')) {
			$post->frontpage = TRUE;
			$post->save();
		}
		return Redirect::to('admin/posts');

	}
	
	public function get_demote($id) {
		$post = Post::find($id);
		if ($post->group_id == Session::get('current_course')) {		
			$post->frontpage = FALSE;
			$post->save();
		}
		return Redirect::to('admin/posts');

	
	}
	
	public function get_add_to_menu($id) {
		$post = Post::find($id);
		
		if ($post->group_id == Session::get('current_course')) {		
			$post->menu = TRUE;
			$post->save();
		}

		return Redirect::to('admin/posts');

	}

	public function get_remove_from_menu($id) {
		$post = Post::find($id);
		
		if ($post->group_id == Session::get('current_course')) {		
			$post->menu = FALSE;
			$post->save();
		}

		return Redirect::to('admin/posts');

	}
	
	public function get_trash($id) {
		$post = Post::find($id);
		$headline = $post->headline;
		if ($post->group_id == Session::get('current_course')) {		
			$post->delete();
		}

		return Redirect::to('admin/posts')
		->with_message($headline . " has been deleted!", 'info');
	
	}

	public function get_sticky($id) {
		$post = Post::find($id);
		if ($post->group_id == Session::get('current_course')) {		
			$post->position = 999;
			$post->save();
		}

		return Redirect::to('admin/posts')
		->with_message($post->headline . " has been made sticky!", 'info');
	
	}

	public function get_unstick($id) {
		$post = Post::find($id);
		if ($post->group_id == Session::get('current_course')) {		
			$post->position = 0;
			$post->save();
		}

		return Redirect::to('admin/posts')
		->with_message($post->headline . " has been unstuck!", 'info');
	
	}
	
	
}

?>