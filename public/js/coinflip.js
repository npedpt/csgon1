$(function() {
    "use strict";

    window.coinflip = ({
        _color: "t",
        _settings: {
            min: 10, max: 1000000
        },
        _addBet: function(data) {
            if(data){
                $(this._generateBetFromData(data)).hide().prependTo('.roulette-wheel-outer').fadeIn(500);
                if(data.opponent) coinflip.countDown(data.hash,data.left);
            } 
        },
        _generateBetFromData: function(data) {
            var text = '';
            if(typeof steamid !== 'undefined' && data.player.steamid === steamid) text += '<div style="border-bottom: 2px solid transparent !important;" class="player-bet ' + data.hash + '" data-sort="'+data.amount+'">';
            else text += '<div class="player-bet ' + data.hash + '" data-sort="'+data.amount+'">';
            text += '<div class="user"><img src="' + data.player.avatar + '">' + data.player.username + '<img style="margin-left: 10px;" src="/img/misc/coin-'+data.side+'.png">' + '</div>';
            if(data.status === 'open') text += '<button data-hash="' + data.hash + '" style="outline: 0; border: 0; height: 25px; width: 7%; margin-top: 1%; font-size: 18px; line-height: 10px; color: #161616; background: #fb5616; font-weight: 700; cursor: pointer; text-transform: uppercase; font-family: Titillium,sans-serif; border-radius: 5px; font-weight: 700; transition: all .3s; border: 3px solid #fb5616;" class="btn-join" onclick="socket.emit(\'coinflip join\', \'' + data.hash + '\');">Join</button>';
            if(!data.opponent) text += '<div class="amount" data-worth="' + data.amount + '">Worth: ' + data.amount + '</div>';
            else {
                text += '<div class="amount" data-worth="' + data.amount + '">' + '<div class="flip-container" style="width: 40px;height: 40px;position: relative;"><div class="flip" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%);">' + data.left + '</div></div><br/><div class="amount" data-worth="' + data.amount + '">Worth: ' + data.amount + '</div>' + '</div>';
            }
            if(data.opponent) { 
                text += '<div class="user"><img src="' + data.opponent.avatar + '">' + data.opponent.username;
                text += (data.side === 'ct') ? ' <img style="margin-left: 10px;" src="/img/misc/coin-t.png"></div>' : '<img style="margin-left: 10px;" src="/img/misc/coin-ct.png"></div>';
            }
            text += '</div>';
            return text;
        },
        showBets: function(bets) {
            var self = this;
            $('.roulette-wheel-outer').empty();
			bets.forEach(function(bet) { self._addBet(bet) });
		},
        flipCoin: function(hash,side){
            //$('.'+hash+' .amount .flip').html('<img style="margin-left: 10px;" src="/img/misc/gifs/coin1-' + side.won + '.gif"></div>');
            $('.'+hash+' .amount .flip').html('<img class="flip animated" style="margin-left: 10px;" src="/img/misc/coin-' + side.won + '.png"></div>');
        },
        deleteBet: function(bet,side) {
            coinflip.flipCoin(bet,side);
            setTimeout(function(){
                $('.'+bet).css('opacity','0.5');
                $('.'+bet).html('<h3 style="height:14px;text-align: center; width: 100%;">'+side.won.toUpperCase()+' won with 50.00% chance!</h3>');
                setTimeout(function(){
                    $('.'+bet).remove();
                },2500);
            },5000);
        },
        updateBet: function(hash,data) {
            var time = 10;
            var worth = $('.'+hash+' .amount').data('worth');
            $('.'+hash).append('<div class="user"><img style="margin-left: 10px;" src="' + data.avatar + '">' + data.username + '<img style="margin-left: 10px;" src="/img/misc/coin-' + data.side + '.png"></div>');
            $('.'+hash+' .amount').html('<div class="flip-container" style="width: 40px;height: 40px;position: relative;"><div class="flip" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%);">' + 10 + '</div></div><br/><div class="amount" data-worth="' + worth + '">Worth: ' + worth + '</div>');
            $('.'+hash+' .btn-join').remove();
            coinflip.countDown(hash,time);
        },
        countDown: function(hash,time){
            var bar = new ProgressBar.Circle('.'+hash+' .amount .flip-container', {
              strokeWidth: 10,
              easing: 'easeInOut',
              duration: time*1000,
              color: '#fb5616',
              trailColor: '#eee',
              trailWidth: 1,
              svgStyle: true
            });
            bar.animate(1.0);
            var countDownInterval = setInterval(function() {
                if(time) time -= 1;
                else $('.'+hash).remove();
                $('.'+hash+' .amount .flip').html(time);
                if (time <= 3){
                    $('.'+hash+' .amount .flip').css('color','red');
                }
                if (time <= 1) {
                    clearInterval(countDownInterval);
                }
            }, 1000);
        },
        bindButtons: function() {
            var self = this;

            var value = $('.inputs-area .amount .value');
            var multi = $('.btn-multi');

            multi.click(function(){
                multi.removeClass('active');
                $(this).addClass('active');
                self._color = $(this).data('value');
            });
            $('.inputs-area .button').click(function(){
                var val = parseInt(value.val());
                var balance = parseInt($($('.balance')[0]).data('balance'));
                if (isNaN(val)) val = 0;

                switch($(this).data('action')) {
                    case "clear": val = 0; break;
                    case "last": val = parseInt(localStorage.getItem("lastBetCoinflip")); break;
                    case "min": val = self._settings.min; break;
                    case "max": val = self._settings.max; break;
                    case "100+": val += 100; break;
                    case "1000+": val += 1000; break;
                    case "10000+": val += 10000; break;
                    case "100-": val -= 100; break;
                    case "1000-": val -= 1000; break;
                    case "10000-": val -= 10000; break;
                    case "1/2": val *= 0.5; break;
                    case "x2": val *= 2; break;
                    case "x3": val *= 3; break;
                }
                val = parseInt(val);
                if (val > balance) val = balance;
                if (val < 0 || isNaN(val)) val = 0;
                localStorage.setItem("lastBetCoinflip", val);
                value.val(val);
            });
            $('.controls .btn-play').click(function(){
                var val = parseInt(value.val());
                if (!isNaN(val) && val > 0) {
                    socket.emit('coinflip play', value.val(), self._color);
                } else {
                    value.val('0');
                }
            });
        }
    });
    coinflip.bindButtons();

    socket.on('coinflip game', function(data) {
        coinflip._addBet(data)
    });

    socket.on('coinflip history', function(history) {
        coinflip.showBets(history)
    });

    socket.on('coinflip win', function(hash,won) {
        coinflip.deleteBet(hash,won)
    });

    socket.on('coinflip update', function(hash,data) {
        coinflip.updateBet(hash,data)
    });

});