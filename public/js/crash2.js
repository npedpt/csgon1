$(function() {
    "use strict";
    window.crash = {
        _chartBox: $(".box-chart"),
        _chart: $(".chart"),
        _chartInfo: $(".chart-info"),
        _roundHash: $(".round-hash"),
        _roundInfo: $(".round-info"),
        _bets: $(".box-bets table"),
        _betCoins: $('#bet-coins'),
        _betCashout: $('#bet-cashout'),
        _pattern: 0.00006,
        _pointsPerSec: 20,
        minBet: 100,
        maxBet: 100000,
        _data: [],
        _i: null,
        _now: null,
        _started: false,
        interval: false,
        _myBet: 0,
        multiplier: false,
        _status: null,
        autobetSettings: {},
        _options: {
            xaxis: {
                show: false
            },
            grid: {
                borderColor: "white",
                borderWidth: {
                    top: 0,
                    right: 0,
                    left: 2,
                    bottom: 2
                }
            },
            yaxis: {
                min: 1,
                tickFormatter: function(val) {
                    if (val==1) return '';
                    return '<span style="color: white; font-weight: bold">'+val.toFixed(1)+'x</span>';
                }
            },
            colors: []
        },
        colors: {
            red: '#d53131',
            green: '#fb5616'
        },
        set status(x) {
            this._status = x;

            this.state = x;
        },
        get status() {
            return this._status;
        },
        setWay: function (ele) {
            $('[class*="-way-content"]', this._bet).hide();
            $('.way div', this._bet).removeClass('active');
            $(ele).addClass('active');
            $('.'+$(ele).data('show')+'-way-content').show();
        },
        init: function () {
            this._options.yaxis.max = 1.26;
            this._options.xaxis.max = 10;
            this._roundInfo.hide();
            this._chartInfo
                .text("Connecting...");
            this.status = 'connecting';
            this.draw();

            this.astate = "idle";
        },
        draw: function () {
            $.plot(this._chart, [ {data: this._data, lines:  {fill: true}} ], this._options);
        },
        resize: function () {
            this.draw();
        },
        countDown: function(time) {
            this.status = 'timeToStart';
            this._chartInfo
                .removeClass("crash-info play-info")
                .text("Start in "+time+"s...");

            var countDownInterval = setInterval(function () {
                time -= 0.1;
                if (time < 0.1) {
                    this.status = 'preparingStart';
                    clearInterval(countDownInterval);
                    this._chartInfo
                        .text("Preparing round...");
                } else {
                    this.status = 'timeToStart';
                    this._chartInfo
                        .text("Start in "+time.toFixed(1)+"s...");
                }
            }.bind(this), 100);
        },
        crash_info: function (data) {
            this.countDown(data.start_in);

            this._hash = data.hash;
            this._roundHash.text(data.hash);
            this._roundInfo.fadeIn(500);


            this._myBet = 0;

            $('.player-bet').remove();
            data.players.forEach(function (prop) {
                crash.player_bet(prop);
            });

            this._data = [];
            this._options.xaxis.max = 10;
            this._options.yaxis.max = 1.26;
            this._started = false;

            this.draw();
        },
        crash_start: function (data) {
            cancelAnimationFrame(this.interval);
            this._i = 0;
            this._data = [ [0,1] ];
            this._options.xaxis.max = 10;
            this._options.yaxis.max = 1.26;
            this._options.colors[0] = this.colors.green;
            this._now = 1;
            this._dateStart = new Date().getTime() - data.time;
            this._chartInfo
                .removeClass("crash-info")
                .addClass("play-info");
            this.crash_draw(data.multiplier);
        },
        crash_draw: function (multiplier) {
            this.status = 'game';
            multiplier = multiplier || false;
            cancelAnimationFrame(this.interval);

            this._time = (new Date().getTime() - this._dateStart);

            while(this._now < Math.pow(Math.E, this._pattern * this._time)) {
                this.crash_add();
            }

            this._options.xaxis.max = Math.max(this._i*1.1, 5000/this._pointsPerSec);
            this._options.yaxis.max = Math.max(this._now*1.1, 2);
            this._chartInfo.text(this._now.toFixed(2)+'x');
            this.multiplier = parseFloat(this._now);

            if (multiplier !== false && 0.95 > Math.floor(parseFloat(multiplier)*100) / Math.floor(parseFloat(this._now)*100) || Math.floor(parseFloat(multiplier)*100) / Math.floor(parseFloat(this._now)*100) > 1.05) {
                console.log('Synchronization is not fully correct. Local: ' + Math.floor(parseFloat(this._now)*100)/100 + ', server: ' +  Math.floor(parseFloat(multiplier)*100)/100);
            }

            this.draw();

            this.interval = requestAnimationFrame(function () {
                this.crash_draw(false);
            }.bind(this));
        },
        crash_add: function() {
            this._i++;
            this._now = parseFloat( Math.pow(Math.E, this._pattern * this._i * 1000/this._pointsPerSec) );
            this._data.push([ this._i, this._now ]);
        },
        crash_end: function (data) {
            cancelAnimationFrame(this.interval);
            this.status = 'crash';
            this._options.colors[0] = this.colors.red;
            this._chartInfo
                .removeClass("play-info")
                .addClass("crash-info")
                .html('Crashed!<br>'+parseFloat(data.multiplier).toFixed(2)+'x');
            this.draw();
            data.time = Date.now();
            this.history(data);

            $('.box-bets tr:not(.win)[data-steamid]').each(function() {
                var _div = $(this);
                var _bet = parseInt(_div.data('bet'));
                var _multi = $('td:nth-child(3)', _div);
                var _profit = $('td:nth-child(4)', _div);

                _div.attr('data-profit', _bet*-1);
                _multi.text('-');
                _profit.text(_bet*-1);
                _div.addClass('lose');
            });

            this.player_sort('profit');

            setTimeout(function() {
                if(this.status != 'crash') return;
                this.status = 'preparingNext';
                this._data = [];
                this._chartInfo
                    .removeClass("crash-info play-info")
                    .text("Preparing next round...");
                $('.box-bets tr:not(:first-child)').fadeOut(500, function() {
                    $(this).remove();
                });
                this._roundInfo.fadeOut(500);
                this.draw();
            }.bind(this), 4000);
        },
        player_bet: function (data) {
            $('<tr class="player-bet' + (data.multiplier ? ' win' : '') + (data.profile.steamid == steamid ? ' my' : '') + '" data-steamid="'+data.profile.steamid+'" data-bet="'+data.bet+'">' +
                '<td><img src="'+data.profile.avatar+'"> '+data.profile.username+'</td>' +
                '<td>'+data.bet+'</td>' +
                '<td>' + (data.multiplier ? parseFloat(data.multiplier).toFixed(2) : '?') + '</td>' +
                '<td>' + (data.multiplier ? Math.floor(parseInt(data.bet, 10) * parseFloat(data.multiplier) - parseInt(data.bet, 10)) : '?') + '</td>' +
                '</tr>')
                .appendTo(this._bets)
                .hide()
                .fadeIn(500);
            this.player_sort('bet');
        },
        player_drop: function (steamid, multiplier) {
            var _div = $('tr[data-steamid="'+steamid+'"]', this._bets);
            var _bet = parseInt(_div.data('bet'));
            var _multi = $('td:nth-child(3)', _div);
            var _profit = $('td:nth-child(4)', _div);
            var profit = Math.round(parseFloat(multiplier) * _bet - _bet);

            _div.attr('data-profit', profit);
            _multi.text(multiplier+'x');
            _profit.text(profit);
            _div.removeClass('lose').addClass('win');
        },
        player_sort: function (sort) {
            this._bets
                .find('tr[data-bet]')
                .sort(function(a, b) {
                    return +b.dataset[sort] - +a.dataset[sort];
                })
                .appendTo(this._bets);
        },
        verify: function(hash, secret, multiplier) {
            if (hash && secret && multiplier) {
                var shaObj = new jsSHA("SHA-256", "TEXT");
                shaObj.setHMACKey(secret, "TEXT");
                shaObj.update(multiplier.toString());
                if (hash === shaObj.getHMAC("HEX")) {
                    notify('success', 'Hashes does match!');
                } else {
                    notify('error', 'Hashes doesn\'t match!');
                }
            }
            else notify("error", "Hashes doesn\'t match!");
        },

        bet: function () {
            var self = crash;
            if (self.status == 'game' && self._myBet > 0) {
                socket.emit('crash withdraw');

                self.state = 'can';

                self._myBet = 0;
            } else {
                var coins = parseInt(self._betCoins.val());
                var cashout = parseFloat(self._betCashout.val());
                var error = false;

                if (coins < self.minBet) return notify('error',  vsprintf(locale['crashMinBet'], [coins, self.minBet]));
                if (coins > self.maxBet) return notify('error',  vsprintf(locale['crashMaxBet'], [coins, self.maxBet]));

                self._betCoins.removeClass('error');
                self._betCashout.removeClass('error');

                if (isNaN(coins) || coins < 1) {
                    self._betCoins.addClass('error');
                    error = true;
                }

                if (isNaN(cashout) || cashout < 1) {
                    cashout = '';
                }

                if (error) return;

                self._betCoins.val(coins);
                self._betCashout.val(cashout);
                self._myBet = coins;
                socket.emit('crash bet', {
                    bet: coins,
                    cashout: cashout
                });
            }
        },
        _state: "",
        _astate: "",
        get state() {
            return this._state;
        },
        set state(x) {
            this._state = x;
            var disabled = false;
            var text = 'undefined state ('+x+')';

            switch(x) {
                case 'connecting':
                    text = 'Connecting...';
                    disabled = true;
                    break;
                case 'can':
                case 'timeToStart':
                    if (this._myBet > 0) {
                        text = 'Placed ('+this._myBet+')';
                        disabled = true;
                    } else {
                        text = 'Place bet';
                    }

                    break;
                case 'preparingStart':
                case 'preparingNext':
                    text = 'Preparing round...';
                    disabled = true;
                    break;
                case 'game':
                    if (this._myBet == 0) {
                        text = 'Wait for next round...';
                        disabled = true;
                    } else {
                        text = 'Withdraw '+(this.multiplier !== false ? '('+Math.floor( this._myBet*this.multiplier )+')':'');
                    }
                    break;
                case 'crash':
                    text = 'Wait for next round...';
                    disabled = true;
                    break;
            }

            $('.bet-butt')
                .prop('disabled', disabled)
                .text(text);
        },
        get astate() {
            return this._astate;
        },
        set astate(x) {
            var butt = $('.autobet-butt');
            this._astate = x;

            switch (x) {
                case 'idle':
                    butt.text('START AUTO BET');
                    break;
                case 'working':
                    butt.text('STOP AUTO BET');
                    break;
                default:
                    butt.text("UNDEFINED STATE OF BUTTON");
                    console.log("UNDEFINED STATE OF BUTTON", x);
            }
        },
        autobet: function() {
            var self = crash;

            if (self.astate == 'idle') {
                self.autobetSettings = {
                    base: parseInt($('#autobet-coins').val()),
                    cashout: parseFloat($('#autobet-cashout').val()),
                    stop: parseInt($('#autobet-limit').val()),
                    onLose: ($('#autobet-on-lose-multiply-select').prop('checked') ? parseFloat($('#autobet-on-lose-multiply').val()) : 0),
                    onWin: ($('#autobet-on-win-multiply-select').prop('checked') ? parseFloat($('#autobet-on-win-multiply').val()) : 0),
                    maxBets: parseInt($('#autobet-max-bets').val())
                };

                self.autobetProps = {
                    betsDone: 0,
                    betsLeft: (self.autobetSettings.maxBets === 0 || isNaN(self.autobetSettings.maxBets) ? null : self.autobetSettings.maxBets),
                    lastResult: null,
                    lastValue: null
                };

                self.autobetStart();
            } else {
                self.autobetStop();
            }
        },
        autobetStart: function() {
            var self = crash;

            self.astate = 'working';

            if (self.status === 'timeToStart' && self._myBet === 0) {
                self.autobetPlay(self.autobetSettings.base, self.autobetSettings.cashout);
            } else {
                self.autobetSetEvents();
            }
        },
        autobetSetEvents: function() {
            var self = crash;

            console.log('[Autobet] Setting events!');

            socket.removeListener('crash info', self.autobetInfoListener);

            if (self.autobetProps.betsDone > 0) {
                socket.once('crash end', function(data) {
                    console.log('[Autobet] Game end!');

                    if (data.multiplier > self.autobetSettings.cashout) {
                        console.log('[Autobet] Result: win!');
                        self.autobetProps.lastResult = 'win';
                        self.autobetInfoListener = function(data) {
                            console.log('[Autobet] Game start!');
                            self.autobetPlay((self.autobetSettings.onWin == 0 ? self.autobetSettings.base : self.autobetProps.lastValue * self.autobetSettings.onWin), self.autobetSettings.cashout);
                        };
                    } else if (data.multiplier < self.autobetSettings.cashout) {
                        console.log('[Autobet] Result: lose!');
                        self.autobetProps.lastResult = 'lose';
                        self.autobetInfoListener = function(data) {
                            console.log('[Autobet] Game start!');
                            self.autobetPlay((self.autobetSettings.onLose == 0 ? self.autobetSettings.base : self.autobetProps.lastValue * self.autobetSettings.onLose), self.autobetSettings.cashout);
                        };
                    }

                    socket.once('crash info', self.autobetInfoListener);
                });
            } else {
                self.autobetInfoListener = function(data) {
                    console.log('[Autobet] Game start!');
                    self.autobetPlay(self.autobetSettings.base, self.autobetSettings.cashout);
                };

                socket.once('crash info', self.autobetInfoListener);
            }
        },
        autobetPlay: function(value, cashout) {
            var self = crash;
            if (self.astate !== 'working') return;
            if (self.autobetProps.betsLeft === 0 || self.autobetSettings.stop && value > self.autobetSettings.stop || value > $('.balance').data('balance')) return self.autobetStop();

            console.log('[Autobet] Playing ' + value + ' coins, cashout: ' + cashout);

            socket.emit('crash bet', {
                bet: value,
                cashout: cashout
            });

            self.autobetProps.betsDone++;
            self.autobetProps.lastValue = value;
            if (self.autobetProps.betsLeft) self.autobetProps.betsLeft--;

            self.autobetSetEvents();
        },
        autobetStop: function() {
            var self = crash;
            self.astate = 'idle';
            socket.removeListener('crash info', self.autobetInfoListener);
        },
        history: function (game) {
            var bet_class = '';
            if (game.multiplier < 1.8) bet_class = 'lose';
            else if (game.multiplier > 2) bet_class = 'win';
            
            var date = new Date(game.time);
            var time = '';
            
            time += (date.getHours() < 10 ? '0' : '') + date.getHours();
            time += ':' + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

            $('<div class="'+bet_class+'"><time class="date">' + time + '</time><span class="multiplier">' + parseFloat(game.multiplier).toFixed(2) + 'x</span></div>').prependTo($('.history'));
        }
    };
    crash.init();

    $(window).resize(crash.resize.bind(crash));


    socket.on('crash info', function(data) {
        crash.crash_info(data);
    });

    socket.on('crash start', function(data) {
        if (_soundOn) new buzz.sound("/sounds/crashstart.mp3").play();
        crash.crash_start(data);
    });

    socket.on('crash tick', function(data) {
        crash.crash_start(data);
    });

    socket.on('crash end', function(data) {
        crash.crash_end(data);
    });

    socket.on('crash history', function(history) {
        history.forEach(function (prop) {
            crash.history(prop);
        });
    });

    socket.on('player drop', function(data) {
        crash.player_drop(data.profile.steamid, data.multiplier);
    });

    socket.on('player new', function(bet) {
        bet.forEach(function (prop) {
            crash.player_bet(prop);
        });
    });

    socket.on('crash my bet', function(bet) {
        crash._myBet = bet;
    });

    socket.on('crash settings', function(data) {
        if (data.minBet) {
            crash.minBet = data.minBet;
            $('.min-bet').text(data.minBet.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        }
        if (data.maxBet) {
            crash.maxBet = data.maxBet;
            $('.max-bet').text(data.maxBet.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        }
    });
    setInterval(function() {
        $('time.timeAgo').each(function(i, el) {
            $(el).text(jQuery.timeago($(el).data('time')));
        });
    }, 1000);
});