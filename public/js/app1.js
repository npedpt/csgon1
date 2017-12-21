var csrftoken = $('meta[name="csrf-token"]').attr('content');
var websocket = $('meta[name="websocket"]').attr('content');
var lang = $('meta[name="language"]').attr('content');
var themecolor = $('meta[name="themecolor"]').attr('content');
var logged = $('meta[name="logged"]').attr('content') === '1';
var steamid = $('meta[name="steamid"]').attr('content');
var username = $('meta[name="username"]').attr('content');
var avatar = $('meta[name="avatar"]').attr('content');
var token = $('meta[name="token"]').attr('content');
var time = $('meta[name="time"]').attr('content');
var game = $('meta[name="game"]').attr('content');
var tradeURL = $('meta[name="tradeURL"]').attr('content');

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrftoken } });

var socket = io(websocket);

socket.emit('init', {
    lang: lang,
    game: game,
    logged: logged,
    steamid: steamid,
    username: username,
    avatar: avatar,
    token: token,
    time: time
});

function notify(type, message) {
    var color = '#545454';
    if (type === 'error') {
        color = '#de2a2a';
    } else if (type === 'success') {
        color = '#35ae35';
    }

    $.amaran({
        content:{
            bgcolor: color,
            color:'#fff',
            message: message
        },
        theme:'colorful',
        position: 'bottom right',
        inEffect: 'slideBottom',
        outEffect: 'slideRight',
        delay: 7500
    });
}

function showTradeOffer(tradeOfferID) {
    var winOffer = window.open('https://steamcommunity.com/tradeoffer/'+ tradeOfferID+'/','','height=1120,width=1028,resize=yes,scrollbars=yes');
    winOffer.focus();
}

var Helpers = {
  generateItemHTML: function (item, price) {
      return '<div class="item ' + (price ? price : "junk") + '"  data-id="' + item.id + '" data-market-hash-name="' + (typeof item.market_name != "undefined" ? item.market_name : item.market_hash_name) + '" data-price="' + (price ? price : 0) + '" data-bot="' + item.bot_id + '">' +
          '<div class="price">' + (price ? price : "Junk") + '</div> ' +
          '<div class="item-name">' + (typeof item.market_name != "undefined" ? item.market_name : item.market_hash_name) + '</div> ' +
          '<img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/' + item.classid + '/190fx86f" alt="CSGO weapon"/> ' +
      '</div>';
  }
};

var _soundOn = true;

