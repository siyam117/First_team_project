animationStylesheet = $("#animation-stylesheet");
titleToggleButton = $("#title-toggle-button");

toggleTitleAnimation = function() {
  currentStylesheet = animationStylesheet.attr("href");
  if (currentStylesheet == "assets/css/title_animation.css") {
    animationStylesheet.attr("href", "assets/css/title_animation_test.css");
  } else if (currentStylesheet == "assets/css/title_animation_test.css") {
    animationStylesheet.attr("href", "assets/css/title_animation.css");
  }
}

titleToggleButton.click(toggleTitleAnimation);
