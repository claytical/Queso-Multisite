<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/
View::composer('posts.menu', function($view){
		//need session id
		if (Sentry::check()) {
			$dropdown_menu = Group::find(Session::get('current_course'))
			->posts()
			->where('menu', '=', 1)
			->get();
			$view->with('items', $dropdown_menu);

		}
		else {
				
		}
});

View::composer('user.sidebar', function($view) {
		$info = new stdClass();

		if(Sentry::check() && Session::get('uid') && Session::get('current_course')) {
			$user = Sentry::user(Session::get('uid'));
			$info->skills = Student::skill_levels(Session::get('uid'), Session::get('current_course'));
			$info->current_level = Student::current_level(Session::get('uid'), Session::get('current_course'));
			if(Course::is_instructor()) {
				$info->is_instructor = TRUE;
				$info->notices = User::find(Session::get('uid'))
									->notices()
									->where('group_id', '=', Session::get('current_course'))
									->where('hidden', '=', 0)
									->count();
								
				//admin only, for now its everywhere
				$submissions = Group::find(Session::get('current_course'))
							->submissions()
							->where('graded', '=', 0)
							->count();
				/*			
				$uploads = Group::find(Session::get('current_course'))
							->uploads()
							->where('graded', '=', 0)
							->count();
				*/
				$info->has_posts = Course::has_posts();
				$info->has_quests = Course::has_quests();
				$info->ungraded = $submissions;// + $uploads;
				if($info->has_posts && $info->has_quests && $info->skills && $info->current_level) {
					$info->setup_complete = TRUE;
				}
				else {
					$info->setup_complete = FALSE;
				}
			}
			else {
				//start student
				$info->is_instructor = FALSE;
				$info->notices = User::find(Session::get('uid'))
									->notices()
									->where('group_id', '=', Session::get('current_course'))
									->where('hidden', '=', 0)
									->count();
				$info->next_level = Student::next_level(Session::get('uid'), Session::get('current_course'));

				$info->completed_quests = User::find(Session::get('uid'))
									->quests()
									->where('group_id', '=', Session::get('current_course'))
									->count();
				
				$info->available_quests = Student::available_quests(Session::get('uid'), Session::get('current_course'));
				
				$info->pending_quests = Student::pending_quests(Session::get('uid'), Session::get('current_course'));
			}			
		}
	else {
		$info = NULL;
	}
		
	$view->with('info',$info);
});


View::composer('user.menu', function($view) {
	if(Sentry::check() && Session::get('uid') && Session::get('current_course')) {
		$user = Sentry::user(Session::get(Config::get('sentry::sentry.session.user')));
		$groups = $user->groups();
		$info = array('user' => $user['user'], 'groups' => $groups);
	}
	else {
		$info = FALSE;
	}

	$view->with('info',$info);
});
Route::get('/', array('uses' => 'home@index'));
Route::get('posts', array('uses' => 'post@index'));
Route::get('comments', array('uses' => 'comment@index'));
Route::post('comments', array('uses' => 'comments@index'));
Route::get('user/new', array('uses' => 'user@new'));
Route::get('login', array('uses' => 'user@login'));
Route::post('login', array('uses' => 'user@login'));
Route::get('user/logout', array('uses' => 'user@logout'));
Route::get('register', array('uses' => 'user@register'));
Route::post('register', array('uses' => 'user@register'));
Route::get('forgot', array('uses' => 'user@forgot_password'));
Route::post('forgot', array('uses' => 'user@forgot_password'));
Route::get('confirm/(:any)/(:any)', array('uses' => 'user@confirm'));
Route::get('register/instructor', array('uses' => 'user@register_instructor'));
Route::post('register/instructor', array('uses' => 'user@register_instructor'));
Route::get('user/changepw', array('uses' => 'user@change_password'));
Route::post('user/changepw', array('uses' => 'user@change_password'));
Route::get('user', array('uses' => 'user@profile'));
Route::get('user/add', array('uses' => 'user@add_course'));
Route::post('user/add', array('uses' => 'user@add_course'));
Route::get('user/preferences', array('uses' => 'user@preferences'));
Route::post('user/preferences', array('uses' => 'user@preferences'));
Route::get('notices', array('uses' =>'notice@index'));
Route::get('notices/hide', array('uses' => 'notice@hide_all'));
Route::get('notice/hide/(:any)', array('uses' => 'notice@hide'));
Route::get('notice/show/(:any)', array('uses' => 'notice@show'));
Route::get('question/ask', array('uses' => 'question@ask'));
Route::post('question/ask', array('uses' => 'question@ask'));
Route::get('question/(:any)', array('uses' => 'question@details'));
Route::post('question/(:any)', array('uses' => 'question@answer'));
Route::get('answer/(:any)/thanks',array('uses' => 'question@thanks'));
Route::get('questions', array('uses' => 'question@index'));
Route::get('quests', array('uses' => 'quest@index'));
Route::get('quests/online', array('uses' => 'quest@available_online'));
Route::get('quests/in-class', array('uses' => 'quest@available_in_class'));
Route::get('quests/completed', array('uses' => 'quest@completed_by_student'));
Route::get('quest/attempt/(:any)', array('uses' => 'quest@attempt'));
Route::post('quest/attempt', array('uses' => 'quest@attempt'));
Route::get('submission/revise/(:any)', array('uses' => 'submission@revise'));

/* what's this doing here?*/
Route::post('quest/revise', array('uses' => 'submission@revise'));