$(function(){
    var siteToggle = {
        $nav: $("nav"),
        $menuu: $("nav .navbar-pages"),
        $menuuu: $(".sidebar-nav"),
        $chatheader: $(".chat-header"),
        $chat: $(".chat"),
		$sendarea1: $(".sendarea1"),
		$chatmessages1: $(".chatmessages1"),
        $container: $(".center"),
        $freeCoinsArea: $("nav .free-coins-area"),
        $giveawayArea: $("nav .giveaway-area"),
        $loginArea: $('nav .navbar-player'),
        $chatToggle: $(".chat-toggle-button"),
        $chatToggleShow: $(".chat-toggle-button-green"),
        $menuToggle: $(".menu-toggle-button"),
        $soundToggle: $(".sound-toggle-button"),
        $main: $("main"),
        _animateDuration: 600,
        $balance: $("nav .balance"),
        $balanceValue: $("nav .balance .value"),
        changeMenuSize: function() {
            this.resize();
        },
        menuToggle: function() {
            if (this.$menuuu.hasClass("menuhid")) {
                this.$menuuu.removeClass("menuhid").addClass("menusho").addClass("menushoo");
                this.$menuToggle.removeClass("open123")
                this.$chatheader.removeClass("menuhidchat");
                this.$chatmessages1.removeClass("menuhidchat2");
                localStorage.setItem("toggleMenu", "show");
            } else {
                this.$menuuu.removeClass("menusho").removeClass("menushoo").addClass("menuhid");
                this.$menuToggle.addClass("open123")
                this.$chatheader.addClass("menuhidchat");
                this.$chatmessages1.addClass("menuhidchat2");
                localStorage.setItem("toggleMenu", "hide");
            }
            this.changeMenuSize();
            this.balance();
            this.crash();
        },
        crash: function () {
            if (typeof crash != "undefined") {
                $("<div />")
                    .css("step",1)
                    .animate({
                        step: siteToggle._animateDuration
                    }, {
                        duration: siteToggle._animateDuration,
                        step: function () {
                            crash.resize();
                        }
                    });
            }
        },
        chatToggle: function () {
            if (this.$chat.hasClass("part-hide")) {
                this.$chat.removeClass("part-hide");
                this.$sendarea1.removeClass("part-hide");
                this.$chatmessages1.removeClass("part-hide");
                this.$chatToggle.find('i').attr('class', 'fa fa-angle-right');
                this.$chatToggle.removeClass("hide");
                this.$chatToggleShow.css('right', '-100px');
                this.$container.removeClass("chat-part-hide");
                localStorage.setItem("toggleChat", "show");
            } else {
                this.$chat.addClass("part-hide");
                this.$sendarea1.addClass("part-hide");
                this.$chatmessages1.addClass("part-hide");
                this.$chatToggle.find('i').attr('class', 'fa fa-angle-left');
                this.$chatToggle.addClass("hide");
                this.$chatToggleShow.css('right', '0px');
                this.$container.addClass("chat-part-hide");
                localStorage.setItem("toggleChat", "hide");
            }
            this.crash();
        },
        soundToggle: function () {
            if (_soundOn) {
                this.$soundToggle.find('i').attr('class', 'fa fa-volume-off');
                localStorage.setItem("toggleSound", "hide");
                _soundOn = false;
            } else {
                this.$soundToggle.find('i').attr('class', 'fa fa-volume-up');
                localStorage.setItem("toggleSound", "show");
                _soundOn = true;
            }
        },
        resize: function () {
            this.$nav.css('left', -1*$(window).scrollLeft());
            this.$nav.scrollTop(this.$main.scrollTop()+this.$container.scrollTop()+$("body").scrollTop());
            this.$main.css('min-height', $(this.$nav)[0].scrollHeight-92);
        },
        init: function () {
            $(window).resize(this.resize.bind(this));
            $(window).scroll(this.resize.bind(this));
            this.$main.scroll(this.resize.bind(this));
            this.$container.scroll(this.resize.bind(this));
            siteToggle.resize();

            var body = $("body");
            body.addClass("offToggleTransition");
            this.$menuToggle.click(this.menuToggle.bind(this));
            this.$chatToggle.click(this.chatToggle.bind(this));
            this.$soundToggle.click(this.soundToggle.bind(this));
            this.$chatToggleShow.click(this.chatToggle.bind(this));
            if (localStorage.getItem("toggleMenu")=="hide") this.menuToggle();
            if (localStorage.getItem("toggleChat")=="hide") this.chatToggle();
            if (localStorage.getItem("toggleSound")=="hide") this.soundToggle();
            setTimeout(function() {
                body.removeClass("offToggleTransition");
            }, 1);
            this.changeMenuSize();
        },
        balance: function () {
            if (this.$nav.hasClass("vaminini")) {
                this.$balanceValue.css("font-size", (19-this.$balanceValue.text().length)+"px");
            } else {
                this.$balanceValue.css("font-size", "20px");
            }
        }
    };
    siteToggle.init();

    function popup() {
        var $div = $(".popup");
        if ($div.css("display")=="block") {
            $div.fadeOut(300);
        } else {
            $div.fadeIn(300);
        }
    }

    $(".chat-info").click(popup);
    $(".popup-close").click(popup);



    var actual_href = $(".navbar-pages a[href='"+(location.href[location.href.length-1]=="/"?location.origin:location.href)+"']");
    actual_href.addClass("active");
    var balance = $('.balance');
    var balanceValue = $('.value', balance);

    $('#steam-id-copy').click(function(){
        var copyTextarea = document.querySelector('#steam-id');
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            notify(successful?'success':'error', 'Copying text command was ' + msg);
        } catch (err) {
            notify('error','Oops, unable to copy');
        }
    });

    $("#trade-url-send").click(function(){
        var token_regex = /token=([\w-]+)/.exec($("#trade-url").val());
        if (token_regex) {
            var token = token_regex[1];
            socket.emit('trade token', token);
        }
    });

    socket.on('users online', function(count) { $('.players-online').text(count); });

    socket.on('notify', function(type, message, data) {
        if (locale[message]) message = locale[message];
        data = data || [];
        notify(type, vsprintf(message, data));
    });

    socket.on('balance change', function(value) {
        balance.data('balance', parseInt(balance.data('balance')) + value);
        balanceValue.html(balance.data('balance'));
        siteToggle.balance();
    });

    window.bal = function (value) {
        balance.data('balance', parseInt(balance.data('balance')) + value);
        balanceValue.html(balance.data('balance'));
        siteToggle.balance();
    }

});

$(function() {
    var chatToggle = {
        $button: $("#chat-close"),
        $div: $("#chat .chat, .chat-messages"),
        _visible: true,
        toggle: function (fast) {
            var animationSpeed = fast === true ? 0 : 300;
            if (this._visible) {
                this.$button
                    .attr("class", "fa fa-angle-right")
                    .animate({
                        right: "20px"
                    }, animationSpeed);
                this.$div.animate({
                    right: "-300px"
                }, animationSpeed);
            } else {
                this.$button
                    .attr("class", "fa fa-angle-left")
                    .animate({
                        right: "320px"
                    }, animationSpeed);
                this.$div.animate({
                    right: "0px"
                }, animationSpeed);
            }
            this._visible = !this._visible;
            localStorage.setItem("toggleChat", this._visible ? "show" : "hide");
        },
        init: function () {
            this.$button.click(this.toggle.bind(this));
            if (localStorage.getItem("toggleChat") == "hide") this.toggle(true);
        }
    };
    chatToggle.init();

    var sidebarToggle = {
        $button: $("#left-menu-close"),
        $div: $("#sidebar-wrapper, .sidebar-nav"),
        _visible: true,
        toggle: function (fast) {
            var animationSpeed = fast === true ? 0 : 300;
            if (this._visible) {
                this.$button
                    .attr("class", "fa fa-angle-right")
                    .animate({
                        left: "20px"
                    }, animationSpeed);
                this.$div.animate({
                    left: "-250px"
                }, animationSpeed);
            } else {
                this.$button
                    .attr("class", "fa fa-angle-left")
                    .animate({
                        left: "320px"
                    }, animationSpeed);
                this.$div.animate({
                    left: "0px"
                }, animationSpeed);
            }
            this._visible = !this._visible;
            localStorage.setItem("toggleSidebar", this._visible ? "show" : "hide");
        },
        init: function () {
            this.$button.click(this.toggle.bind(this));
            if (localStorage.getItem("toggleSidebar") == "hide") this.toggle(true);
        }
    };
    sidebarToggle.init();

    $("#sidebar-wrapper a").each(function(){
       $(this).parent().parent().click(function(){
           //window.location.href = $(this).attr("href");
       }.bind(this))
    });
});


Number.prototype.parseValue = function() {
    return this.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
};