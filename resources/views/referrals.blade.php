<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Referrals :: csgon1.com</title>
        <meta property="og:title" content="csgon1.com" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta name="description" content="Play with Your Friends and Win Skins!">
		<meta name="keywords" content="csgojackpot, csgo, wild, coin flip, item, jackpot, raffle, roulette">


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
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="/js/jquery-1.8.3.js"></script>
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
<body>
<div class="preloader">
    <img src="/img/misc/gifs/loader.gif">
</div>
  
<div class="page-content">
<nav class="navbar">
<div id="sidebar-wrapper" style="background: #1A1D26;border-left: 0px solid transparent!important;">
<ul id="sidebar-nav sidebarshow" class="sidebar-nav sidebarshow">
<div class="toggle menu-toggle-button">
      <i class="fa fa-angle-right" style="color: #15181F;font-weight: 700;"></i>
</div>
@if (Auth::check())
<li class="account">
<div class="avatar">
<img src="{{Auth::user()->avatar}}">
<span class="welcome1"> Welcome </span>
</div>

</li>
@else
<li class="test123">
<a href="/auth/login">
<div class="icon">
<i class="fa fa-steam" aria-hidden="true"></i>
</div>
<span class="sidespan sidespanvisible">LOG IN</span>
</a>
</li>
@endif
<li>
<a href="/">
<div class="icon">
<img src="/img/side-bar/roul.png">
</div>
<span class="sidespan sidespanvisible">ROULETTE</span>
</a>
</li>
<li>
<a href="/coinflip">
<div class="icon">
<img src="/img/side-bar/flip.png">
</div>
<span class="sidespan sidespanvisible">COINFLIP</span>
</a>
</li>
<li>
<a href="/jackpot">
<div class="icon">
<img src="/img/side-bar/jackpot.png">
</div>
<span class="sidespan sidespanvisible">JACKPOT</span>
</a>
<li style="border-bottom: 4px solid #15181F;">
<a href="/crash">
<div class="icon">
<img src="/img/side-bar/crash.png">
</div>
<span class="sidespan sidespanvisible">CRASH</span>
</a>
</li>
@if (Auth::check())
<li>
<a href="/user/profile">
<div class="icon">
<img src="/img/side-bar/account.png">
</div>
<span class="sidespan sidespanvisible">PROFILE</span>
</a>
</li>
<li style="border-bottom: 4px solid #15181F;">
<a href="/user/referrals">
<div class="icon">
<img src="/img/side-bar/stats.png" style="opacity: 1 !important;">
</div>
<span class="sidespan sidespanvisible">REFERRALS</span>
</a>
</li>
<li>
<a href="/user/deposit">
<div class="icon">
<img src="/img/side-bar/funds.png">
</div>
<span class="sidespan sidespanvisible">DEPOSIT</span>
</a>
</li>
<li style="border-bottom: 4px solid #15181F;">
<a href="/user/withdraw">
<div class="icon">
<img src="/img/side-bar/shop.png">
</div>
<span class="sidespan sidespanvisible">STORE</span>
</a>
</li>
@endif
<li>
<a href="/faq">
<div class="icon">
<img src="/img/side-bar/support.png">
</div>
<span class="sidespan sidespanvisible">FAQ</span>
</a>
</li>
@if (Auth::check())
<li style="border-bottom: 4px solid #15181F;">
<a href="/auth/logout">
<div class="icon">
<i class="fa fa-power-off"></i>
</div>
<span class="sidespan sidespanvisible">LOG OUT</span>
</a>
</li>
@endif
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
<li>
<a>
<div class="icon">
<i class="fa fa-power-ofx"></i>
</div>
</a>
</li>
</ul>
</div>

<div class="footer1" style="width: 75px;">
      <div class="data">

        <div class="online sidebarshow1"><div class="copyright"><img src="/img/icons-small/players.png"> <span class="players-online">0</span></div>
</div>
      </div>


    </div>
</nav>

<div class="center">

