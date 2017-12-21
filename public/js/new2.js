"use strict";
var CASEW = 1050;
var LAST_BET = 0;
var MAX_BET = 0;
var HIDEG = false;
var USER = "";
var RANK = 0;
var ROUND = 0;
var HOST = "138.68.104.53:8081"; // Edit this to your own IP or domain and port. Check the readme.txt for CloudFlare ports.
var SOCKET = null;
var showbets = true;
var carnat = null;
var betplaced;


function onMessage(msg) {
	var m = msg;
	//console.log(msg);
	if (m.type == "preroll") {
			$("#counter").finish();
			$("#banner").html("Confirming " + m.totalbets + "/" + (m.totalbets + m.inprog) + " total bets...");
            $("#panel0-0-t .total").html(m.sums[0]);
            $("#panel1-7-t .total").html(m.sums[1]);
            $("#panel8-14-t .total").html(m.sums[2]);
		try {
			tinysort("#panel1-7-t .betlist>li", {
				data: "amount",
				order: "desc"
			});
		} catch (e) {}
		try {
			tinysort("#panel8-14-t .betlist>li", {
				data: "amount",
				order: "desc"
			});
		} catch (e) {}
		try {
			tinysort("#panel0-0-t .betlist>li", {
				data: "amount",
				order: "desc"
			});
		} catch (e) {}
	} else if (m.type == "roll") {
		$(".betButton").prop("disabled", true);
		$("#counter").finish();
		$("#banner").html("***ROLLING***");
		ROUND = m.rollid;
		showbets = false;
		spin(m);
	} else if (m.type == "chat") {
	} else if (m.type == "hello") {
		$("#crbalance").countTo(m.balance);
		cd(m.count);
		USER = m.user; // steamid
		var last = 0;
		for (var i = 0; i < m.rolls.length; i++) {
			addHist(m.rolls[i].roll, m.rolls[i].rollid);
			last = m.rolls[i].roll;
			ROUND = m.rolls[i].rollid;
		}
		snapRender(last, m.last_wobble);
		MAX_BET = m.maxbet;
        } else if (m.type == "bet") {
            if (showbets) {
                addBet(m.bet);
                $("#panel0-0-t .total").html(m.sums[0]);
                $("#panel1-7-t .total").html(m.sums[1]);
                $("#panel8-14-t .total").html(m.sums[2])
            }
	} else if (m.type == "betconfirm") {
		$("#panel" + m.bet.lower + "-" + m.bet.upper + "-t .mytotal").html(m.bet.amount);
		$("#balance").html(m.balance, {
			"color": true
		});
refreshcreds();
		checkplus(m.balance);
		$(".betButton").prop("disabled", false);
	} else if (m.type == "error") {
		if (m.enable) {
			$(".betButton").prop("disabled", false);
		}
	} else if (m.type == "alert") {

		if (m.maxbet) {
			MAX_BET = m.maxbet;
		}
		if (!isNaN(m.balance)) {
			//console.log("setting balance = %s", m.balance);
			$("#balance").html(m.balance, {
				"color": true
			});
		refreshcreds();
			checkplus(m.balance);
		}
	} else if (m.type == "logins") {
		$("#isonline").html(m.count);
	} else if (m.type == "balance") {
		$("#crbalance").fadeOut(100).html(todongersb(m.balance)).fadeIn(100);
		refreshcreds();
		$("#balance").fadeOut(100).html(todongersb(m.balance)).fadeIn(100);
		checkplus(m.balance);
	}
	else if(m.type == 'startcrash') {
		$('#crash-graphics').text('Round starting in: '+(m.time/100).toFixed(1)+'s');
		Engine.startTime = m.time/100;
		Engine.gameState = "STARTING";
		carnat = new Date;
	} else if(m.type == 'urcarecrash') {
		var nrgr = m.grafic;
		Engine.currentCrashNumber = nrgr;
		if(Engine.startTime < 7 ){
			Engine.startTime = new Date;
		}
		Engine.gameState = "IN_PROGRESS";
		$('#crash-graphics').text((nrgr/100).toFixed(2)+'x');
	} else if(m.type == 'crashed') {
		var crashNR = m.crashmanule;
		Engine.gameCrash = crashNR;
		Engine.gameState = "ENDED";
		if(crashNR) {
			$('#crash-graphics').html('<span style="color:red">Crashed <p>@ '+(crashNR/100).toFixed(2)+'x'+'</span></b>');
		}
	} else if (m.type == "crbet") {
		addCrashBet(m.bet);
	} else if (m.type == "crbetconfirm") {
		betplaced = true;
		$(".joinCrash").prop("disabled", false);
	} else if(m.type == "crashCashout") {
		var playerSTEAMID = m.playerSTEAMID;
		var playerNAME = m.playerNAME;
		var playerAMOUNT = m.playerAMOUNT;
		var playerBALANCE = m.playerBALANCE;
		var playerCASHOUT = m.playerCASHOUT;
		var playerPROFIT = m.playerPROFIT;
		refreshcreds();

		//EDIT @ value.
		editValue('at', playerSTEAMID, playerCASHOUT);
		//EDIT PROFIT value.
		editValue('profit', playerSTEAMID, playerPROFIT);

		betplaced = false;


	} else if(m.type == "removeQCR") {
		$('.crbetlist').html('<thead><th>Players</th><th>X</th><th>Bet</th><th>Profit</th></tbody>');
		$('.joinCrash').attr('value','Place bet');
		$('.joinCrash').prop('disabled', false);
		$('.joinCrash').attr('data-todo', 'joinCrash');
	} else if(m.type == 'withdrawBTN') {
		$('.joinCrash').attr('value','WITHDRAW +'+m.money);
		if($('.joinCrash').attr('data-todo') == 'withdraw') {

		}else {
			$('.joinCrash').attr('data-todo', 'withdraw');
		}
	}


}

