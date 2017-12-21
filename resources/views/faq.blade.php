<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>FAQ :: CSGON1.COM</title>
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
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="/js/jquery-1.8.3.js"></script>

		
    </head>
<body>

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
<img src="/img/side-bar/stats.png">
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
<img src="/img/side-bar/support.png" style="opacity: 1 !important;">
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
                <div class="rules">
        <div class="header">
            Frequently Asked Questions
            <span>Last updated: July 1st, 2017</span>
        </div>
        <div>
            <p><strong>Who we are?</strong></p>
            <p>We are one of the most advanced gambling websites to ever exist, and with the low commission rates we will soon be the best website out there.</p>
			<p>Our staff aren't just people that work here, we're a family. Owned by some of the most respected and reputable traders in the community, you can be sure that you're safe with us.</p>
            <p>You can place bets with those coins on our Roulette, Coinflip, Jackpot and Crash game and withdraw them back to skins at any time you want!</p>
            <p>Remember that these coins have no real world value.</p>
        </div>
        <div>
            <p><strong>How can I get coins?</strong></p>
            <p>You can deposit Counter-Strike: Global Offensive skins.</p>
            <p>A skin worth $1 on the Steam Marketplace should give you around 1000 coins.</p>
            <p>Another option is our affiliate system.</p>
        </div>
        <div>
            <p><strong>What is the affiliate system?</strong></p>
            <p>Please visit our referral tab to set your own promo code. If you share it with other  people, after using the code both of you will recieve free coins!</p>
            <p>You can generate your own referral code by clicking "Get" in the Referrals Tab.</p>
        </div>
        <div>
            <p><strong>How do I deposit skins for coins?</strong></p>
            <p>To deposit, head over to your profile page. Make sure your trade link is properly set.</p>
            <p> Once you’ve done that, go to the Deposit page, select up to 20 items and then hit the deposit button.</p>
            <p>Coins from deposits appear on your account immediately although in rare circumstances it can take up to 30 minutes (if steam breaks the offer that is).</p>
        </div>
        <div>
            <p><strong>Why are some of my items missing from the deposit page?</strong></p>
            <p>You might need to refresh your inventory by clicking the “Refresh Inventory” button on the top right of the Deposit page.</p>
            <p>Remember that our minimum depositing value it’s $0.50 - Also some of the items with prices hard to determine are not accepted on the site. </p>
            </p> Please make sure you are using the Steam mobile authenticator for at least 7 days.</p>
        </div>
        <div>
            <p><strong>How do I withdraw my coins to skins?</strong></p>
            <p>Go to the Withdraw page, select up to 20 items and then hit the Withdraw button. </p>
            <p>If you happen to decline a trade offer, coins will be credited back to your account within 5 minutes.</p>
        </div>
        <div>
            <p><strong>Why can’t I withdraw?</strong></p>
            <p>To withdraw item worth up to $1 you don't need any deposits, you just have to bet atleast 12 times. If you want withdraw items worth more than that, you have to deposit $2.50.
			Also, your 'Wager Amount' needs to be more than or equal to the amount your trying to withdraw, read more about the wager amount in the FAQ under 'What is Wager Amount?'.</p>
        </div>
		<div>
            <p><strong>What is Wager Amount?</strong></p>
            <p>This is how much you have wagered or in other words bet on our various games. This amount mirrors to the amount you are allowed to withdraw from our store.
			This has been added in our new system to ensure that our store does not get mistaken for a trade bot to trade.</p>
        </div>
		<div>
            <p><strong>What is the site's commission?</strong></p>
            <p>Our website, like any other, has commission for the games. However, we have the lowest commission rate any website had ever had at only 5%! This is also only for 2 of our games, Jackpot and Coinflip. Roulette has no site commission.</p>
        </div>
        <div style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
            <p><strong>How to send coins?</strong></p>
            <p>It's really simple, just type in chat:<br>
            <i>/send [STEAMID64] [AMOUNT]</i></p>
            <p>You can also right click the users name/message on chat to make it faster!</p>
            <p>You must bet at least 10000 and deposit minimum 2500 to send coins between users.</p>
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
                <input type="text" class="chat-input" placeholder="Your message..." maxlength="75" pattern="[A-Za-z0-9_./!?,$+-= ]{1,75}" required>
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
          <a href="http://steamcommunity.com/groups/cs_gon1" target="_blank"><i class="fa fa-steam"></i></a>
        </div>

        <div class="copyright copyright0">&copy; CSGON1.COM 2017</div>
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