<?php
session_start();
if(isset($_SESSION['username'])){
		header('Location: index.php');
}

$errors ='';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];
		$pass2 = $_POST['password2'];
		$email = $_POST['email'];
		$bday = $_POST['bday'];

		if ($pass != $pass2){
			$errors.= '<li>Passwords do not match</li>'.'<br>';
		}

        if(!empty($username)){
        	$username = strtolower(filter_var($username, FILTER_SANITIZE_STRING));

        }else {
        	$errors.= '<li>Please introduce a username</li>'.'<br>';
        }

        if(!empty($email)){
        	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
        }else {
        	$errors.= '<li>Please introduce an email</li>'.'<br>';
        }

        if(empty($bday)){

            $errors.= '<li>Please introduce a birthday</li>'.'<br>';
        }

        if (!empty($pass)){
            $pass= filter_var($pass, FILTER_SANITIZE_STRING);
            $pass= hash('sha512',$pass);
        } else {
            $errors.= '<li>Please introduce a password</li>'.'<br>';
        }


		if (!empty($pass2)){
            $pass2= filter_var($pass2, FILTER_SANITIZE_STRING);
            $pass2= hash('sha512',$pass2);
        } else {
            $errors.= '<li>Please confirm your password</li>'.'<br>';
        }

	try{
	$connection=new PDO('mysql:host=localhost;dbname=desznajc_test', 'desznajc','h5va{X<dL*');
	$statement=$connection->prepare('SELECT * FROM users WHERE username = :Username');

	$statement->execute(
		array(':Username'=> $username));

	$results=$statement->fetch();
	if($results==true){
		$errors.= '<li>Username already exists</li>'.'<br>';
	}

	}catch(PDOException $e){
	echo "Error: ".$e->getMessage();

}

	if(empty($errors)){
		$statement = $connection->prepare("INSERT INTO users (Username,Password,Email,Birthday) VALUES('$username', '$pass', '$email', '$bday')");
		$statement->execute(
		array(':Username'=> $username, ':Password'=> $pass, ':Email'=> $email, ':Birthday'=> $bday));
		header('Location: login.php');
		}



}

require 'register.view.php';
?>
