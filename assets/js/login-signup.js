$("form").submit(function(e) {
  e.preventDefault();
  $(".__error").html("");
  $.ajax({
    url: this.action,
    type: this.method,
    dataType: "json",
    data: $(this).serialize(),
    success: function(response) {
      response.status && window.location.reload();
      response.id && $(response.id).html(response.msg);
      response.id && $(response.id.toLowerCase()).focus();
    }
  })
});

$(".show-hide").click(function() {
  $("#password").attr("type") === "password" ?
    ($("#password").attr("type", "text"), $(this).text("hide")) :
    ($("#password").attr("type", "password"), $(this).text("show"));
});