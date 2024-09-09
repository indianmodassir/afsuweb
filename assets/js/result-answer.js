generateCaptcha();

function generateCaptcha() {
  var first, second;

  (first = $.random(2)) && $(".captcha-1").text(first);
  (second = $.random(2)) && $(".captcha-2").text(second);
  $("#_captcha").val(first + second);
}

$("form").submit(function(e) {
  e.preventDefault();
  $(".__error").html("");
  $.ajax({
    url: this.action,
    type: this.method,
    data: $(this).serialize(),
    dataType: "json",
    success: function(response) {
      response.data && $(".container").html(response.data);
      response.id && $(response.id).html(response.msg);
      response.id && $(response.id.toLowerCase()).focus();
    }
  })
});