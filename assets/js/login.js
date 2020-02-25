usernameField = $("#username-field");
passwordField = $("#password-field");
loginButton = $("#login-button");

checkInput = function() {
  if (usernameField.val() != "" && passwordField.val() != "") {
    loginButton.prop("disabled", false);
  } else {
    loginButton.prop("disabled", true);
  }
}

usernameField.keyup(checkInput);
passwordField.keyup(checkInput);
