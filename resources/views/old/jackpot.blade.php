<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>csgon1.com - Jackpot</title>
        <meta property="og:title" content="csgon1.com" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta property="og:description" content="" />

        <meta name="csrf-token" content="63rWLQI6W2YMswWrBZLCww00RRFrqaq8AjeJtALr" />
        <meta name="language" content="en" />
        <meta name="websocket" content="http://138.68.104.53:8080" />
        <meta name="game" content="jackpot" />
        <meta name="logged" content="@if (Auth::check()){{1}}@else{{0}}@endif" />
        <meta name="steamid" content="@if (Auth::check()){{Auth::user()->steamid}}@endif" />
        <meta name="username" content="@if (Auth::check()){{Auth::user()->username}}@endif"/>
        <meta name="avatar" content="@if (Auth::check()){{Auth::user()->avatar}}@endif"/>
        <meta name="token" content="{{$token}}"/>
        <meta name="tradeURL" content="@if (Auth::check() && Auth::user()->tradeurl){{'https://steamcommunity.com/tradeoffer/new/?partner='.(substr(Auth::user()->steamid,7) - 7960265728).'&token='.Auth::user()->tradeurl}}@endif"/>
        <meta name="time" content="{{$time}}"/>
        
        <meta name="viewport" content="width=1400, initial-scale=1">

        <link rel="icon" type="image/png" href="/favicon.png" />
		<link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/app.css">
		
		<style>
		.roulette .player-bets .player-bet .amount {
			display: -ms-flexbox;
			display: flex;
			-ms-flex-align: center;
			align-items: center;
			-ms-flex-pack: center;
			justify-content: center;
			width: 50%;
			background: #161616;
		}
		.box-bets table tr td {
			width: 168px;
			padding: 5px;
		}
		.box-bets table tr td:first-child {
			width: auto;
			text-align: center;
			padding-left: 10px;
		}

		.box-bets table tr:first-child td {
			text-align: center;
			font-size: 16px;
			color: #fefefe;
			font-weight: 700;
			height: 45px;
		}
		.box-bets table tr:first-child td {
			text-align: center;
			font-size: 16px;
			color: #fefefe;
			font-weight: 700;
			height: 45px;
			background: #2c2c2c;
		}
		.roulette-info {
			text-align: center;
			background: #2c2c2c;
			border-bottom: 2px solid #161616;
			border-top: 2px solid #ffcc01;
			padding: 10px;
			font-weight: 700;
			width: 100%;
			margin-left: 32%;
		}
.box-bets {
    margin-top: 0px;
    background: #2c2c2c;
    border-top: 2px solid #1d1d1d;
    width: 100%;
	z-index:2;
	position: relative;
}
.roulette .roulette-wheel-outer {
    position: relative;
    background: #161616;
    border-bottom: 2px solid #ffcc01;
    padding: 12px;
    width: 66%;
	display: inline-block;
}
.boxes {
	display: -ms-flexbox;
	display: flex;
	-ms-flex-positive: 1;
	flex-grow: 1;
}

.box-history {
    background: #1d1d1d;
}

.box-history {
    width: 31.8%;
}

.box-history {
	width: 31.8%;
    background: #161616;
	float:right;
display: inline-block;
    overflow: auto;
    height: 346px;
	}

.top-box {
    -ms-flex-positive: 1;
    flex-grow: 1;
}

.bottomFade {
    position: relative;
}

.

.box-history {
    width: 31.8%;
    background: #161616;
    float: right;
    display: inline-block;
    overflow: auto;
    height: 346px;
	border-bottom: 2px solid #1d1d1d;
}
		</style>
		<!-- NOTIF -->
		
		  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "9d14001c-3a40-4683-a847-24a55237f42c",
      autoRegister: true, /* Set to true to automatically prompt visitors */
      subdomainName: 'csturbo.onesignal.com',
      /*
      subdomainName: Use the value you entered in step 1.4: http://imgur.com/a/f6hqN
      */
      httpPermissionRequest: {
        enable: true
      },
      notifyButton: {
          enable: false /* Set to false to hide */
      }
	  persistNotification: false // Automatically dismiss the notification after ~20 seconds in Chrome Deskop v47+
    }]);
  </script>
		
<!-- NOTIF -->	
    </head>
