$(function() {
    "use strict";

    window.withdraw = ({
        _totalValue: 0,
        _prices: null,
        _items: null,
        __bot: null,
        _algorithm: 'price desc',
        _inventory: $('.items.inventory'),
        _userChoice: $('.items.user'),
        _confirmationButton: $('.confirm-button'),
        _botInput: $('.bot-selected'),
        _selected: [],
        _inProgress: false,
        set prices(x) {
            var prices = {};
            x.forEach(function(item) {
                prices[item.market_hash_name] = item.price;
            });
            this._prices = prices;
        },
        set _bot (x) {
            this.__bot = x;
            console.log(x);
             this._botInput.val(x==null ? 'All items':'Items from one Bot');
        },
        get _bot () {
            return this.__bot;
        },
        set items(x) {
            this._items = x;
            this.updateDisplay();
        },
        set totalValue(x) {
            this._totalValue = x;
            $('.items-value .value').text(x);
            $('.items-amount .value').text(this._selected.length);
        },
        get totalValue() {
            return this._totalValue;
        },
        set algorithm(x) {
            this._algorithm = x;
            this.sort();
        },
        updateDisplay: function() {
            var self = this;
            this._inventory.empty();
            this._items.forEach(function(item) {
                self.appendItem(item);
            });
            this.sort();
        },
        appendItem: function(item) {
            this._inventory.append(Helpers.generateItemHTML(item, this._prices[item.market_hash_name]));
        },
        sort: function(use_algorithm) {
            $('.item', withdraw._inventory).each(function() {
                if (withdraw._bot && $(this).data('bot') !== withdraw._bot) {
                    $(this).hide();
                } else {
                    if ($(this).data('filter') !== 'true') $(this).show();
                }
            });
            if (use_algorithm !== false)
            switch (this._algorithm) {
                default:
                case 'price desc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(b).data('price') - $(a).data('price');}));
                    this._userChoice.html($('.item', this._userChoice).sort(function(a, b) {return $(b).data('price') - $(a).data('price');}));
                    break;
                case 'price asc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(a).data('price') - $(b).data('price');}));
                    this._userChoice.html($('.item', this._userChoice).sort(function(a, b) {return $(a).data('price') - $(b).data('price');}));
                    break;
                case 'name desc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(a).data('market-hash-name').localeCompare($(b).data('market-hash-name'));}));
                    this._userChoice.html($('.item', this._userChoice).sort(function(a, b) {return $(a).data('market-hash-name').localeCompare($(b).data('market-hash-name'));}));
                    break;
                case 'name asc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(b).data('market-hash-name').localeCompare($(a).data('market-hash-name'));}));
                    this._userChoice.html($('.item', this._userChoice).sort(function(a, b) {return $(b).data('market-hash-name').localeCompare($(a).data('market-hash-name'));}));
                    break;
            }
        },
        _writing: null,
        inputSort: function() {
            $('.item', withdraw._inventory).each(function() {
                if ($(this).data('market-hash-name').toLowerCase().indexOf($('.search').val().toLowerCase()) === -1) {
                    $(this).data('filter', 'true').hide();
                } else {
                    $(this).data('filter', 'false').show();
                }
            });
            withdraw.sort();
        },
        load: function() {
            this._inventory
                .empty()
                .append('<div class="loading">Loading equipment<span class="ldots"><span class="one">.</span><span class="two">.</span><span class="three">.</span>​</span></div>');


            $('.search')[0].disabled = true;
            $('.select').attr('off','true');
            $(".force-reload")[0].disabled = true;
            this._selected = [];
            this.totalValue = 0;


            $.get("/api/site-inventory", function(data) {
                notify('success', locale.loadSiteInventorySuccess);
                $('.items .loading').remove();
                withdraw.prices = data.prices;
                withdraw.items = data.inventory;
                $('.search')[0].disabled = false;
                $('.select').attr('off','false');
                $(".force-reload")[0].disabled = false;
            }).fail(function() {
                $('.items .loading').text(locale.loadSiteInventoryError).css('color', 'red');
                $(".force-reload")[0].disabled = false;
            });
        }
    });

    $(".select-button").click(function() {
        if($(this).parent().attr('off')=="true") return;
        var $open = $(this).parent().find(".select-open");
        if ($open.css("display", "none")) {
            $open.fadeIn(300);
        } else {
            $open.fadeOut(300);
        }
    });

    $(".select-box .select-open div").click(function() {
        if($(this).parent().attr('off')=="true") return;
        withdraw.algorithm = $(this).attr('value');
        $(this).parent().find("div").removeClass("active");
        $(this).parent().fadeOut(300);
        $(this).addClass("active");
    });

    $('.search').on('input', function() {
        withdraw._writing = new Date().getTime();
        setTimeout(function() {
            if(withdraw._writing + 300 -  new Date().getTime() <= 0)
                withdraw.inputSort();
        }, 300);
    });

    withdraw._inventory.on('click', '.item', function() {
        if (withdraw._inProgress) return;
        if ($(this).hasClass('junk')) return;

        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
            withdraw._selected.splice(withdraw._selected.indexOf($(this).data('id')), 1);
            withdraw.totalValue = withdraw.totalValue - parseInt($(this).data('price'));
            if (withdraw._selected.length === 0) withdraw._bot = null;
        } else {
            if (withdraw._bot && withdraw._bot !== $(this).data('bot')) return;
            if (withdraw._selected.length >= 20) return notify('error', 'You can add only 20 items at once!');
            $(this).addClass("selected");
            withdraw._selected.push($(this).data('id'));
            withdraw.totalValue = withdraw.totalValue + parseInt($(this).data('price'));
            if (!withdraw._bot) withdraw._bot = $(this).data('bot');
        }
        withdraw.sort(false);
    });

    withdraw._confirmationButton.on('click', function() {
        if (withdraw._inProgress) return;
        $('.withdraw-content').addClass('sending');
        socket.emit('withdraw items', withdraw._selected);
        $(this).addClass('disabled');
        withdraw._inProgress = true;
        notify('info', locale.withdrawRequestSent);
    });


    $(".force-reload").click(function(){
        withdraw.load();
    });

    withdraw.load();

    socket.on('withdraw success', function(tradeID) {
        $('.withdraw-content').removeClass('sending').addClass('sent');
    });

    socket.on('withdraw error', function() {
        withdraw._confirmationButton.removeClass('disabled');
        withdraw._inProgress = false;
        $('.withdraw-content').removeClass('sending');
    });
});