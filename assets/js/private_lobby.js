var usernames_box = $(".usernames-box");


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


var lobby_id = getUrlVars()["id"];



function infiniteRefresh(){
  $.post("assets/js/private_lobby_fetch.php", {id: lobby_id}, function(data, status){
    usernames_box.html(data);
  });

  setTimeout(infiniteRefresh, 2000);
}

infiniteRefresh();
