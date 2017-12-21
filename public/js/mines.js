$(function() {
    var mines = {
        _round: {
            id: null,
            $logs: null
        },
        _bombs: 1,
        _mineImg: "/img/misc/bomb.png",
        $games: $('.mines'),
        getTiles: function () {
            var tiles = '';
            for (var i = 1; i <= 25; i++) {
                tiles += '<div data-position="'+i+'" id="tile_'+i+'" class="tile"></div>';
            }
            return tiles;
        },
        log: function (txt, color) {
            $('<div'+(color?' class="'+color+'"':'')+'>'+txt+'</div>')
                .prependTo(this._round.$logs);
        },
        setbutton: function (txt, classe, click) {
            this._round.$div
                .find('.button')
                .unbind('click')
                .click(click)
                .attr('class', 'button '+classe)
                .text(txt);
        },
        start: function(data) {
            if(this._round.id != null) this.end();

            this._round.id = data.id;

            this._round.$div = $('<div id="game'+data.id+'" class="game"> <div class="board"> '+this.getTiles()+' </div> <div class="info"> <div class="next-reward"> <div class="text">Next reward</div> <div class="value">'+data.nextPayout+'</div> </div> <div class="total-stake"> <div class="text">Total stake</div> <div class="value">'+data.bet+'</div> </div> <div class="button btn-cashout"> Cashout </div> <div class="hash"> Hash: <input class="value" value="'+data.hash+'"> <div class="secret"></div></div> <div class="logs bottomFade"> </div> </div> </div>')
                .insertAfter(this.$games.find('.startgame'));

            this._round.$div
                .find('.tile')
                .click(function(){
                    socket.emit('mines click', {
                        position: $(this).data('position')
                    });
                });

            this._round.$next = this._round.$div.find('.next-reward .value');
            this._round.$total = this._round.$div.find('.total-stake .value');
            this._round.$logs = $(this._round.$div).find('.logs');
            this.setbutton('Cashout', 'btn-orange', function() {
                this.setbutton('Cashed out', 'btn-green', null);
                this.log('You sent a cashout query to the server ('+this._round.$total.text()+' coins)!', 'green');
                socket.emit('mines cashout');
            }.bind(this));
            this.log('Game has been started', 'green');
            this.log('Bet: '+data.bet+', bombs: '+data.bombs);
        },
        game: function(data){
            if (data.id != this._round.id)
                return alert('Game is not properly loaded.');

            var tile = data.position;
            var $tile = this._round.$div.find('.tile#tile_' + data.position);
            
            if (data.value == -1) {
                this.log('You found <b>bomb</b> on '+tile+' tile - you lost '+this._round.$total.text()+'!', 'red');
                this._round.$total.text(0).addClass('red');
                this._round.$next.addClass('red');
                $tile.html('<img src="'+this._mineImg+'">').addClass('red');
                this.setbutton('Defeat! :(', 'btn-red', null);
                if (localStorage.getItem('muteSound') != 'on') new buzz.sound("/sounds/boom.mp3").play();
            } else {
                this._round.$total.text(data.payout);
                this._round.$next.text(data.nextPayout);
                this.log('You found <b>'+data.value+' coins</b> on '+tile+' tile.', 'green');
                $tile
                    .text('+' + (data.value > 10000 ? Math.floor(data.value / 1000) + 'k' : data.value))
                    .addClass('green');
                $tile.unbind('click');
                if (localStorage.getItem('muteSound') != 'on') new buzz.sound("/sounds/click.mp3").play();
            }

        },
        bindButtons: function () {
            var self = this;
            var multi = $('.btn-multi');
            multi.click(function(){
                multi.removeClass('active');
                $(this).addClass('active');
                self._bombs = $(this).data('value');
            });

            var value = $('.inputs .amount .value');

            $('.inputs .play').click(function(){
                if(self._round.id != null)
                    return  notify('error', 'Cash out before starting new game.');
                socket.emit('mines start', {
                    bombs: self._bombs,
                    amount: value.val()
                });
            });

            $('.inputs .buttons .button').click(function(){
                var val = parseInt(value.val());
                var balance = parseInt($($('.balance')[0]).data('balance'));
                if (isNaN(val)) val = 0;

                switch($(this).data('action')) {
                    case "clear": val = 0; break;
                    case "last": val = parseInt(localStorage.getItem("lastBetMines")); break;
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
                localStorage.setItem("lastBetMines", val);
                value.val(val);
            });
        },
        _settings: {
            min: 50,
            max: 100000,
            update: function (data) {
                this.min = data.minBet;
                this.max = data.maxBet;
            }
        },
        end: function(data){
            if( this._round.$div.find('.button').text()=="Cashout" || (typeof data.cashout !='undefined' && data.cashout == true))
                this.setbutton("Cashed out", "btn-green", null);
            $('.tile').unbind('click');
            this._round.$div.addClass('inactive');
            this.log('The game was ended.');
            if (typeof data != 'undefined') {
                this._round.$total.text(data.payout);
                this._round.$div.find('.secret').html('Secret:<input class="value" value="' + data.secret + '" />');
                for (var i in data.bombsPositions)
                    $('#game' + data.id + ' #tile_' + data.bombsPositions[i]).html('<img src="'+this._mineImg+'">');
            }
            this._round.id = null;
        },
        init: function () {
            this.bindButtons();
            socket.on('mines start', function(data){
                this.start(data);
            }.bind(this));
            socket.on('mines game', function(data){
                this.game(data);
            }.bind(this));
            socket.on('mines settings', function(data){
                this._settings.update(data);
            }.bind(this));
            socket.on('mines cashed out', function(data){
                this.end(data);
            }.bind(this));
        }
    };
    mines.init();
});