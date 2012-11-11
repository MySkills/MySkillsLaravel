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

Route::get('features', function()
{
	return View::make('pages.features')->with('page','features');
});

Route::get('faq', function()
{
	return View::make('pages.faq')->with('page','faq');
});

Route::get('welcome', function()
{
	return View::make('onboarding.welcome')->with('page','home');
});

Route::get('jobs', function()
{
	return View::make('pages.jobs')->with('page','jobs');
});

/*
Apply for a job. Add a user for a job position.
*/
Route::put('jobs/(:num)/(:num)',
	array(
		'before' => 'auth', 'do' => function($id, $user_id) {
			try {
				$job = Job::find($id);							
				$job->candidates()->attach(Auth::user()->id);				
			 	return Redirect::to('jobs')->with('status','SUCESS!!! You successfully applied for a job position. The recruiter will contact you soon.');
			} catch (Exception $e) {
				return Redirect::to('jobs')->with('status', 'ERROR');
			}			
		}
	)
);

Route::get('leaderboard', function()
{
	return View::make('pages.leaderboard')->with('page','leaderboard');
});

Route::get('badges', function()
{
	return View::make('pages.badges')->with('page','badges');
});

Route::get('users', function()
{
	return View::make('pages.users')->with('page','users');
});


Route::get('checkin/(:any)', 
	array(
		'before' => 'auth', 'do' => function($technology){
			$data = array('technology'  => $technology);
			return View::make('checkin.success', $data)->with('page','checkin.success');
		}
	)
);


Route::get('login', function() {
    return View::make('checkin.login')->with('page','checkin.login');
});


Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::to('login');
});

Route::controller(Controller::detect());

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
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

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

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::to('login');
});

Route::filter('connect', function()
{
	Log::myskills('Filter - Connect'); 
	if (Auth::guest()) return Redirect::to('login');
});