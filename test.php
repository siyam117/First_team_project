<!DOCTYPE html>
<html>
	<head>
	  <title>Register</title>
	  <style>
	      #myForm
	      {
	      font-family: Verdana;
	      font-size: 16pt;
	      margin-top: 12px;
	      background-color: yellow;
	      border: solid 2px red;
	      padding: 15px;
	      height: 260px;
	      width: 510px;
	      }
	      #myForm label
	      {
	      display:block;
	      text-align: right;
	      padding-right: 15px;
	      margin-bottom: 10px;
	      width: 175px;
	      float:left;
	      }
	      #myForm input
	      {
	      display:block;
	      float: left;
	      width: 300px;
	      margin-bottom: 10px;
	      font-size: 16pt;
	      }
	      #myForm button
	      {
	      background-color: blue;
	      color: white;
	      height: 60px;
	      width: 500px;
	      font-size:24pt;
	      border: solid 2px red;
	      }
	  </style>
	</head>
	<body>
	  <h1>Registration Page</h1>
	  <?php 
	  if (!isset($_POST['id']))
	  {
	    echo("<p>Please complete the form to register.</p>");
	    getUserDetails();
	  }
	  else
	    processUserDetails();
	  ?>
	</body>
</html> 
<?php
  function getUserDetails()
  {
	  $id = $email = $pw = "";
	  if (isset($_POST['id']))
	  {
		  $id = $_POST['id'];
		  $pw = $_POST['pw'];
	  }
	  $regForm = "
	  <div id='myForm'>
	    <form method='POST' action='register.php'>
		   <label>UserId:</label> <input type='text' name='id' id='id' value='$id' required>
		   <label>Email:</label> <input type='email' name='email' id='email' required>
		   <label>Confirm Email:</label> <input type='email' name='cemail' id='cemail' required>
		   <label>Password:</label> <input type='password' name='pw' 'value='$pw' required>
		   <button>Register</button>
	    </form>
	  </div>
      ";

	  echo ($regForm);
  }
  function processUserDetails()
  {
    $testMsgs = true; //true = On, false = off.
    $servername = "dbhost.cs.man.ac.uk";
    $username = "c73984rz";
    $password = "renhua1004";
    $database = "2019_comp10120_z8";
    
    require_once('config.inc.php');
    
    $mysqli = new mysqli($servername, $username, $password, $database);
    $frmID = $_POST['fn'];
    $frmEM = $_POST['email'];
    $frmPW = $_POST['pw'];
    $frmConfirmEM = $_POST['cemail'];
    
    $password = password_hash($frmPW, PASSWORD_DEFAULT);
    if ($frmEM !== $frmConfirmEM)
    {
	    echo("Email address does not match confirm email address. Try again");
	    getUserDetails();
     }
     else
     {
	     $sql = "INSERT INTO user (id, email, password)
		 VALUES ('$frmID', '$frmEM', '$frmPW')  ";
	     $result = doSQL($conn, $sql, $testMsgs);
	     if (strpos($result, 'Duplicate entry') !== false)
	     {
		     echo ("The email address you provided is already in use. Try again");
		     getUserDetails();
	      }
     }
  }

  function doSQL($conn, $sql, $testMsgs)
  {
	  if ($testMsgs) echo ("<br><code>SQL: $sql</code>");
	  if ($result = $conn->query($sql))
	  {
			  if ($testMsgs) echo ("<code> - OK</code>");
		  }
	  else
		  {
			  if ($testMsgs) echo ("<code> - FAIL! " . $conn->error . "</code>");
			  $result = $conn->error;
	  }
	  return $result;
  }
?>
