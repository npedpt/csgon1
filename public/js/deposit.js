$(function() {
    "use strict";

    window.deposit = ({
        _minCoinsToDeposit: 10,
        _totalValue: 0,
        _prices: null,
        _items: null,
        _algorithm: 'price desc',
        _inventory: $('.items.inventory'),
        _confirmationButton: $('.confirm-button'),
        _selected: [],
        _inProgress: false,
        set prices(x) {
            var prices = {};
            x.forEach(function(item) {
                prices[item.market_hash_name] = item.price;
            });
            this._prices = prices;
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
            var price = (this._prices[item.market_hash_name] >= this._minCoinsToDeposit ? this._prices[item.market_hash_name] : false);
            this._inventory.append(Helpers.generateItemHTML(item, price));
        },
        sort: function(use_algorithm) {
            if (use_algorithm !== false)
            switch (this._algorithm) {
                default:
                case 'price desc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(b).data('price') - $(a).data('price');}));
                    break;
                case 'price asc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(a).data('price') - $(b).data('price');}));
                    break;
                case 'name desc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(a).data('market-hash-name').localeCompare($(b).data('market-hash-name'));}));
                    break;
                case 'name asc':
                    this._inventory.html($('.item', this._inventory).sort(function(a, b) {return $(b).data('market-hash-name').localeCompare($(a).data('market-hash-name'));}));
                    break;
            }
        },
        load: function(reload) {
            this._inventory
                .empty(0)
                .append('<div class="loading">Loading equipment<span class="ldots"><span class="one">.</span><span class="two">.</span><span class="three">.</span>​</span></div>');
            this._selected = [];
            $('.search')[0].disabled = true;
            $('.select').attr('off', 'true');
            $(".force-reload")[0].disabled = true;
            this.totalValue = 0;
            socket.emit('request inventory', reload);
        }
    });

    $(".force-reload").click(function(){
        deposit.load(true);
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
        deposit.algorithm = $(this).attr('value');
        $(this).parent().find("div").removeClass("active");
        $(this).parent().fadeOut(300);
        $(this).addClass("active");
    });

    $('.search').on('input', function() {
        $('.item', deposit._inventory).each(function() {
            if($(this).data('market-hash-name').toLowerCase().indexOf($('.search').val().toLowerCase()) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
        deposit.sort();
    });

    deposit._inventory.on('click', '.item', function() {
        if (deposit._inProgress) return;
        if ($(this).hasClass('junk')) return;

        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
            deposit._selected.splice(deposit._selected.indexOf($(this).data('id')), 1);
            deposit.totalValue = deposit.totalValue - parseInt($(this).data('price'));
        } else {
            if (deposit._selected.length >= 20) return notify('error', 'You can add only 20 items at once!');
            $(this).addClass("selected");
            deposit._selected.push($(this).data('id'));
            deposit.totalValue = deposit.totalValue + parseInt($(this).data('price'));
        }
        deposit.sort(false);
    });

    deposit._confirmationButton.on('click', function() {
        if (deposit._inProgress) return;
        $('.deposit-content').addClass('sending');
        socket.emit('deposit items', deposit._selected);
        $(this).addClass('disabled');
        deposit._inProgress = true;
        notify('info', locale.depositRequestSent);
    });

    socket.on('deposit success', function(tradeID) {
        $('.deposit-content').removeClass('sending').addClass('sent');
    });

    socket.on('deposit error', function() {
        deposit._confirmationButton.removeClass('disabled');
        deposit._inProgress = false;
        $('.deposit-content').removeClass('sending');
    });

    socket.on('inventory', function(data) {
        data = data || {};
        deposit.prices = data.prices || [];
        deposit.items = data.inventory || [];
        $('.items .loading').remove();
        $('.search')[0].disabled = false;
        $('.select')[0].disabled = false;
        $(".force-reload")[0].disabled = false;
    });

    deposit.load(false);
});