<div class="top-navigation">
        <div class="circleButton sound-toggle-button"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
		@if (Auth::check())
        <div class="circleButton1 balance" data-balance="{{Auth::user()->wallet}}"><a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;</a> <span class="value">{{Auth::user()->wallet}}</span></div>
		@endif
</div>

    <div class="main-wrapper">
        <main>
                <div class="affiliates">
			<div class="t-alert">You can generate your own unique code by pressing<font color="#fb5616"><b>&nbsp;"GET"</b></font> !</div>

        <div class="top">
            <div class="top-box">
                <div class="box">
                    <label for="get-coins">Use a code to get free 100 coins</label>
                    <div class="group-input">
                                                    @if (empty(Auth::user()->inviter))
                                                    <input type="text" id="get-coins" placeholder="Enter Your Code..."><button id="get-coins-button">USE</button>
                                                    @else
                                                     <button class="full-size">ALREADY USED</button> @endif 
                                            </div>
                </div>
                <div class="box">
                    <label for="set-code">Get your unique 7 character code by pressing <font color="#fb5616"><b>"GET"</b></font> button</label>
                    <div class="group-input">
                        <input type="text" id="set-code" placeholder="Random Generated code..." value="{{Auth::user()->code}}" disabled> <button id="set-code-button">GET</button>
                    </div>
                </div>

                <div class="box">
                    <label>Put <a class="lime" href="http://steamcommunity.com/my/edit">csgon1.com</a> in your name for 30 coins (Available every 24 hours)</label>
                    <div class="group-input">
@if(Auth::user()->last_free_use + 86400 < time())<button data-api="free-coins" class="free-coins full-size lime">CHECK NAME</button>
@else                                            <button data-api="free-coins" class="free-coins full-size reload-time" data-timeleft="{{(Auth::user()->last_free_use + 86400) - time()}}">YOU HAVE TO WAIT</button>
@endif
                                            </div>
                </div>
                <div class="box">
                    <label>Join our <a href="http://steamcommunity.com/groups/cs_gon1" target="_blank" style="color: #fb5616;">Steam Group</a> for 30 coins</label>
                    <div class="group-input">
@if (Auth::user()->group_used == '0')                                                    <button data-api="group-join" class="free-coins group-join full-size lime">JOIN STEAM GROUP</button>
@else                                                    <button class="full-size">ALREADY USED</button>
@endif
                                            </div>
                </div>
            </div>
            <div class="top-box">
                <div class="box2">
                    <div class="label">People you have referred:</div>
                    <div class="value">{{$reffered}}</div>
                </div>
                <div class="box2">
                    <div class="label">Affiliates Coins:</div>
                    <div class="value">@if($profit < 0) <span style="font-size: 20;">Press <font color="#fb5616"><b>&nbsp;"GET"&nbsp;</b></font> to see your profit!</span> @else {{$profit}} @endif </div>
                </div>
                <button id="withdraw-refs-button">Collect Affiliates Coins</button>
            </div>
        </div> 
        <div class="levels">
            <div class="label"></div>
            <div class="medals">
                <div class="medal medal-bronze"> 
                    <div class="medal-label">BRONZE</div>
                    <div class="medal-background"></div>
                    <div class="medal-image"></div>
                    <div class="medal-line"></div>
                    <div class="medal-progress">0 - 50</div>
                    <div class="medal-tip" data-tip="Get 50 coins for every person that you referred." data-ltip="Bronze"></div>
                </div>
                <div class="medal medal-silver">
                    <div class="medal-label">SILVER</div>
                    <div class="medal-background"></div>
                    <div class="medal-image"></div>
                    <div class="medal-line"></div>
                    <div class="medal-progress">51 - 250</div>
                    <div class="medal-tip" data-tip="Get 60 coins for every person you referred." data-ltip="Silver"></div>
                </div>
                <div class="medal medal-gold">
                    <div class="medal-label">GOLD</div>
                    <div class="medal-background"></div>
                    <div class="medal-image"></div>
                    <div class="medal-line"></div>
                    <div class="medal-progress">251 - 1500</div>
                    <div class="medal-tip" data-tip="Get 70 coins for every person you referred." data-ltip="Gold"></div>
                </div>
                <div class="medal medal-diamond">
                    <div class="medal-label">DIAMOND</div>
                    <div class="medal-background"></div>
                    <div class="medal-image"></div>
                    <div class="medal-line"></div>
                    <div class="medal-progress">1500+</div>
                    <div class="medal-tip" data-tip="Get 100 coins for every person you referred." data-ltip="Diamond"></div>
                </div>
            </div>
        </div>
    </div>
        </main>
    </div>
