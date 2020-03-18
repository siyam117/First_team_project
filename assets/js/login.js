inputFields = $(".input-login");
loginButton = $(".btn-login");

checkInput = function() {
  if (inputFields.eq(0).val() != "" && inputFields.eq(1).val() != "") {
    loginButton.prop("disabled", false);
  } else {
    loginButton.prop("disabled", true);
  }
}

inputFields.keyup(checkInput);