<body>
<nav>
    <div class="navbar-logo">
        <a href="/"><img src="/img/official.png"></a>
    </div>
        @if (Auth::check())
            <div class="navbar-player">
            <a href="/user/profile"><img class="player-avatar" src="{{Auth::user()->avatar}}"></a>
            <div class="player-text">
                <div class="welcome">Welcome</div>
                <div class="nickname">{{Auth::user()->username}}</div>
            </div>
            <div class="buttons">
                <a href="/user/profile"><i class="fa fa-cog" aria-hidden="true"></i></a>
                <a href="/auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </div>
        </div>
        @else
        <div class="sign-in">
        <a href="/auth/login"><img src="/img/sign-in.png"></a>
    </div>
@endif
@if (Auth::check())
        <div class="balance" data-balance="{{Auth::user()->wallet}}"><div class="balance-icon"><img src="/img/icons-small/coins.png"></div> <span class="value">{{Auth::user()->wallet}}</span> <a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div>
@endif        <ul class="navbar-pages">
        <li>
            <a href="/roulette" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-roulette"></div>
                </div>
                <div class="info">Roulette</div>
            </a>
        </li>
		<li>
            <a href="/coinflip" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-dice"></div>
                </div>
                <div class="info">Coin Flip</div>
            </a>
        </li>
		<li>
            <a href="/jackpot" class="navbar-href active">
                <div class="icons">
                    <div class="icon-big icon-mines"></div>
                </div>
                <div class="info">Jackpot</div>
            </a>
        </li>
		<li>
            <a href="/crash" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-up"></div>
                </div>
                <div class="info new">Crash</div>
            </a>
        </li>
    </ul>

    <ul class="navbar-pages">
        <li>
            <a href="/user/deposit" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-deposit"></div>
                </div>
                <div class="info">Deposit</div>
            </a>
        </li>
        <li>
            <a href="/user/withdraw" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-store"></div>
                </div>
                <div class="info">Store</div>
            </a>
        </li>
    </ul>

    <ul class="navbar-pages">
        <li>
            <a href="/user/referrals" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-referrals"></div>
                </div>
                <div class="info">Referrals</div>
            </a>
        </li>
        <li>
            <a href="/faq" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-faq"></div>
                </div>
                <div class="info">FAQ</div>
            </a>
        </li>
		<li>
            <a href="/giveaway" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-giveaway"></div>
                </div>
                <div class="info">Giveaway</div>
            </a>
        </li>
    </ul>


    <div class="navbar-img free-coins-area">
            <a href="/user/referrals" class="giveaway-img">
                <img src="/img/free-coins-nick.png">
            </a>
        </div>
            <!-- <div class="navbar-img giveaway-area">
            <a href="http://steamcommunity.com/groups/cs_gon1" target="_blank" class="giveaway-img">
                <img src="/img/join-steam-group.png">
            </a>
        </div> -->
		<div class="navbar-img free-coins-area">
            <a href="https://twitter.com/realcsgoturbo" class="giveaway-img">
                <img src="/img/free-coins-twitter.png">
            </a>
        </div>
    <center><p style="font-size:14px;">&copy; 2017 csgon1.com</p></center>
    <div class="online"><img src="/img/icons-small/players.png"><span class="players-online">0</span></div>
</nav>

