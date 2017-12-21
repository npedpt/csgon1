var socket = io('http://csgodank.net:2052');

socket.on('disablecredit', function (data)
{
	$('#credits').attr('disabled', 'disabled');

});
socket.on('enablecredit', function (data)
{
	$('#credits').removeAttr('disabled');

});

socket.on('onlineusers', function (data){
	document.getElementById("usercounter").innerHTML = data;
});


function jpupdate()
{
	refreshCredits();
	$.ajax({
		method: "GET",
		url: "table1.php",
		dataType: 'html'
	}).done(function(msg) {
		$("div.t1").html(msg);

	});
	$.ajax({
			method: "GET",
			url: "updategamenumber.php"
		}).done(function(msg)
		{
			$("span.gnum").html(msg);
	});
		$.ajax({
		method: "GET",
		url: "pot1.php"
	}).done(function(msg)
	{
		$("span.cvalue").html(msg);

	});
	$.ajax({
		method: "GET",
		url: "tl1.php"
	}).done(function(msg)
	{
		$("span.ticker").html(msg);

	});
	$.ajax({
		method: "GET",
		url: "playersinpot.php",
		dataType: 'html'
	}).done(function(msg) {
		$("span.playersinpot").html(msg);
	});
	$.ajax({
		method: "GET",
		url: "previouswinner.php",
		dataType: 'html'
	}).done(function(msg) {
		$(".lastwinner").html(msg);

	});
	$("div.wnr").html('');
}
function refreshCredits()
{
	$.ajax({
		method: "GET",
		url: "updatecredits.php"
	}).done(function(msg) {
		$(".mycredits").html(msg);
	});
}
function updatemsg()
{
$.ajax({
		type: "GET",
		url: "msg.php",
		error: function(err) {
			console.log(err);
		},
		success: function(result) {
			$("span.msg").html(result);
		}
	});
}
socket.on('updategameinfo', function (data)
{
	jpupdate();
});

socket.on('jackpotanimation', function (data)
{
	$.ajax({
			method: "GET",
			url: "loadr1.php"
		}).done(function(msg)
		{
			$('.kjmhgd').before(msg);
			setTimeout(function()
			{
				jpupdate();
			},12000);
		});
});

socket.on('showthechat', function (data)
{
	$.ajax({
	method: "GET",
	url: "showchat.php",
	data: { "id": data.messageid },
	dataType: 'html',
	}).done(function(msg)
	{
		$(".newmessages").append(msg);
	});
});

socket.on('coinfliptable', function (data)
{
	$.ajax({
		type: "GET",
		url: "coinfliptable.php",
		success: function(result){
				$("span.cointable").html(result);
		}
	});
});

socket.on('showthelobby', function (data)
{
    $.ajax({
        method: "GET",
        url: "showlobby.php",
        data: { "id": data }
    }).done(function(msg) {
        $("#cflobbies").prepend(msg);
    });
});
socket.on('hidethelobby', function (data)
{
    $("#cf"+data).remove();

    if(data==mylobby)
    {
        socket.emit('showcfwinner',data);
    }
});
socket.on('showthecfwinner', function (data)
{
	console.log("Data: " + data);

    if(data==mylobby)
    {
        $.ajax({
            method: "GET",
            url: "showcfwinner.php",
            data: { "id": data }
        }).done(function(msg) {
            $(".flip"+data).html(msg);
						console.log("Data: " + data);
        });

        if(steamid==hostid)
        {
            function updtc()
            {
                socket.emit('updatecredits',1);
            }

            setTimeout(updtc, 10500);
        }
    }
});
