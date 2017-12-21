
$(function() {
    "use strict";

    //FIXME: Remove global variable - need to edit admin scripts
    window.chat = {
        $div: $(".chat"),
        _input: $(".chat-input"),
        $send: $(".send-message"),
        $area: $(".chat-messages"),
        _lastMessage: 0,
        _chatCooldown: 2,
        _maxMessages: 25,
        _messages: [],
        updateDisplay: function() {
            this.$area.empty();
            this._messages.forEach(function(item) {
                this.displayMessage(item, true);
            }.bind(this));
            this.$area.animate({
                scrollTop: this.$area[0].scrollHeight
            }, 0);
        },
        displayMessage: function(item, bypass) {
            var scroll = true;

            if (this.$area.children().length >= this._maxMessages) {
                this.$area.children().first().remove();
                scroll = false;
            }

            if (typeof item.message != 'undefined') {
                item.message = this.emots.rep(item.message);
            }

            if (item.hasOwnProperty('profile')) {
                $('<div class="chat-message" data-uniqueid="' + item.uniqueID + '" data-id="' + item.profile.steamid + '" data-username="' + item.profile.username + '"> ' +
                    '<div class="avatar"><img src="' + item.profile.avatar + '"> </div> ' +
                    '<div class="message"> ' +
                    '<div class="nickname ' + item.profile.rank + '"><a target="_blank" href="//steamcommunity.com/profiles/' + item.profile.steamid + '">' + item.profile.username + '</a>' + '<span style="opacity: 0.5;font-size: 12px;color: #e1e7ee;float:right;"> ' + chat.timeConvert(item.time) + '</span>' + '</div> ' +
                    '<div class="text">' + item.message + '</div>' +
                    '</div></div>').hide().appendTo(this.$area).fadeIn(500);
            } else if (item.hasOwnProperty('custom')) {
                $('<div class="chat-message"> ' +
                    '<div class="avatar"><img src="/img/avatar.jpg"> </div> ' +
                    '<div class="message"> ' +
                    '<div class="nickname siteAdmin">csgon1.com</div> ' +
                    '<div class="text">' + vsprintf((item.custom.messageCode && locale.hasOwnProperty(item.custom.messageCode) ? locale[item.custom.messageCode] : this.emots.rep(item.custom.message)), item.custom.variables || []) + '</div>' +
                    ' </div> ' +
                    '</div>').hide().appendTo(this.$area).fadeIn(500);
            }

            if (!bypass) {
                if (scroll) {
                    this.$area.animate({scrollTop: this.$area[0].scrollHeight}, 1500, 'easeInQuart');
                } else {
                    this.$area.animate({scrollTop: this.$area[0].scrollHeight}, 0);
                }
            }
        },
		timeConvert: function(UNIX_timestamp){
          var a = new Date(UNIX_timestamp * 1000);
          var hour = a.getHours();
          var min = a.getMinutes() < 10 ? '0' + a.getMinutes() : a.getMinutes();
          var time = hour + ':' + min;
          return time;
        },
        addChat: function(profile, message, uniqueID, time) {
            if (this._messages.length >= this._maxMessages) this._messages.shift();
            var msg = {profile: profile, message: message, uniqueID: uniqueID, time: time};
            this._messages.push(msg);
            this.displayMessage(msg);
        },
        addCustom: function(message, messageCode, variables) {
            if (this._messages.length >= this._maxMessages) this._messages.shift();
            var msg = {custom: {message: message, messageCode: messageCode, variables: variables}};
            this._messages.push(msg);
            this.displayMessage(msg);
        },
        send: function () {
            this.sendMessage(this._input.val());
        },
        sendMessage: function(message) {
            if (message === '') return;
            if (this._lastMessage > (Date.now() - this._chatCooldown * 1000)) {
                notify('error', vsprintf(locale.chatCooldown, [((this._lastMessage - (Date.now() - (this._chatCooldown * 1000))) / 1000).toFixed(1)]));
                return;
            }
            this._input.val('');
            this._lastMessage = Date.now();
            socket.emit('chat message', {'type': 'chat', 'message': message});
        },
        emots: {
            parent: false,
            _list: "1v1|rainbow|train|gabe|feelsbadman|feelsgoodman|rigged|fml|facepalm|heart|knife|hi|isaac|kappa|kappapride|ragkeepo|keepo|squiddab|sad1|sad2|sad3|sad4|sad5|sad6|smile1|smile2|smile4|tongue2",
            $button: $(".emots-button"),
            $emots: $(".emots"),

            emotsToggle: function() {
                if (this.$emots.css('display')=="none") {
                    this.$emots.fadeIn(300);
                } else {
                    this.$emots.fadeOut(300);
                }
            },
            rep: function (txt) {
                return txt.replace(new RegExp(":("+this._list+"):",'gi'), function(emote) {
                    return '<img class="emote" src="/img/emotes/' + emote.toLowerCase().split(":").join("") + '.png">';
                });
            },
            init: function () {
                this.$button.click(this.emotsToggle.bind(this));
                this._list.split('|').forEach(function(emote) {
                    $('<div class="emote" data-val="'+emote+'"><img src="/img/emotes/'+emote+'.png"></div>')
                        .click(function(e) {
                            this.$emots.fadeOut(300);
                            this.parent._input.val( this.parent._input.val() + ' :' + $(e.currentTarget).data('val')+': ').focus();
                        }.bind(this))
                        .appendTo(this.$emots);
                }.bind(this));
            }
        },
        init: function () {
            this.emots.parent = this;
            this.emots.init();

            socket.on('chat', function(messages) {
                this._messages = messages;
                this.updateDisplay();
            }.bind(this));
            socket.on('chat message', function(data) {
                this.addChat(data.profile, data.message, data.uniqueID, data.time);
            }.bind(this));
            socket.on('chat custom message', function(data) {
                this.addCustom(data.message, data.messageCode, data.variables);
            }.bind(this));

            this._input.on('keypress', function(e) {
                if (e.keyCode == 13)
                    return this.send() && false;
            }.bind(this));
            this.$send.click(this.send.bind(this));
        }
    };

    chat.init();

    $('html').contextMenu({
        selector: '.chat-message',
        transition: {
            speed: 300, // In milliseconds
            type: 'slideLeft'
        },
        position: {
            my: 'right top-25',
            at: 'left'
        },
        partner: this,
        items: function(e) {
            var user = $(e.target).closest('.chat-message');
            if (!user.data('id')) return;
            return [
                {type: 'title', text: user.data('username')},
                {type: 'item', text: locale.sendCoins, click: function() {
                    chat._input.val('/send ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.muteUser, click: function() {
                    chat._input.val('/mute ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.unmuteUser, click: function() {
                    chat._input.val('/unmute ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.giveCoins, click: function() {
                    chat._input.val('/give ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.changeAccess, click: function() {
                    chat._input.val('/access ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.checkCoins, click: function() {
                    chat._input.val('/coins').focus();
                }},
                {type: 'item', text: locale.muteChat, click: function() {
                    chat._input.val('/muteChat').focus();
                }},
                {type: 'item', text: locale.unmuteChat, click: function() {
                    chat._input.val('/unmuteChat').focus();
                }},
                {type: 'item', text: locale.removeMessages, click: function() {
                    chat._input.val('/removeMessages ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.removeMessage, click: function() {
                    chat._input.val('/removeMessage ' + user.data('uniqueid')).focus();
                }},
                {type: 'item', text: locale.visitProfile, click: function() {
                    var win = window.open('http://steamcommunity.com/profiles/' + user.data('id'), '_blank');
                    win.focus();
                }}
            ]
        }
    });
});