<div class="center">
    <div class="top-navigation">
        <div class="circleButton menu-toggle-button"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
        <div class="circleButton sound-toggle-button"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
    </div>

    <div class="main-wrapper">
        <main>
                <div class="roulette">
        <div class="controls">
			<div class="color-select">
			
            </div>
            <div class="inputs-area">
                <div class="buttons">
                    <div class="button" data-action="clear">Clear</div>
                    <div class="button" data-action="last">Last</div>
                    <div class="button" data-action="100+"><span>+</span>100</div>
                    <div class="button" data-action="1000+"><span>+</span>1K</div>
                    <div class="button" data-action="10000+"><span>+</span>10K</div>
                    <div class="button" data-action="1/2">1<span>/</span>2</div>
                    <div class="button" data-action="x2"><span>X</span>2</div>
                    <div class="button" data-action="max">Max</div>
                </div>
                <div class="amount">
                    <label for="minesBet">Enter the amount: </label>
                    <input id="minesBet" class="value" placeholder="Your amount..." />
                </div>
            </div>
            <div class="play">
                <button class="btn-play">Deposit</button>
            </div>
        </div>
        <div class="balance-latest">
            <div class="balance" data-balance="@if (Auth::check()){{Auth::user()->wallet}}@else{{0}}@endif">Balance: <span class="value">@if (Auth::check()){{Auth::user()->wallet}}@else{{0}}@endif</span> <a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div>
            <div class="lol123" style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;">
			<div style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;">Worth: <div class="jptotal" style="text-align: center; color: #ffcc01;font-weight: bold; font-size: 30px;line-height: 30px;"></div></div>
			</div>
		</div>

        <div class="roulette-wheel-outer" style="border-bottom: 2px solid #161616 !important;"><div class="flip-container" style="width: 300px;height: 300px;position: relative; display: table;margin: 0 auto;stroke: #ffcc01 !important;font-weight: bold !important; font-size: 55px;"><div class="flip" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%);font-weight: bold !important; font-size: 55px;stroke: #ffcc01 !important;"></div></div></div>
	
		<div class="top-box box-history bottomFade" style="background: #2c2c2c;">
		<center>
                        <div class="title" style="font-size: 20px;color: #fefefe;padding: 3px 10px;font-weight: 700;justify-content: center;">History</div>
        </center>
						<div class="history">

                        </div>
						
                    </div>
	
			<div class="box-bets">
                <table>
                    <tr style="border-bottom: 2px solid #ffcc01;"> <td>Players</td> </tr>
                </table>
				
			<div class="player-bets"></div>
				
            </div>

	</div>
        </main>
    </div>
</div>

<div class="chat">
    <div class="circleButton chat-toggle-button"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
    <div class="chat-toggle-button-green"></div>
    <div class="chat-header">
        <img src="/img/misc/chat-header-img.png">
        <div class="text">
            TURBO CHAT
        </div>
        <img src="/img/misc/chat-info.png" class="chat-info">
    </div>
    <div class="chat-messages">
    </div> 
    @if (Auth::check())
    <div class="send-area">
                    <div class="input-area">
                <input type="text" class="chat-input" placeholder="Your message..." maxlength="75" pattern="[A-Za-z0-9_./!?,$+-= ]{1,75}" required>
                <div class="emots-button">
                    <img src="/img/misc/emots-button.png">
                </div>
                <div class="emots"></div>
            </div>
            <img src="/img/misc/chat-send-img.png" class="send-message">
            </div>
    @else
    <div class="send-area">
                    <a href="/auth/login" class="need-sign-in">
                <img src="/img/misc/sign-in-for-chat.png">
            </a>
            </div>
    @endif
</div>

<div class="popup">
    <div class="popup-inner">
        <div class="popup-title">
            TURBO RULES
            <div class="popup-close">x</div>
        </div>
        <div class="content">
            <p>1 - Things that will get you banned / muted:</p>
            <ul>
                <li>Spamming</li>
                <li>Begging</li>
                <li>Posting advertisement codes</li>
                <li>Advertising other websites</li>
                <li>Using a different language than english</li>
                <li>Overusing capslock</li>
                <li>Posting links to external sites</li>
            </ul>
            <p>2 - Please forward all problems to: <b style="color: #ffcc01;text-decoration: none !important;text-transform: none !important;">support@csgoturbo.com</b></p>
			<p>3 - Please forward all Business Inquiries to: <b style="color: #ffcc01;text-decoration: none !important;text-transform: none !important;">business@csgoturbo.com</b></p>
            <p>4 - This site is 18+ By playing you agree that you meet the legal age requirement.</p>
            <p>5 - Keep swearing to a minimum, don’t flame other users.</p>
			<p>6 - CSGOTurbo is not responsible for trade/account bans that may occur as a resulting of accepting items from our bots.</p>
			<p>7 - CSGOTurbo assumes no responsibility for missed bets as a result of network latency or disconnections. Always ensure a stable connection before placing bets. Avoid placing important bets at the last second.</p>

            <p><button class="popup-close">I UNDERSTAND</button></p>
        </div>
    </div>
</div>

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

    <script src="/js/progress.min.js"></script>
    <script src="/js/jackpot.js"></script>
    <script src="/js/HackTimerWorker.min.js"></script>
    <script src="/js/HackTimer.silent.min.js"></script>
@if((Auth::check()) && ((Auth::user()->rank == 'user') || (Auth::user()->rank == 'gold') || (Auth::user()->rank == 'diamond') || (Auth::user()->rank == 'streamer')))<script src="/js/chat.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat57NRz4.js"></script>
@else<script src="/js/chat.js"></script>
@endif
<script src="/js/app.js"></script>
</body>
</html>