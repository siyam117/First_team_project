<?php
session_start();
if(isset($_SESSION['username'])){
		header('Location: index.php');
}
 $errors ='';
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $pass = hash('sha512', $pass);
		$sent = $_POST['submit'];

        if(!empty($username)){
            $username = strtolower(filter_var($username, FILTER_SANITIZE_STRING));

        }else {
            $errors.= '<li>Please, introduce a username</li>'.'<br>';
        }
        if (!empty($pass)){
            $pass= filter_var(strtolower($pass), FILTER_SANITIZE_STRING);
            hash('sha512',$pass);
        } else {
            $errors.= '<li>Please introduce a password</li>'.'<br>';
        }



	try{
	$connection=new PDO('mysql:host=dbhost.cs.man.ac.uk;dbname=2019_comp10120_z8', 'j69327bw','Year1Project');

	$statement=$connection->prepare('SELECT * FROM users WHERE username = :Username');

	$statement->execute(
		array(':Username'=> $username));


		$results=$statement->fetch();
		if($results==false){
			$errors.= '<li>Username is incorrect</li>';
		}

	$connection2=new PDO('mysql:host=;dbname=', '','');
	$statement2=$connection2->prepare('SELECT Password FROM users WHERE username = :Username');

	$statement2->execute(
		array(':Username'=> $username));


		$passcheck=$statement2->fetch(PDO::FETCH_ASSOC);

		if($passcheck['Password']!=$pass){
		$errors.= '<li>Password is incorrect</li>'.'<br>';
		}


		if(empty($errors)){
			$_SESSION['username'] = $username;
			header('Location: index.php');
		}


	}catch(PDOException $e){
	echo "Error: ".$e->getMessage();

}




}
	require 'login.view.php';
?>
