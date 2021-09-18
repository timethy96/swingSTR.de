function postChoice(formData) {
    $.ajax({
        type: "POST",
        url: "/php/event_mod.php",
        data: formData,
        encode: true,
        error: function (a,b,c){ console.log(a+b+c)},
      }).done(function (data) {
        console.log(data);
        console.log(JSON.parse(data));
        window.location.reload();
      });
}

function process_event(){
    var choiceButton = this.className.split(/\s+/)[0];
    var eventID = $(this).parents(".event_card").attr("data-id");
    if (choiceButton == "event_accept") {
        $(this).siblings(".event_load").css("display","block");
        var formData = {
            id: eventID,
            choice: '1',
            reason: '',
        };
        postChoice(formData);
    } else if (choiceButton == "event_spam") {
        $(this).siblings(".event_load").css("display","block");
        var formData = {
            id: eventID,
            choice: '2',
            reason: 'SPAM',
        };
        postChoice(formData);
    } else if (choiceButton == "event_deny") {
        $(".event_button").hide();
        $(".deny_reason").css("display", "inline");
    } else if (choiceButton == "event_deactivate") {
        $(this).siblings(".event_load").css("display","block");
        var formData = {
            id: eventID,
            choice: '2',
            reason: '',
        };
        postChoice(formData);
    } else if (choiceButton == "event_reactivate") {
        $(this).siblings(".event_load").css("display","block");
        var formData = {
            id: eventID,
            choice: '1',
            reason: '',
        };
        postChoice(formData);
    }
}

function submit_reason(e){
    e.preventDefault();
    $(this).siblings(".event_load").css("display","block");
    var eventID = $(this).parents(".event_card").attr("data-id");
    var formData = {
        id: eventID,
        choice: '2',
        reason: $("#denytext").val(),
    };
    postChoice(formData);
}

$(".event_button").click(process_event);
$(".deny_reason").submit(submit_reason);