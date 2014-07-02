$( "#home" ).click(function() {
      $("#home").addClass("active");
      $("#profile").removeClass("active");
});

$( "#profile" ).click(function() {
      $("#home").removeClass("active");
      $("#profile").addClass("active");
});
    