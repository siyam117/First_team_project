var message_input = $(".message-sender .input-field");
var message_button = $(".message-sender .btn-standard");
var messages_box = $(".messages-container");
var usernames_box = $(".usernames-container");



function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


var lobby_id = getUrlVars()["id"];






function sendMessage(){
  message = message_input.val();

  $.post("assets/js/private_lobby_ajax.php", {id: lobby_id, message: message}, function(data, status){
    console.log(data);
    console.log(status);
  });

  message_input.val("");
}

message_button.click(sendMessage);



function infiniteRefresh(){
  $.post("assets/js/private_lobby_ajax.php", {id: lobby_id, reason: "players"}, function(data, status){
    usernames_box.html("Players:" + data);
  });

  $.post("assets/js/private_lobby_ajax.php", {id: lobby_id, reason: "messages"}, function(data, status){
    messages_box.html(data);
  });

  setTimeout(infiniteRefresh, 1000);
}

infiniteRefresh();
