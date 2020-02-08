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
    <br>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">   
        <p>Username</p><br> 
        <input type="text" name="username"> <br>
        <p>Password</p> <br>
        <input type="password" name="password"><br>
        <br>

        <?php if(!empty($errors)): ?>
            <div class="error"><?php echo $errors; ?></div>
        <?php endif; ?>

       <button type='submit' name='submit'>Login</button> 
	<a href='register.php'>Register Page</a>
</form> 
</body>
</html> 