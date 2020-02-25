storySectionInputButton = $(".story-section-input-button");
storySectionInputField = $(".story-section-input-field");
storySectionInputForm = $(".story-section-input-form");
storySectionInputClickHere = $(".story-section-input-clickhere");
storySectionInputFormWordCount = $(".story-section-input-form-wordcount");

enableInput = function() {
  storySectionInputButton.css("display", "none");
  storySectionInputField.css("display", "inline");
  storySectionInputForm.css("display", "block")
}
storySectionInputButton.click(enableInput);

updateWordCount = function() {
  currentText = storySectionInputField.val();
  words = currentText.split(" ");
  words = words.filter(function(x){return x !== "";})
  wordCount = words.length;
  wordCountString = storySectionInputFormWordCount.text().split("/")[1];
  wordCountString = wordCount + "/" + wordCountString;
  storySectionInputFormWordCount.text(wordCountString);
}
storySectionInputField.keyup(updateWordCount);