</div>

<div class="chat">
	<div class="toggle chat-toggle-button">
      <i class="fa fa-angle-left" style="color: #15181F;"></i>
    </div>
    <div class="chat-header chatheader0">
        <div class="text">
            CHAT
        </div>
    </div>
    <div class="chat-header chatheader1 chatheaderhide">
        <div class="text">
            CHAT
        </div>
    </div>
    <div class="chat-messages">
    </div> 
    @if (Auth::check())
    <div class="send-area">
                    <div class="input-area">
                <input type="text" class="chat-input" placeholder="Your message..." maxlength="75" pattern="[A-Za-z0-9_./!?,$+-= ]{1,75}" requit>
                <div class="emots-button">
                    <img src="/img/misc/emots-button.png">
                </div>
                <div class="emots"></div>
            </div>
            <img src="/img/chat-send-img.png" class="send-message">
            </div>
    @else
    <div class="send-area">
                    <a href="/auth/login" class="need-sign-in">
                <img src="/img/misc/sign-in-for-chat.png">
            </a>
            </div>
    @endif
	<div class="footer" style="width: 303px;">
      <div class="data">
        <div class="social">
          <a href="https://twitter.com/CSGO_N1" target="_blank"><i class="fa fa-twitter"></i></a>
          <a href="http://steamcommunity.com/id/tuz1k" target="_blank"><i class="fa fa-steam"></i></a>
        </div>

        <div class="copyright copyright0">&copy; csgon1.com 2017</div>
        <div class="copyright copyright1 copyrighthide">&copy;</div>
        <div class="legal">
          <a href="/terms" target="_blank">Live Support</a>
           <a class="chat-info" style="cursor: pointer;">Rules</a>
        </div>

      </div>

    </div>
</div>
<div class="popup">
    <div class="popup-inner">
        <div class="popup-title">
            RULES
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
            <p>2 - Please forward all problems to: <b style="color: #fb5616;text-decoration: none !important;text-transform: none !important;">support@csgon1.com</b></p>
			<p>3 - Please forward all Business Inquiries to: <b style="color: #fb5616;text-decoration: none !important;text-transform: none !important;">business@csgon1.com</b></p>
            <p>4 - This site is 18+ By playing you agree that you meet the legal age requirement.</p>
            <p>5 - Keep swearing to a minimum, don’t flame other users.</p>
			<p>6 - csgon1.com is not responsible for trade/account bans that may occur as a resulting of accepting items from our bots.</p>
			<p>7 - csgon1.com assumes no responsibility for missed bets as a result of network latency or disconnections. Always ensure a stable connection before placing bets. Avoid placing important bets at the last second.</p>

            <p><button class="popup-close">I UNDERSTAND</button></p>
        </div>
    </div>
</div>
</div>

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

    <script type="text/javascript" src="/js/affiliates.js"></script>
@if((Auth::check()) && ((Auth::user()->rank == 'user') || (Auth::user()->rank == 'gold') || (Auth::user()->rank == 'diamond') || (Auth::user()->rank == 'streamer')))<script src="/js/chat.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat57NRz4.js"></script>
@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat57NRz4.js"></script>
@else<script src="/js/chat.js"></script>
@endif
    <script src="/js/app.js"></script>
</body>
</html>
