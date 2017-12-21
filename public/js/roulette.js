
$(function() {
    "use strict";

    window.roulette = ({
        _rolling: false,
        _timeLeft: 0,
        _maxTime: 30 * 100,
        _order: [0, 11, 5, 10, 6, 9, 7, 8, 1, 14, 2, 13, 3, 12, 4],
        _position: 0,
        _bets: {
            red: [],
            green: [],
            black: []
        },
        sounds: {
            roll: new buzz.sound('/sounds/rolling.wav', {preload: true}),
            tone: new buzz.sound('/sounds/tone.wav', {preload: true})
        },
        set timeLeft(x) {
            this._timeLeft = x;
            this.updateTimer();
        },
        get timeLeft() {
            return this._timeLeft;
        },
        _numberToColor: function(num) {
            if (num === 0) { return 'green'; }
            else if (num < 8) { return 'red'; }
            else { return 'black'; }
        },
        _tileWidth: 132,
        _wheel: $('.roulette-wheel'),
        rotateTo: function(number, diff, rotations) {
            var self = this;
            rotations = rotations || 5;
            if (diff < 0.1) diff = 0.1;
            if (diff > 0.9) diff = 0.9;
            diff = diff - 0.5 || 0;
            this._position = (this._order.indexOf(number) + diff) * this._tileWidth;
            var position = this._position - (this._wheel.width() - 15*this._tileWidth) / 2;
            this._rolling = true;
            $('.btn-play').addClass('disabled');
            if (_soundOn) this.sounds.roll.play();
            var act_pos = -1 * (position + rotations * 15*this._tileWidth);
            this._wheel.animate({backgroundPositionX: act_pos}, 7000, $.bez([.06,.79,0,1]), function() {

                setTimeout(function () {
                    self._position -= diff*self._tileWidth;

                    self._wheel.animate({
                        backgroundPositionX: (-1 * (self._position - (self._wheel.width() - self._tileWidth*15) / 2))
                    }, 300, "linear", function(){
                        self.positionFix();
                    }, 300);
                }, 300);

                if (_soundOn) self.sounds.tone.play();
                self._rolling = false;
                self.positionFix();
                self.updateHistory(number);
                $('.total-bet-amount').addClass('lose');
                var a =  $('.total-bet-amount.' + self._numberToColor(number) + '-total');
                var b = $('.your-bet.bet-on-' + self._numberToColor(number));
                a.removeClass('lose').addClass('win').text(parseInt(a.text()) * (number === 0 ? 14 : 2));
                b.removeClass('lose').addClass('win').text(parseInt(b.text()) * (number === 0 ? 14 : 2));
            });
        },
        positionFix: function() {
            if (this._rolling) return;
            this._wheel.css({'background-position-x': -1 * (this._position - (this._wheel.width() - this._tileWidth*15) / 2)});
        },
        updateHistory: function(number) {
			var ii = 0;
			if(color != "green") {
				ii++
			} else {
				ii = 0
			}
			var i = 0;
			while (i < ii) {
				$('.crown-counter').html('<span>'+ i +'</span>');
				i++;
			}
            if ($('.latest').children().length >= 10) $('.latest > div').last().remove();
            var color = this._numberToColor(number);
            $('.latest').prepend('<div class="' + color + '-last-color last"></div>');
        },
        newRound: function(time, bets) {
            this._bets = bets || {
                    red: [],
                    green: [],
                    black: []
                };
            $('.btn-play').removeClass('disabled');
            $('.player-bets').empty();
            $('.total-bet-amount').removeClass('lose').removeClass('win').data('value', '0').text('0');
            $('.your-bet').removeClass('lose').removeClass('win').data('value', '0').text('0');
            this.updateDisplay();
            this.startCountDown(time);
        },
        startCountDown: function(time) {
            clearInterval(this.countDownInterval);
            var self = this;
            this.timeLeft = time * 100;
            if (time === 0) return;

            this.countDownInterval = setInterval(function() {
                self.timeLeft -= 1;
                if (self.timeLeft === 0) {
                    clearInterval(self.countDownInterval);
                }
            }, 10);
        },
        updateTimer: function() {
            if (this.timeLeft > 0) {
                $('.rolling').fadeIn(200);
                $('.rolling-inner').html('<div>' + (this.timeLeft / 100).toFixed(2).replace(".",":") + '</div>Countdown to next spin');
            } else {
                $('.rolling').fadeOut(200);
            }
        },
        _addBet: function(data, color) {
            if(!this._bets[color]) return;
            this._bets[color].push(data);
            this._displayBet(data, color);
        },
        _displayBet: function(data, color) {
            if (typeof steamid !== 'undefined' && data.player.steamid === steamid) {
                var myBet = $('.your-bet.bet-on-' + color);
                myBet.data('value', parseInt(myBet.data('value')) + parseInt(data.amount)).text(myBet.data('value'));
            }

            var totalBet = $('.total-bet-amount.' + color + '-total');
            totalBet.data('value', parseInt(totalBet.data('value')) + parseInt(data.amount)).text(totalBet.data('value'));

            $(this._generateBetFromData(data)).hide().prependTo('.' + color + '-bet .player-bets').fadeIn(500);

            this.sortColor(color);
        },
        sortColor: function(color) {
            var $wrapper = $('.'+color+'-bet .player-bets');
            $wrapper.find('.player-bet').sort(function (a, b) {
                return +b.dataset.sort - +a.dataset.sort;
            })
                .appendTo( $wrapper );
        },
        updateDisplay: function() {
            var self = this;
            $('.bet-list').empty();
            Object.keys(this._bets).forEach(function(color) {
                $('.my-bet-' + color).data('value', 0);
                $('.total-bet-' + color).data('value', 0);
                self._bets[color].forEach(function(bet) { self._displayBet(bet, color) });
            });
        },
        _generateBetFromData: function(data) {
            return '<div class="player-bet" data-sort="'+data.amount+'"><div class="user"><img src="' + data.player.avatar + '">' + data.player.username + '</div><div class="amount">' + data.amount + '</div></div>'
        },
        _color: "red",
        _settings: {
            min: 1, max: 5000000
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
                    case "last": val = parseInt(localStorage.getItem("lastBetRoulette")); break;
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
                localStorage.setItem("lastBetRoulette", val);
                value.val(val);
            });
            $('.controls .btn-play').click(function(){
                var val = parseInt(value.val());
                if (!isNaN(val) && val > 0) {
                    socket.emit('roulette play', value.val(), self._color);
                } else {
                    value.val('0');
                }
            });
        }
    });
    roulette.bindButtons();


    socket.on('roulette new round', function(time, hash) {
        roulette.newRound(time);
        $('.roulette-info').text('Round hash: ' + hash);
    });

    socket.on('roulette player', function(data, color) {
        roulette._addBet(data, color)
    });

    socket.on('roulette ends', function(data) {
        roulette.rotateTo(data.winningNumber, data.shift);
    });

    socket.on('roulette history', function(history) {
        history.forEach(function(bet) {
            roulette.updateHistory(bet);
        });
    });

    socket.on('roulette round', function(time, bets, hash) {
        roulette.newRound(time, bets);
        $('.roulette-info').html('Round hash: ' + hash);
    });

    $(window).resize(roulette.positionFix.bind(roulette));
    $(document).ready(function(){roulette.positionFix();})
});