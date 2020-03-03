<!DOCTYPE html>
<html>
  <head>
    <title>Join Game</title>
  </head>
  <body>
    <form id="homepage-loginbox" action="private_lobby.php" method="post">
    <input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Enter PIN" name="lobby_id">
    <button class="submit-button" id="login-button" type="submit" name="button" >Enter <i class="fas fa-sign-in-alt"></i></button>
  </form>
    <button type="button" name="button" onclick="window.location.href='private_lobby.php'">Create a new game</button>
  </body>
</html>