var highestbet1;
var highestbet2;
var highestbet3;
function checkhighestbet(bet){
	if(highestbet1 == null){
		highestbet1 = 0;
	}	if(highestbet2 == null){
			highestbet2 = 0;
		}	if(highestbet3 == null){
				highestbet3 = 0;
			}

if(bet.lower == 1){
	if(bet.amount > highestbet1){
			highestbet1 = bet.amount;
			addhighestbet(bet);
	}
}

if(bet.lower == 0){
	if(bet.amount > highestbet2){
			highestbet2 = bet.amount;
		  addhighestbet(bet);
	}
}
if(bet.lower == 8){
	if(bet.amount > highestbet3){
			highestbet3 = bet.amount;
		  addhighestbet(bet);
	}
}

}
function addhighestbet(bet){

if(bet.lower == 1){
	$(".redhighest").html("<p>"+bet.name+"</p>");
	$(".redhighestamount").html("<p>"+bet.amount+"</p>");
	$(".redhighestav").html("<img src="+bet.icon+" class='highest-bidder' />");

}
if(bet.lower == 0){
	$(".greenhighest").html("<p>"+bet.name+"</p>");
	$(".greenhighestamount").html("<p>"+bet.amount+"</p>");
	$(".greenhighestav").html("<img src="+bet.icon+" class='highest-bidder' />");

}
if(bet.lower == 8){
	$(".blackhighest").html("<p>"+bet.name+"</p>");
	$(".blackhighestamount").html("<p>"+bet.amount+"</p>");
	$(".blackhighestav").html("<img src="+bet.icon+" class='highest-bidder' /> ");

}

}
function clearhighestbet(){
	$(".redhighest").html("<p></p>");
	$(".redhighestamount").html("<p></p>");
	$(".redhighestav").html("<p></p>");

	highestbet1 =0;

	$(".greenhighest").html("<p></p>");
	$(".greenhighestamount").html("<p></p>");
	$(".greenhighestav").html("<p></p>");
	highestbet2 = 0;

	$(".blackhighest").html("<p></p>");
	$(".blackhighestamount").html("<p></p>");
	$(".blackhighestav").html("<p></p>");

	highestbet3 = 0;
}
function refreshcreds(){
}




function addCrashBet(bet) {
	var pid = "#panelcrash";
	var $panel = $(pid);
	var f = "<tr class='{0}'><td><img class='rounded' src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars{1}' height='32px' width='32px' > <b>{2}</b></td>";
	f += "<td class='at{0}'>-</td>";
	f += "<td>{3}</td>";
	f += "<td class='profit{0}'>-</td></tr>";
	var $li = $(f.format(bet.user, bet.icon, bet.name, todongersb(bet.amount)));
	$li.hide().prependTo($panel.find(".crbetlist")).slideDown("fast", function() {});
	refreshcreds();
}

function connect() {
	if(!SOCKET) {
		if(!hash) {

		} else {
			console.log('Attempting to connect');
			SOCKET = io(HOST);
			SOCKET.on('connect', function(msg) {
				SOCKET.emit('hash', hash);
			});
			SOCKET.on('connect_error', function(msg) {
			});
			SOCKET.on('message', function(msg) {
				onMessage(msg);
			});
		}
	} else {
		//console.log("Error: connection already exists.");
	}
}

