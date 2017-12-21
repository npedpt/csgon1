
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>CSGON1.COM - Giveaway</title>
        <meta property="og:title" content="CSGON1.COM" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta name="description" content="Play with Your Friends and Win Skins!">
		<meta name="keywords" content="counter,strike,csgo,csgovamin,vamin,csgo vamin,CSGON1.COM,vamincsgo,roulette,skins,referral,earn,points,bet,win,shop,buy,sell,gun,knife,knives,best,most,platform,marketplace,high,roller,stake,social,gambling,gamble,affiliate">


        <meta name="csrf-token" content="63rWLQI6W2YMswWrBZLCww00RRFrqaq8AjeJtALr" />
        <meta name="language" content="en" />
        <meta name="websocket" content="https://CSGON1.COM:8443" /> 
        <meta name="game" content="other" />
        <meta name="logged" content="@if (Auth::check()){{1}}@else{{0}}@endif" />
        <meta name="steamid" content="@if (Auth::check()){{Auth::user()->steamid}}@endif" />
        <meta name="username" content="@if (Auth::check()){{Auth::user()->username}}@endif"/>
        <meta name="avatar" content="@if (Auth::check()){{Auth::user()->avatar}}@endif"/>
        <meta name="token" content="{{$token}}"/>
        <meta name="tradeURL" content="@if (Auth::check() && Auth::user()->tradeurl){{'https://steamcommunity.com/tradeoffer/new/?partner='.(substr(Auth::user()->steamid,7) - 7960265728).'&token='.Auth::user()->tradeurl}}@endif"/>
        <meta name="time" content="{{$time}}"/>
        
        <meta name="viewport" content="width=1400, initial-scale=1">
		<meta name="google-site-verification" content="1X4JxaLG_AM6F9u410Q6K4XL9HuqJjntjN3k8dmJ53E" />

        <link rel="icon" type="image/png" href="/favicon.png" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/app1.css">
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
<div class="chat">
    <div class="chat-header">
		
        <nav>
		<center><img style="margin-left:-10px;margin-top:10px;width:200px" src="/img/logoturbo.png"></center>
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
			<img style="margin-right: -13;margin-bottom: -7;" src="/img/misc/chat-info.png" class="chat-info">
        </div>
        @else
        <div class="sign-in">
        <a href="/auth/login"><img src="/img/sign-in.png"></a>
    </div>
@endif
@if (Auth::check())
        <div class="balance" data-balance="{{Auth::user()->wallet}}"><div class="balance-icon"><img style="margin-left: -20;" src="/img/icons-small/coins.png"></div> <span class="value">{{Auth::user()->wallet}}</span> <a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div>
@endif
</nav>
    </div>
    <div class="chat-messages chatmessages1">
    </div>
    @if (Auth::check())
    <div class="send-area sendarea1">
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
<nav style="width: 80;border-left: 1px solid #242424;">
<ul class="navbar-pages">
        <li class="vamini">
            <a href="/roulette" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-roulette"></div>
                </div>
            </a>
        </li>
		<li class="vamini">
            <a href="/coinflip" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-dice"></div>
                </div>
            </a>
        </li>
		<li class="vamini">
            <a href="/jackpot" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-mines"></div>
                </div>
            </a>
        </li>
		<li class="vamini">
            <a href="/crash" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-up"></div>
                </div>
            </a>
        </li>
        <li class="vamini">
            <a href="/user/deposit" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-deposit"></div>
                </div>
            </a>
        </li>
        <li class="vamini">
            <a href="/user/withdraw" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-store"></div>
                </div>
            </a>
        </li>
        <li class="vamini">
            <a href="/user/referrals" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-referrals"></div>
                </div>
            </a>
        </li>
        <li class="vamini">
            <a href="/faq" class="navbar-href">
                <div class="icons">
                    <div class="icon-big icon-faq"></div>
                </div>
            </a>
        </li>
		<li class="vamini">
            <a href="/giveaway" class="navbar-href active">
                <div class="icons">
                    <div class="icon-big icon-giveaway"></div>
                </div>
                <div class="medal-tip" data-tip="Get 70 coins for every person referred." data-ltip="Gold"></div>				
            </a> 
        </li>
    </ul>
	            <button style="position:absolute;bottom: 120;" class="circleButton sound-toggle-button"><i class="fa fa-volume-up" aria-hidden="true"></i></button>
	            <button style="position:absolute;bottom: 60;" class="circleButton chat-toggle-button"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>

    <div class="online"><img src="/img/icons-small/players.png"><span class="players-online">0</span></div>
</nav>

<div class="center">

    <div class="main-wrapper">
        <main>
		<br>
		<br>
		<br>
                <div class="rules">
        <div class="header">
            Giveaway
            <span>Last updated: February 13th, 2017</span>
        </div>
        <div>
            <p><strong>AWP | Asiimov Giveaway!</strong></p>
<a class="e-widget no-button" href="https://gleam.io/jom0I/vaminshost-awp-asiimov-prelaunch-giveaway" rel="nofollow">vaminshost AWP | Asiimov Pre-launch Giveaway</a>
<script type="text/javascript" src="https://js.gleam.io/e.js" async="true"></script>
        </div>
    </div>
        </main>
    </div>
</div>

<div class="popup">
    <div class="popup-inner">
        <div class="popup-title">
            tuz1k'S RULES
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
            <p>2 - Please forward all problems to: <b style="color: #fb5616;text-decoration: none !important;text-transform: none !important;">support@CSGON1.COM</b></p>
			<p>3 - Please forward all Business Inquiries to: <b style="color: #fb5616;text-decoration: none !important;text-transform: none !important;">business@CSGON1.COM</b></p>
            <p>4 - This site is 18+ By playing you agree that you meet the legal age requirement.</p>
            <p>5 - Keep swearing to a minimum, don’t flame other users.</p>
			<p>6 - CSGON1.COM is not responsible for trade/account bans that may occur as a resulting of accepting items from our bots.</p>
			<p>7 - CSGON1.COM assumes no responsibility for missed bets as a result of network latency or disconnections. Always ensure a stable connection before placing bets. Avoid placing important bets at the last second.</p>

            <p><button class="popup-close">I UNDERSTAND</button></p>
        </div>
    </div>
</div>

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>
@if((Auth::check()) && ((Auth::user()->rank == 'user') || (Auth::user()->rank == 'gold') || (Auth::user()->rank == 'diamond') || (Auth::user()->rank == 'streamer')))<script src="/js/chat.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat57NRz4.js"></script>
@else<script src="/js/chat.js"></script>
@endif
    <script src="/js/app.js"></script>
</body>
</html>