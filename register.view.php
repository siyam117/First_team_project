<!DOCTYPE html> 
<html> 
    <head>
        <meta charset="UTF-8">  
        <title></title>
        <style>
            .error{
                color:red;
            }
			</style>
	</head>
    <body> 
       <br><br>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">   
        <p>Username:</p><br> 
        <input type="text" name="username"> <br>
        <p>Password:</p><br>
        <input type="password" name="password"><br>
		<p>Confirm Password:</p> <br>
        <input type="password" name="password2"><br>
        <p>Email:</p><br>
        <input type="email" name="email"><br>
        <p>Birthday:</p><br>
        <input type="date" name="bday"><br>
        <br>
        <br>

        <?php if(!empty($errors)): ?>
            <div class="error"><?php echo $errors; ?></div>
        <?php endif; ?>

        <button type='submit' name='submit'>Register</button>
		<a href='login.php'>Login Page</a>
</body>
</html> 