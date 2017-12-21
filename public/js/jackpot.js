$(function() {
    "use strict";

    window.jackpot = ({
        _settings: {
            min: 10, max: 1000000
        },
        canBet: true,
        _createRound: function(time,bets) {
            if(time>=1) jackpot.countDown(time);
            if(bets.length){
                jackpot.showBets(bets);
            }
        },
        endRound: function(data) {
            jackpot.canBet = false;
            jackpot.sort();
            $('.roulette-wheel-outer .flip').empty();
            var i = 1;
            $('.flip').html('<img class="tada animated" style="border-radius: 50%;vertical-align: middle;" src="'+data.players[0].avatar+'">').hide().fadeIn(100);
            var pLoop = setInterval(function(){
                if(data.players[1]) $('.flip').html('<img class="tada animated" style="border-radius: 50%;vertical-align: middle;" src="'+data.winner.avatar+'">').hide().fadeIn(100);
                if(i === data.players.length-1) {
                    $('.flip img').css('border','4px solid #fefefe');
                    clearInterval(pLoop);
                }
                else i++;
            },1000);
            setTimeout(function(){
				jackpot.canBet = true;
            },(data.players.length*1100)+2000);
			$('<div style="border-bottom: 2px solid #161616;border-left: 2px solid #161616;background: #1d1d1d;"><img style="vertical-align:middle;margin-bottom:5px;margin-top:5px;margin-right:5px;height:30px;width:30px;border-radius:50%;margin-left: 7;" src="'+ data.winner.avatar +'"><span style="font-size:15px;margin-right:5px;font-weight: 700;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 150px;display: inline-block;vertical-align: middle;">'+ data.winner.username+'</span><span style="background: #161616;-ms-flex-align: center;justify-content: center;height: 42;-ms-flex-pack: center;width: 40%;float: right;align-items: center;display: flex;font-weight: 700;"> '+data.won+'&nbsp;&nbsp;</span></div>').hide().prependTo('.history').fadeIn(100);

				},
        sort: function() {
            var $wrapper = $('.box-bets .player-bets');
            $wrapper.find('.box-bets .player-bet').sort(function (a, b) {
                return +b.dataset.sort - +a.dataset.sort;
            })
                .appendTo( $wrapper );
        },
        newRound: function(time) {
        var gameDiv1 = $('.balance-latest .lol123').html('<div style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;">Worth: <div class="jptotal" style="text-align: center; color: #fb5616;font-weight: bold; font-size: 30px;line-height: 30px;"></div></div>').hide();                 
        var gameDiv2 = $('.box-bets').html('<table><tr style="border-bottom: 2px solid #fb5616;"> <td>Players</td> </tr></table><div class="player-bets"></div>').hide();                 
		var gameDiv = $('.roulette-wheel-outer').html('<div class="flip-container" style="width: 300px;height: 300px;position: relative; display: table;margin: 0 auto;font-weight: bold !important; font-size: 55px;stroke: #fb5616 !important;margin-bottom:10px;margin-top:10px;"><div class="flip" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%);font-weight: bold !important; font-size: 55px;"></div></div>').hide();
            jackpot.countDown(time);
            var checkAnimation = setInterval(function(){
                if(!jackpot.canBet) return;
                gameDiv.fadeIn(100);
				gameDiv2.fadeIn(100);
				gameDiv1.fadeIn(100);
                clearInterval(checkAnimation);
            },10);
        },
        _addBet: function(data) {
			if(!jackpot.canBet) return;
            var total = parseInt((($('.balance-latest .jptotal').text()) ? $('.balance-latest .jptotal').text().replace('','') : 0))+parseInt(data.amount);
            $('.balance-latest .jptotal').html('' + total);
            if(data){
                $(this._generateBetFromData(data)).hide().prependTo('.box-bets .player-bets').fadeIn(500);
            }
        },
        _updateBets: function(total) {
            var percents = document.getElementsByClassName('percent');
            Array.prototype.forEach.call(percents, function(to) {
                var cena = parseInt(to.parentNode.innerHTML);
                $(to).html(((cena / total) * 100).toFixed(2));
            });
        },
        _generateBetFromData: function(data) {
            return '<div class="player-bet" data-sort="'+data.amount+'" ' + ((typeof steamid !== 'undefined' && data.player.steamid === steamid) ? 'style="border-bottom: 2px solid #161616;"' : '') + '><div class="user"><img src="' + data.player.avatar + '">' + data.player.username + '</div><div class="amount">' + data.amount + ' (<span class="percent">' + ((data.amount / data.total) * 100).toFixed(2) + '</span>%)</div></div>'
        },
        showBets: function(bets) {
            $('.box-bets .player-bets').empty();
            bets.forEach(function(bet) {jackpot._addBet(bet)});
        },
        countDown: function(time){
            var bar = new ProgressBar.Circle('.roulette-wheel-outer .flip-container', {
              strokeWidth: 8,
              easing: 'easeInOut',
              duration: (time*1000)+1000,
              color: '#fb5616',
              trailColor: '#eee',
              trailWidth: 1,
              svgStyle: true
            });
            bar.animate(1.0);
            $('.flip').html(''+time);
            var countDownInterval = setInterval(function() {
                if(time) time -= 1;
                $('.flip').html(''+time);
                if (time <= 10){
                    $('.flip').css('color','red');
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
                    case "last": val = parseInt(localStorage.getItem("lastBetJackpot")); break;
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
                localStorage.setItem("lastBetJackpot", val);
                value.val(val);
            });
            $('.controls .btn-play').click(function(){
                var val = parseInt(value.val());
                if (!isNaN(val) && val > 0) {
                    socket.emit('jackpot play', value.val());
                } else {
                    value.val('0');
                }
            });
        }
    });
    jackpot.bindButtons();
	
	socket.on('jackpot round', function(time,data,winners) {
        if(data[0]){
            jackpot._createRound(time,data);
            jackpot._updateBets(data[data.length-1].total); 
        }
        winners.forEach(function(winner){
            $('<div style="border-bottom: 2px solid #161616;border-left: 2px solid #161616;background: #1d1d1d;"><img style="vertical-align:middle;margin-bottom:5px;margin-top:5px;margin-right:5px;height:30px;width:30px;border-radius:50%;margin-left: 7;" src="'+winner.player.avatar+'"><span style="font-size:15px;margin-right:5px;font-weight: 700;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 150px;display: inline-block;vertical-align: middle;">'+winner.player.username+'</span><span style="background: #161616;-ms-flex-align: center;justify-content: center;height: 42;-ms-flex-pack: center;width: 40%;float: right;align-items: center;display: flex;font-weight: 700;"> '+winner.amount+'&nbsp;&nbsp;</span></div>').hide().prependTo('.history').fadeIn(100); //what u only want...
        });
    });


    socket.on('jackpot new bet', function(bet) {
        jackpot._addBet(bet);
        jackpot._updateBets(bet.total);
    });

    socket.on('jackpot end', function(data) {
        jackpot.endRound(data)
    });

    socket.on('jackpot new', function(time) {
        jackpot.newRound(time)
    });

});