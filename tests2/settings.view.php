<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
	</head>
    <body>
        <h>Create a new story</h><br>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>Title:</p>
        <input type="text" name="title"> <br>
        <p>Number of Sections:</p>
        <input type="text" name="num_sec"> <br>
        <p>Section Length:</p>
        <input type="text" name="sec_length"> <br>
        <button type='submit' name='submit2'>Create story</button>
        <br>
        <br>

        <a href="feed.php">Cancel</a><br>
        <a href="logout.php">Log out</a><br>

</form>
</body>
</html>
