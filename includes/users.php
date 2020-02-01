<?php
Flight::route( 'POST /users/add', function(){
	$db = Flight::db();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$data = array(
	 	'username' => $username,
	 	'password' => md5($password)
	 );

	 $id = $db->insert('users', $data);
	 if ($id)
	     Flight::redirect('users');
	 else
	    echo 'insert failed: ' . $db->getLastError();
});

Flight::route('GET /users/add', function(){
  Flight::view()->set('title', 'Users');
   Flight::render('addusers');

     });

Flight::route( 'GET /users/delete/@username', function($username){
	$db = Flight::db();
	$db ->where('username', $username);
	if($db->delete('users'))
		 Flight::redirect('users');

	});

Flight::route( 'GET /users(/page/@page: [0-9]+)', function($page){
	 Flight::view()->set('title', 'Users');

	 if (empety($page) ) {
	 	$page = 1;
	
	 }

	$db = Flight::db();
	$db->pageLimit = 10; // set limit per page

	$users = $db->arraybuilder()->paginate('users', $page);
    Flight::render( 'users', array(
    	'users' => $users,
    	'page' => $page,
    	'total_pages' => $db->totalPages
    ) );
});