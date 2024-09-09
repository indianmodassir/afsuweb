function enableHits() {
  $(".opts li").click(function() {
    $(this).find(":radio")[0].checked=true;

    const self = $(this);
    const id = $(this).find(":checked").val();
    const choosed = self.find(":checked").attr("data-index");

    $.ajax({
      url: '/assets/server/checks.php',
      type: 'post',
      data: {id, choosed},
      success: function(res) {
        self.parents(".ques").addClass("disabled");
      }
    });
  });
}

function questionLoader(data) {
  $.ajax({
    url: '/assets/server/question_loader.php',
    data: data || {},
    type: 'post',
    dataType: "json",
    success: function(res) {
      if (res.question) {
        $(".container").html(res.question);
        enableHits();
      }
      if (res.timer) {
        var interval = window.setInterval(function() {
          var date = new Date();
  
          var hour = date.getHours();
          hour = hour < 10 ? "0" + hour : hour;
          var minute = date.getMinutes();
          minute = minute < 10 ? "0" + minute : minute;
          var sec = date.getSeconds();
          sec = sec < 10 ? "0" + sec : sec;
          var time = `${hour}:${minute}:${sec}`;

          if (!res.question) {
            $(".container").html(`<div style="text-align:center;"><h2>START ON: ${res.timer} – ${time}</></h2></div>`);
          }
  
          if (time==res.timer) {
            clearInterval(interval);
            questionLoader({load:true});
          }
        }, 1000);
      }
    }
  });
}
questionLoader({load:true});