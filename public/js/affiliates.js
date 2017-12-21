var websocket = $('meta[name="websocket"]').attr('content');
var socket = io(websocket, {secure: true,});

var dTip = {
    _tip: null,
    init: function() {
        this._tip = $('<div id="tip"> <div class="arrow"></div> <div class="tip-label"></div> <div class="content"></div> </div>').appendTo('body');

        var self = this;
        $('*[data-tip]')
            .hover(function(){
                if($(this).data('ltip')) {
                    self._tip
                        .find('.tip-label')
                        .text($(this).data('ltip'));
                }
                self._tip
                    .find('.content')
                    .html($(this).data('tip'));
                self._tip.fadeIn('fast');
            }, function() {
                self._tip.hide();
            })
            .mousemove(function(e) {
                self._tip.css({
                    'top': (e.pageY-self._tip.height()-20) + 'px',
                    'left': (e.pageX-125) + 'px'
                });
            });
    } 
};
dTip.init();

socket.on('giveaway amount', function(count) { $('.giveaway-amount-to-win').text(count); });
socket.on('giveaway users', function(count) { $('.giveaway-amount-of-players').text(count); });
socket.on('giveaway tickets', function(count) { $('.giveaway-amount-of-tickets').text(count); });

$('button#set-code-button').click(function() {
    socket.emit('update ref', $('input#set-code').val());
    location.reload();
});
$('input#set-code').on('keypress', function(e) {
    if (e.keyCode == 13) {
        socket.emit('update ref', $(this).val());
        return false;
    }
});

$('button#get-coins-button').click(function() {
    socket.emit('chat message', {'type': 'chat', 'message': '/ref ' + $('input#get-coins').val()});
});

$('#joinGiveAway').click(function() {
    var numberOfTickets = $("#numberOfTickets").val();
    socket.emit('giveaway play', numberOfTickets);
});

$('input#get-coins').on('keypress', function(e) {
    if (e.keyCode == 13) {
        socket.emit('chat message', {'type': 'chat', 'message': '/ref ' + $(this).val()});
        return false;
    }
});

$('#withdraw-refs-button').on('click', function() {
    $.post('/api/affiliates-collect', {
        'targetSID': steamid
    }, function(data) {
        if (!data.success) return notify('error', locale[data.reason]);
        notify('success', locale.affiliatesSuccess);
        return location.reload();
    });
});
$(function(){
    function secondsTimeSpanToHMS(s) {
        var h = Math.floor(s/3600);
        s -= h*3600;
        var m = Math.floor(s/60);
        s -= m*60;
        return (h < 10 ? '0'+h : h)+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s);
    }
    function reload($div) {
        var left = parseInt($div.attr('data-timeleft'));

        if (left <= 0) {
            $div
                .addClass("lime")
                .removeClass("reload-time")
                .text("CHECK NICK");
        } else {
            $div
                .text(secondsTimeSpanToHMS(left))
                .attr('data-timeleft', left-1);
            setTimeout(function () {
                reload($div)
            }, 1000);
        }
    }
    var $freeCoinsTimer = $("button.reload-time");
    if ($freeCoinsTimer.length)
        reload($freeCoinsTimer);
});

$(".free-coins").on('click', function() {
    $.get('/api/'+$(this).attr('data-api'), function(data){
        var message = (locale.hasOwnProperty(data.message) ? locale[data.message] : data.message);
        var payload = data.payload || [];
        var type = data.success ? 'success' : 'error';
        if (data.success) {
            var balance = $('.balance');
            var balanceValue = $('.value', balance);
            balance.data('balance', parseInt(balance.data('balance')) + parseInt(data.value));
            balanceValue.html(balance.data('balance'));
        }
        notify(type, vsprintf(message, payload));

    });
});