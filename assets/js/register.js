usernameField = $("#username-field");
emailField = $("#email-field");
passwordFieldOne = $("#password-field-one");
passwordFieldTwo = $("#password-field-two");
registerButton = $("#register-button");

checkInput = function() {
  if (usernameField.val() != "" && emailField.val() != "" && passwordFieldOne.val() != "" && passwordFieldTwo.val() != "") {
    registerButton.prop("disabled", false);
  } else {
    registerButton.prop("disabled", true);
  }
}

usernameField.keyup(checkInput);
emailField.keyup(checkInput);
passwordFieldOne.keyup(checkInput);
passwordFieldTwo.keyup(checkInput);