$(document).ready(function() {
	crUpdateHistory();
	function crUpdateHistory() {
	   $("#crHist").load("http://138.68.104.53/crash/getCRHistory.php");
	   var refreshId = setInterval(function() {
	      $("#crHist").load('http://138.68.104.53/crash/getCRHistory.php');
	   }, 1000);
	   $.ajaxSetup({ cache: false });
	}

	$(".joinCrash").on("click", function() {
		var amount = str2int($("#crbetSum").val());
		var autoWithdraw = str2int($("#crAutoWithdraw").val());
		var typebutton = $('.joinCrash').attr('data-todo');

		var aW;
		if(!autoWithdraw || autoWithdraw == '') {
			aW = 200;
			console.log(aW);
		}else if(autoWithdraw == '0'){
			aW = 100000000;
			console.log(aW);
		}else{
			aW = (autoWithdraw*100).toFixed(0);
			console.log(aW);
			refreshcreds();

		}
		if ($("#settings_dongers").is(":checked")) {
			amount = amount * 1000;
		}
		amount = Math.floor(amount);
		send({
			"type": "crbet",
			"amount": amount,
			"autoCash": aW,
			"mtype": typebutton
		});
		$(this).prop("disabled", true);

	});
	$(document).on("click", "#crgetbal", function() {
		refreshcreds();

		send({
			"type": "balance"
		});
	});

	if ($("#settings_dongers").is(":checked")) {
		$("#dongers").html("$");
	}
	$("#lang").on("change", function() {
		LANG = $(this).val();
	});
	$("#scroll").on("change", function() {
		SCROLL = !$(this).is(":checked");
	});
	$(window).resize(function() {
		snapRender();
	});
	$("#chatForm").on("submit", function() {
		var msg = $("#chatMessage").val();
		if (msg) {
			var res = null;
			if (res = /^\/send ([0-9]*) ([0-9]*)/.exec(msg)) {
				bootbox.confirm("You are going to send " + res[2] + " to the Steam ID " + res[1] + " - are you sure?", function(result) {
					if (result) {
						send({
							"type": "chat",
							"msg": msg,
							"lang": LANG
						});
						$("#chatMessage").val("");
					}
				});
			} else {
				var hideme = $("#settings_hideme").is(":checked");
				send({
					"type": "chat",
					"msg": msg,
					"lang": LANG,
					"hide": hideme,
				});
				$("#chatMessage").val("");
			}
		}
		return false;
	});
	$(document).on("click", ".ball", function() {
		var rollid = $(this).data("rollid");
	});
	$(".betButton").on("click", function() {
		var lower = $(this).data("lower");
		var upper = $(this).data("upper");
		var amount = str2int($("#betAmount").val());
		if ($("#settings_dongers").is(":checked")) {
			amount = amount * 1000;
		}
		amount = Math.floor(amount);
		var conf = $("#settings_confirm").is(":checked");
		if (conf && amount > 10000) {
			var pressed = false;
			bootbox.confirm("Are you sure you want to bet " + formatNum(amount) + " credits?<br><br><i>You can disable this in settings.</i>", function(result) {
				if (result && !pressed) {
					pressed = true;
					send({
						"type": "bet",
						"amount": amount,
						"lower": lower,
						"upper": upper,
						"round": ROUND
					});
					LAST_BET = amount;
					$(this).prop("disabled", true);
				}
			});
		} else {
			send({
				"type": "bet",
				"amount": amount,
				"lower": lower,
				"upper": upper,
				"round": ROUND
			});
			LAST_BET = amount;
			$(this).prop("disabled", true);
		}
		return false;
	});
	$('#oneplusbutton').on("click", function() {
		//console.log('+1');
		send({
			"type": "plus"
		});
	});
	$(document).on("click", ".betshort", function() {
		var bet_amount = str2int($("#betAmount").val());
		var action = $(this).data("action");
		if (action == "clear") {
			bet_amount = 0;
		} else if (action == "double") {
			bet_amount *= 2;
		} else if (action == "half") {
			bet_amount /= 2;
		} else if (action == "max") {
			var MX = MAX_BET;
			if ($("#settings_dongers").is(":checked")) {
				MX = MAX_BET / 1000;
			}
			bet_amount = Math.min(str2int($("#balance").html()), MX);
		} else if (action == "last") {
			bet_amount = 0;
		} else {
			bet_amount += parseInt(action);
		}
		$("#betAmount").val(bet_amount);
	});
	$("#getbal").on("click", function() {
		refreshcreds();
		send({
			"type": "balance"
		});
	});
	$("button.close").on("click", function() {
		$(this).parent().addClass("hidden");
	});
	$(document).on("contextmenu", ".chat-img", function(e) {
		if (e.ctrlKey) return;
		$("#contextMenu [data-act=1]").hide();
		$("#contextMenu [data-act=2]").hide();
		if (RANK == 100) {
			$("#contextMenu [data-act=1]").show();
			$("#contextMenu [data-act=2]").show();
		} else if (RANK == 1) {
			$("#contextMenu [data-act=1]").show();
		}
		e.preventDefault();
		var steamid = $(this).data("steamid");
		var name = $(this).data("name");
		$("#contextMenu [data-act=0]").html(name);
		var $menu = $("#contextMenu");
		$menu.show().css({
			position: "absolute",
			left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
			top: getMenuPosition(e.clientY, 'height', 'scrollTop')
		}).off("click").on("click", "a", function(e) {
			var act = $(this).data("act");
			e.preventDefault();
			$menu.hide();
			if (act == 0) {
				var curr = $("#chatMessage").val(steamid);
			} else if (act == 1) {
				var curr = $("#chatMessage").val("/mute " + steamid + " ");
			} else if (act == 2) {
				var curr = $("#chatMessage").val("/kick " + steamid + " ");
			} else if (act == 3) {
				var curr = $("#chatMessage").val("/send " + steamid + " ");
			} else if (act == 4) {
				IGNORE.push(String(steamid));
			}
			$("#chatMessage").focus();
		});
	});
	$(document).on("click", function() {
		$("#contextMenu").hide();
	});
	$(".side-icon").on("click", function(e) {
		e.preventDefault();
		var tab = $(this).data("tab");
		if ($(this).hasClass("active")) {
			$(".side-icon").removeClass("active");
			$(".tab-group").addClass("hidden");
			$("#mainpage").css("margin-left", "50px");
			$("#pullout").addClass("hidden");
		} else {
			$(".side-icon").removeClass("active");
			$(".tab-group").addClass("hidden");
			$(this).addClass("active");
			$("#tab" + tab).removeClass("hidden");
			$("#mainpage").css("margin-left", "450px");
			$("#pullout").removeClass("hidden");
			if (tab == 1) {
				$("#newMsg").html("");
			}
		}
		snapRender();
		return false;
	});
    $(".smiles li img").on("click", function() {
        $("#chatMessage").val($("#chatMessage").val() + $(this).data("smile") + " ")
    });
    $('.clearChat').on("click", function() {
        $('#chatArea').html("<div><b class='text-success'>Chat cleared!</b></div>")
    });
    $(document).on("click", ".deleteMsg", function(e) {
        var t = $(this).data("id");
        send({
            type: "delmsg",
            id: t
        })
    });
    $(".side-icon[data-tab='1']").trigger("click")
});

