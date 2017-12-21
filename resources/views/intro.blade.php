<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Games :: CSGON1.COM</title>
        <meta property="og:title" content="CSGON1.COM" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta name="description" content="Play with Your Friends and Win Skins!">
		<meta name="keywords" content="counter,strike,csgo,csgotuz1k,tuz1k,csgo tuz1k,CSGON1.COM,tuz1kcsgo,roulette,skins,referral,earn,points,bet,win,shop,buy,sell,gun,knife,knives,best,most,platform,marketplace,high,roller,stake,social,gambling,gamble,affiliate">


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

		<link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<script src="/js/jquery-1.8.3.js"></script>
			
<style>
.lobby .container .buttons .btn-1e {
	overflow: hidden;
	width: 200px;
	text-align: center;
	font-family: Titillium,sans-serif !important;
}

.lobby .container .buttons .btn:nth-of-type(1) {
    color: #fefefe;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn:nth-of-type(2) {
    color: #fefefe;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn:nth-of-type(3) {
    color: #fefefe;
    border: 2px solid #fb5616;
}
.lobby .container .buttons .btn:nth-of-type(4) {
    color: #fefefe;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn:nth-of-type(1):hover {
    color: #161616;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn:nth-of-type(2):hover {
    color: #161616;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn:nth-of-type(3):hover {
    color: #161616;
    border: 2px solid #fb5616;
	animation: pulse 3.5s cubic-bezier(0.4, 0, 1, 1) infinite;
}
.lobby .container .buttons .btn:nth-of-type(4):hover {
    color: #161616;
    border: 2px solid #fb5616;
}

.lobby .container .buttons .btn-1e:after {
    width: 100%;
    height: 0;
    top: 50%;
    left: 50%;
	color: #161616;
	font-family: Titillium,sans-serif;
    background: #fb5616;
    opacity: 0;
    transform: translateX(-50%) translateY(-50%) rotate(60deg);
}
.lobby {
    margin: 0;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: center;
    justify-content: center;
    -ms-flex-align: center;
    align-items: center;
    height: 100vh;
    background-color: #15181F!important;
    background-size: cover;
    font-family: Titillium,sans-serif;
}
</style>
</head>
	
<script>
@if (Auth::check())
	$(function() {
		$(".preloader").fadeOut(500, function() {
			$(".page-content").fadeIn(250);
		});
	});
@else
	$(function() {
		$(".preloader").fadeOut(2000, function() {
			$(".page-content").fadeIn(1000);
		});
	});
@endif
</script>
		
    </head>
<body class="lobby">
<div class="preloader">
    <img src="/img/misc/gifs/loader.gif">
</div>

<div class="main-wrapper">
        <main>
	<div class="roulette">
<div class="container">
	<center style="font-weight: 700; font-size: 50px;margin-bottom: 15px;">CHOOSE A GAMEMODE</center>
	<div class="buttons">
		<button class="btn btn-3 btn-1e" onclick="window.location.href='/roulette'" href="/roulette">Roulette</button>
		<button class="btn btn-5 btn-1e" onclick="window.location.href='/coinflip'" href="/coinflip">Coin Flip</button>
		<button class="btn btn-1 btn-1e" onclick="window.location.href='/jackpot'" href="/jackpot">Jackpot</button>
		<button class="btn btn-4 btn-1e" onclick="window.location.href='/crash'" href="/crash">Crash</button>
    </div>
	
</div>
	</div>
        </main>
    </div>
	
<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

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