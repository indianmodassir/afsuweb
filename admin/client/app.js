$("form").submit(function(e) {
  e.preventDefault();
  $(":radio:checked").val($(":radio:checked").next().val() || $(":radio:checked").val());
  $(".status").removeClass("error success").html("");
  $.ajax({
    url: this.action,
    type: this.method,
    data: $(this).serialize(),
    dataType: "json",
    success: function(res, s) {
      res.type===s && $("form")[0].reset();
      $(".status").addClass(res.type).html(res.msg);
      res.class && $(res.class).find("div").html(res.value);
    }
  });
});