Route::get('submission/view/(:any)', array('uses' => 'submission@view'));
//Route::get('quest/type/(:any)', array('uses' => 'quest@type'));
//Route::get('post/menu', array('uses' => 'post@menu'));
Route::get('post/(:any)', array('uses' => 'post@details'));
Route::get('super/courses', array('uses' => 'course@index'));
Route::get('super/users', array('uses' => 'user@index'));
Route::get('admin/course/remove/(:any)', array('uses' => 'course@remove'));
Route::get('course/(:any)', array('uses' => 'course@course'));

Route::get('admin/user/changepw/(:any)', array('uses' => 'user@change_any_password'));
Route::post('admin/user/changepw', array('uses' => 'user@change_any_password'));

Route::get('admin/posts', array('uses' => 'post@admin'));
Route::get('admin/quests', array('uses' => 'quest@admin'));
Route::get('admin/quests/available/student/(:any)', array('uses' => 'quest@index'));
Route::get('admin/students', array('uses' => 'user@list'));
Route::get('admin/student/deactivate/(:any)', array('uses' => 'user@deactivate'));
Route::get('super/student/deactivate/(:any)', array('uses' => 'user@deactivate'));
Route::get('admin/student/promote/(:any)', array('uses' => 'user@promote'));
Route::get('admin/student/demote/(:any)', array('uses' => 'user@demote'));
Route::get('admin/student/switch', array('uses' => 'user@switch'));
Route::post('admin/student/switch', array('uses' => 'user@switch'));
Route::get('admin/student/details/(:any)', array('uses' => 'user@profile'));
Route::get('admin/course', array('uses' => 'course@setup'));
Route::post('admin/course', array('uses' => 'course@setup'));
Route::get('admin/course/new', array('uses' => 'course@create'));
Route::post('admin/course/new', array('uses' => 'course@create'));
Route::get('admin/course/generate', array('uses' => 'course@generate'));
Route::get('admin/course/share', array('uses' => 'course@share'));
Route::post('admin/course/share', array('uses' => 'course@share'));
Route::post('admin/course/generate', array('uses' => 'course@generate'));
Route::get('admin/post/create', array('uses' => 'post@create'));
Route::post('admin/post/create', array('uses' => 'post@create'));
Route::get('admin/post/update/(:any)', array('uses' => 'post@update'));
Route::post('admin/post/update', array('uses' => 'post@update'));
Route::get('admin/quest/create', array('uses' => 'quest@create'));
Route::post('admin/quest/create', array('uses' => 'quest@create'));
Route::get('admin/quest/clone/(:num)', array('uses' => 'quest@clone'));
Route::post('admin/quest/clone', array('uses' => 'quest@clone'));
Route::get('admin/quest/update/(:any)', array('uses' => 'quest@update'));
Route::post('admin/quest/update', array('uses' => 'quest@update'));
Route::get('admin/quests/completed/(:any)', array('uses' => 'quest@completed_by'));
Route::get('admin/submissions', array('uses' => 'submission@new_submissions'));
Route::get('admin/revisions', array('uses' => 'submission@latest_revisions'));
Route::get('admin/submission/grade/(:any)', array('uses' => 'submission@grade'));
Route::post('admin/submission/grade', array('uses' => 'submission@grade'));
Route::get('admin/grade', array('uses' => 'quest@grade_in_class'));
Route::get('admin/quest/grade/(:any)', array('uses' => 'quest@grade'));
Route::post('admin/quest/grade', array('uses' => 'quest@grade'));
Route::post('admin/student/quest/remove', array('uses' => 'user@remove_quest'));
Route::get('admin/skills', array('uses' => 'skill@index'));
Route::post('admin/skills', array('uses' => 'skill@index'));
Route::get('admin/skill/remove/(:any)', array('uses' => 'skill@remove'));
Route::post('admin/skill/edit', array('uses' => 'skill@edit'));
Route::get('admin/levels', array('uses' => 'level@index'));
Route::post('admin/levels', array('uses' => 'level@index'));
Route::get('admin/level/delete/(:num)', array('uses' => 'level@delete'));
Route::get('admin/post/promote/(:any)', array('uses' => 'post@promote'));
Route::get('admin/post/demote/(:any)', array('uses' => 'post@demote'));
Route::get('admin/post/add-menu/(:any)', array('uses' => 'post@add_to_menu'));
Route::get('admin/post/remove-menu/(:any)', array('uses' => 'post@remove_from_menu'));
Route::get('admin/post/trash/(:any)', array('uses' => 'post@trash'));
Route::get('admin/quest/hide/(:any)', array('uses' => 'quest@hide'));
Route::get('admin/quest/show/(:any)', array('uses' => 'quest@show'));
Route::get('admin/quest/trash/(:any)', array('uses' => 'quest@remove'));
Route::get('admin/course/export', array('uses' => 'course@export'));

Route::filter('sentry', function()
{
	if (!Sentry::check() || !Session::get('current_course')) {
		return Redirect::to('home');
	} 
});
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('pattern: admin/*', 'admin');

Route::filter('pattern: super/*', 'super');
//posts, quests, quest, comments, user, submission, 
Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('admin', function()
{
	if(!Course::is_instructor()) {
		return View::make('user.notinstructor');
	}
});

Route::filter('super', function()
{
	if (!Info::is_super() || !Sentry::check()) {
		return View::make('user.notsuper');
	}
});