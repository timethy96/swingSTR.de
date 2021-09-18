var cScr;

function open_overlay () {
    var id = this.id;
    $('#overlay_content').load(id + ".php");
    $('#overlay').css("display","block");
    if (id == "add_event"){
      setTimeout(function(){
        hcaptcha.render('h-captcha', {
          sitekey: '027fb1df-5ecd-4ac6-a20c-53208b082a83',
        });
      },1000);
      
    };
};

function close_overlay() {
    $('#overlay').css("display","none");
}

function add_event_01(e) {
    e.preventDefault();
    var formData = {
        email: $("#email").val(),
        ename: $("#ename").val(),
        edate: $("#edate").val(),
        etimee: $("#etimee").val(),
        etimeb: $("#etimeb").val(),
        eplace: $("#eplace").val(),
        edesc: $("#edesc").val(),
        hcaptcha: $("#h-captcha").children('iframe').attr("data-hcaptcha-response"),
      };
      $.ajax({
        type: "POST",
        url: "/php/event_write.php",
        data: formData,
        encode: true,
        error: function (a,b,c){ console.log(a+b+c)},
      }).done(function (data) {
        console.log(data);
        var data_parse = JSON.parse(data);
        if (data_parse["success"]){
          $('#overlay_content').html(data_parse["message"]);
        } else {
          errors = data_parse["errors"];
          $("#overlay_content").scrollTop(0);
          hcaptcha.reset();
          $("#add_errors").html("<h3>Das hat leider nicht geklappt!</h3>");
          Object.entries(errors).forEach(error => {
            $("#add_errors").append(error[1] + "<br />");

          });
        }
      });
}

function change_tab(){
  var eTab = $("#tab_events");
  var kTab = $("#tab_kurse");
  var gFrame = $("#gcal iframe");
  if (this.id == eTab[0].id){
    kTab.removeClass("active");
    eTab.addClass("active");
    gFrame.attr("src","https://www.google.com/calendar/embed?showTitle=0&wkst=2&bgcolor=%23ffffff&src=5eata97e5pmn9tma5c36ff5bqt54kbn3@import.calendar.google.com&src=swingandcake@gmail.com&src=a2vipdbb7ghsdk71sfblvivs3k@group.calendar.google.com&color=%235A6986&ctz=Europe%2FBerlin")
  } else if (this.id == kTab[0].id){
    eTab.removeClass("active");
    kTab.addClass("active");
    gFrame.attr("src","https://www.google.com/calendar/embed?showTitle=0&wkst=2&bgcolor=%23ffffff&src=kja74l310d5sg6rnpcns38k3fk@group.calendar.google.com&src=kontakt@swing-stuttgart.de&src=nqj3q2taqm1aike4i6opvlt37o@group.calendar.google.com&color=%235A6986&ctz=Europe%2FBerlin")
  } else {
    console.log("error");
  }
}

$('#add_event').click(open_overlay);
$('#more_info').click(open_overlay);
$('#imprint').click(open_overlay);

$('.cat_tab').click(change_tab);

$(document).on('submit', '#add_event_form' , add_event_01);