function getAbscentPhrases(msg) {
    var phrases = ["hello", 1, "simba"];
    for (var i = 0; i < phrases.length; i++) {
        if (msg.toLowerCase().indexOf(phrases[i]) + 1) {
            return 1
        }
    }
    return 0
}

function changeLang(id) {
   // LANG = $(this).val();
    //$(".lang-select").html($(".language > li").eq(id - 1).find("a").html());

}

function getMenuPosition(mouse, direction, scrollDir) {
	var win = $(window)[direction](),
		scroll = $(window)[scrollDir](),
		menu = $("#contextMenu")[direction](),
		position = mouse + scroll;
	if (mouse + menu > win && menu < mouse)
		position -= menu;
	return position;
}
function editValue(value1, value2, value3){
	if(value1 == 'at') {
		$('.at'+value2).html('<span style="color:green">'+(value3/100).toFixed(2)+'x</span>');
		$('.at'+value2).addClass('won');
	}else if(value1 == 'profit') {
		$('.profit'+value2).html('<span style="color:green">+'+value3+'</span>');
		$('.profit'+value2).addClass('won');
	}
}

function str2int(s) {
	s = s.replace(/,/g, "");
	s = s.toLowerCase();
	var i = parseFloat(s);
	if (isNaN(i)) {
		return 0;
	} else if (s.charAt(s.length - 1) == "k") {
		i *= 1000;
	} else if (s.charAt(s.length - 1) == "m") {
		i *= 1000000;
	} else if (s.charAt(s.length - 1) == "b") {
		i *= 1000000000;
	}
	return i;
}
