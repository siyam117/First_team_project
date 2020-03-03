<!DOCTYPE html>
<html>
  <head>
    <title>Join Game</title>
  </head>
  <body>
    <form action="private_lobby.php" method="post">
      <input type="text" autocomplete="off" placeholder="Enter PIN" name="lobby_id">
      <button type="submit" name="button" >Enter</button>
    </form>
    <button type="button" name="button" onclick="window.location.href='private_lobby.php'">Create a new game</button>
  </body>
</html>
