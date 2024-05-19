
$(document).ready(function() {
    scroll();
})

function scroll()
{
    let message =$('.message-container');
    message.scrollTop(message[0].scrollHeight);
    console.clear();
}
$('#form').submit(function(event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var datos = $(this).serialize();

    $.post(url, datos, function (data) {
        $('#message').val('');
        $('.messages').append(data.message);
        scroll();
    });
});

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
var pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    forceTLS: true,
});

var channel = pusher.subscribe('messages'+application_id);
channel.bind('NewMessage', function(data) {
    if(data.user_id!=user_id)
    {
        console.log(data.message);
        $('.messages').append(data.message);
        scroll();
    }
});
