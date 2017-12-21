
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Terms of Service :: csgon1.com</title>
        <meta property="og:title" content="csgon1.com" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta property="og:description" content="" />

        <meta name="csrf-token" content="63rWLQI6W2YMswWrBZLCww00RRFrqaq8AjeJtALr" />
        <meta name="language" content="en" />
        <meta name="websocket" content="http://138.68.104.53:8080" />
        <meta name="game" content="roulette" />
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
		<link rel="stylesheet" href="/css/wild/frontend.css">
		<link rel="stylesheet" href="/css/wild/app.css">
        <link rel="stylesheet" href="/css/app.css">

<style>
.menu-name {
    background: #111618;
    text-align: left;
    font-size: 14px;
    font-weight: 700;
    padding: 13px 0;
}

#sidebar-wrapper ul {
    margin: 0;
    padding: 0;
    width: 250px;
}

nav {
    width: 265px;
    background-color: #141c1f;
    overflow: hidden;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
}

#sidebar-wrapper ul li a.expandable span.expanded-element {
    margin-left: 20px;
    display: none;
    font-size: 13px;
    font-weight: 700;
    position: relative;
    padding-top: 5px;
    padding-right: 20px;
    float: right;
}

#sidebar-wrapper ul li {
    background-color: #141a1d;
    list-style-type: none;
    margin-top: 5px;
    margin-bottom: 5px;
}

#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    left: 0;
    width: 0;
    height: 100%;
    background: #141a1d;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#sidebar-wrapper ul li a.expandable {
    outline: 0;
    color: #fff;
    text-decoration: none;
    border-right: 4px solid transparent;
    font-size: 14px;
}

.top-line {
    position: fixed;
    width: 5000px;
    left: 0;
    top: 0;
    border-top: 5px solid #ffcc01;
    z-index: 963;
}

.chat {
    width: 300px;
    background: #141a1d;
    position: fixed;
    right: 0;
    height: 100%;
    z-index: 99999;
}

#chat {
    height: 100%;
}

.roulette {
    background: url(/assets/images/roulette.png) no-repeat;
    width: 100%;
    height: 100%;
    margin-bottom: 10px;
    text-align: center;
    overflow: hidden;
}

.footer-text {
    color: #2e3f46;
    font-size: 13px;
    margin: 17px auto;
    text-align: center;
}

.roulette .box-section.title {
    flex: 2;
    margin: 1em;
    color: #fff;
    display: flex;
    align-items: center;
}

.roulette .box-section {
    padding: 1em;
    display: flex;
    align-items: center;
}

.roulette .bets .bet-box .bet-info {
    background: #1a2327;
    display: -ms-flexbox;
    display: flex;
    height: 100px;
    border-top: 2px solid #1a2327;
}

.roulette .bets .bet-box {
    width: calc(100%/ 3 - 40px/3);
}

.roulette .bets .bet-box.green-bet .bet-info {
    border-bottom: 2px solid #1a2327;
}

.roulette .bets .bet-box.black-bet .bet-info {
    border-bottom: 2px solid #1a2327;
}

section#roulette-section div.entrants div.box div.header div.rubies div.count {
    background-color: #161D20;
    padding: 1em;
    margin-right: .5em;
    border-radius: 5px;
}

.roulette .btn-multi.active img {
    box-shadow: 0 0 3px 3px #ffcc01;
}


.roulette .btn-multi img {
    width: 75px;
    height: 75px;
    border-radius: 75px;
    max-width: 100%;
    height: auto;
}

.roulette .btn-multi {
    margin: 0;
    cursor: pointer;
    outline: 0;
    border: 0;
    background: transparent;
}

*, :after, :before {
    box-sizing: inherit;
}

.roulette {
    background: url() no-repeat !important;
    width: 100%;
    height: 100%;
    margin-bottom: 10px;
    text-align: center;
    overflow: hidden;
	margin-top: 50px;
}

.roulette .balance-latest {
    display: -ms-flexbox;
    display: flex;
    padding: 12px;
    background: #1a2327;
    height: 70px;
    font-weight: 700;
    font-size: 18px;
    border-top: 2px solid #1a2327;
    border-bottom: 2px solid #1a2327;
	margin: 1em 0 0;
}

.roulette .roulette-wheel-outer {
    position: relative;
    background: #1a2327;
    border-bottom: 2px solid #1a2327;
    padding: 10px;
    margin: 1em 0 0;
}

.roulette .btn-multi.active img {
    box-shadow: 0 0 20px #ffcc01,0 0 0 2px #ffcc01!important;
}

.roulette .roulette-wheel-outer .rolling {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    background: rgba(26, 35, 39, 0.89);
}

.chat .send-area {
    display: -ms-flexbox;
    display: flex;
    height: 57px;
    border-top: 2px solid #111618;
    background: #111618;
}

.chat .send-area .input-area .emots-button {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 44px;
    background: #141c1f;
    border-bottom-right-radius: 15px;
    border-top-right-radius: 15px;
    cursor: pointer;
}

.chat .send-area .input-area .chat-input {
    width: calc(100% - 44px);
    background: #182023;
    border: 0;
    outline: 0;
    border-bottom-left-radius: 15px;
    border-top-left-radius: 15px;
    padding-left: 10px;
    box-sizing: border-box;
    color: #fefefe;
    font-family: Titillium,sans-serif;
    font-size: 14px;
}

#chat {
    height: 101.4%;
}

.chat .send-area .input-area .emots-button {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 44px;
    background: #141c1f;
    border-bottom-right-radius: 15px;
    border-top-right-radius: 15px;
    cursor: pointer;
}

.chat .send-area .input-area .emots {
    background: #161d20;
}

.col-lg-6 {
    width: 100%;
}

p {
    text-align: left;
    padding-top: 20px;
    font-family: Titillium,sans-serif;
    font-weight: 700;
}

.chat .chat-messages .chat-message:nth-child(2n+1) {
    background: transparent;
}

body {
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 60px;
    background: #151d20!important;
    color: #FFF;
    -webkit-font-smoothing: antialiased!important;
    text-shadow: rgba(0,0,0,.01) 0 0 1px!important;
    text-rendering: optimizeLegibility!important;
}

.glyphicon {
    float: left;
    width: 60px;
    height: 30px;
    top: 0;
    bottom: 0;
    background-color: #141c1f;
}

.opskins-badge {
    display: inline-block;
    padding: 7px 0;
    background-color: #12181a;
    width: 100%;
}

#footer {
    position: fixed;
    width: 200px;
    bottom: 0;
    background-color: #111618;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.chat .chat-messages .chat-message {
    display: -ms-flexbox;
    display: flex;
    border-bottom: 2px solid transparent;
    background: #13191c;
    padding: 7px;
}

.chat .chat-messages .chat-message:nth-child(2n+1) {
    background: #141a1d;
}

.chat .send-area .input-area .chat-input {
    width: calc(100% - 44px);
    background: #192225;
    border: 0;
    outline: 0;
    border-bottom-left-radius: 5px !important;
    border-top-left-radius: 5px !important;
    padding-left: 10px;
    box-sizing: border-box;
    color: #fefefe;
    font-family: Titillium,sans-serif;
    font-size: 14px;
}

.chat .send-area .input-area .emots {
    background: #192225 !important;
}

.chat .send-area .input-area .emots-button {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 44px;
    background: #192225;
    border-bottom-right-radius: 5px !important;
    border-top-right-radius: 5px !important;
    cursor: pointer;
}

.chat .send-area .input-area .emots {
    display: none;
    position: absolute;
    bottom: 83px;
    left: 20px;
    width: 310px;
    border: 2px solid #192225!important;
    background: #1d232a;
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
<nav style="width: 250px;">
<div id="sidebar-wrapper" style="width: 250px;">
    <div style="width: 60px;background: #141c1f;height: 100%;"></div>
	@if (Auth::check())
	<ul class="sidebar-nav" style="width: 250px;">
     <div class="menu-name" style="display: block;">
        <b style="margin-left: 25px;">MENU</b>
        </div>
		<li>
        <a class="expandable" title="" href="/coinflip">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/coin-flip.png">
          </span>
          <span class="expanded-element" style="display: inline;">Coin Flip</span>
        </a>
      </li> 
        <li>
            <a class="expandable" title="" href="/wild">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/roulette.png">
          </span>
                <span class="expanded-element" style="display: inline;">Roulette</span></a> 
        </li>
     <li>
        <a class="expandable" title="" href="/crash">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/crash.png">
          </span>
          <span class="expanded-element" style="display: inline;">Crash</span></a>  
      </li> 
       
           

      <div class="menu-name" style="display:block"><b style="margin-left: 25px;">ACCOUNT</b><span class="account-funds"><i class="fa fa-diamond white"></i> <span data-balance="{{Auth::user()->wallet}}" class="spincrement" id="balance">{{Auth::user()->wallet}}</span></span>
  </div>
  <li>
    <a class="expandable" title="" href="/user/profile">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/my-profile.png">
      </span>
      <span class="expanded-element" style="display: inline;">Profile</span>
    </a>
  </li>
  <li>
    <a class="expandable" title="" href="/user/referrals">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/my-winnings.png">
      </span>
      <span class="expanded-element" style="display: inline;">Referrals</span>
    </a>
  </li>
  <li>
    <a class="expandable" title="" href="/user/deposit">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/deposit-skins.png">
      </span>
      <span class="expanded-element" style="display: inline;">Deposit</span>
    </a>
  </li>
  <li>
    <a class="expandable" title="" href="/user/withdraw">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/buy-skins.png">
      </span>
      <span class="expanded-element" style="display: inline;">Store</span>
    </a>
  </li>
            
  <li>
    <a class="expandable" title="" href="/auth/logout">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/logout.png">
      </span>
      <span class="expanded-element" style="display: inline;">Sign Out</span>
    </a>
  </li>
      <div class="menu-name" style="display: block;"><b style="margin-left: 25px;">EXTRAS</b></div>
      <li>
        <a class="expandable" title="" href="/faq" style="border-right: 3px solid #ffcc01;">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/about-selected.png">
          </span>
          <span class="expanded-element" style="display: inline;">FAQ & How to Play</span>
        </a>
      </li>
	  <li>
            <a class="expandable" title="" href="/provably-fair">
        <span class="glyphicon collapsed-element">
        <img class="sidebar-icon" src="/assets/images/menu/provably-fair.png">
        </span>
                <span class="expanded-element" style="display: inline;">Provably Fair</a></span>
        </li>
      <li>
        <a class="expandable" title="" href="/terms">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/terms-of-service.png">
          </span>
          <span class="expanded-element" style="display: inline;">Terms of Service</span>
        </a>
      </li>
	  
    </ul>
	
	@else
	
    <ul class="sidebar-nav" style="width: 250px;">
      <div class="menu-name" style="display: block;">
        <b style="margin-left: 25px;">MENU</b>
        </div>
		<li>
        <a class="expandable" title="" href="/coinflip">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/coin-flip.png">
          </span>
          <span class="expanded-element" style="display: inline;">Coin Flip</span>
        </a>
      </li> 
        <li>
            <a class="expandable" title="" href="/wild">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/roulette.png">
          </span>
                <span class="expanded-element" style="display: inline;">Roulette</span></a> 
        </li>
     <li>
        <a class="expandable" title="" href="/crash">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/crash.png">
          </span>
          <span class="expanded-element" style="display: inline;">Crash</span></a>  
      </li> 
       
           

      <div class="menu-name" style="display: block;"><b style="margin-left: 25px;">WELCOME TO CSGOTURBO.COM</b></div>

  </li><li style="height:80px;">
    <a class="expandable steam-auth-url" title="" href="/auth/login">
      <span class="glyphicon collapsed-element" id="login" style="display: none;">
        <img class="sidebar-icon" src="/assets/images/menu/logout.png">
      </span>
      <img class="steam-auth" src="/assets/images/steam_signin_large_bd.png">
    </a>
  </li>
      <div class="menu-name" style="display: block;"><b style="margin-left: 25px;">EXTRAS</b></div>
      <li>
        <a class="expandable" title="" href="/faq" style="border-right: 3px solid #ffcc01;">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/about-selected.png">
          </span>
          <span class="expanded-element" style="display: inline;">FAQ & How to Play</span>
        </a>
      </li>
	  <li>
            <a class="expandable" title="" href="/provably-fair">
        <span class="glyphicon collapsed-element">
        <img class="sidebar-icon" src="/assets/images/menu/provably-fair.png">
        </span>
                <span class="expanded-element" style="display: inline;">Provably Fair</a></span>
        </li>
      <li>
        <a class="expandable" title="" href="/terms">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/terms-of-service.png">
          </span>
          <span class="expanded-element" style="display: inline;">Terms of Service</span>
        </a>
      </li>
	  
    </ul>

  @endif
  
  <div id="footer" style="width: 250px; display: block;">
            <div class="opskins-badge" style="text-align: center;">
				<a id="vk" href="https://www.facebook.com/csgoturbo" target="_blank"> <i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a> 
				<a id="vk" href="https://twitter.com/realcsgoturbo" target="_blank"> <i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a> 
				<a id="vk" href="https://steamcommunity.com/groups/cs_gon1" target="_blank"> <i class="fa fa-steam fa-lg" aria-hidden="true"></i></a>
            </div>

        <div class="footer-text">
@ CSGOTURBO, 2017. All rights reserved.

</div>

</div>

</div>
</nav>

  <div class="center">
    <div class="top-navigation">
    </div>
	
    <div class="main-wrapper">
        <main>
		<div style="height: 10px;" class="top-line row 100% page"></div>
                <div class="roulette">
				<section id="roulette-section">
    <div class="content">
  
<div style="border-bottom: 4px solid #ffcc01;
    margin-left: 20px;;
    margin-bottom: 20px;
    height: 35px;
    display: table;
    font-family: 'Open Sans', sans-serif;">
        <h1 style="font-size: 30px;">FAQ</h1>
    </div>
        <div class="
    col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <section id="settings-area-section">
                <div class="settings box squished-box" style="padding:25px;">
                    <div class="box-padded-header">
                        <div class="semi-bold box-header" style="margin: 0 auto;">
                            <span class="very-bold">Frequently Asked Questions</span>
                        </div>
                    </div>
                    <p>
                        Welcome to CSGORash! On this page you can find answers to common questions about our site. If youre looking for personal help, please visit our support page.
                        <br>
                    </p>
                    <br>
                    <h4>Wait, what is this thing again?</h4>
                    <p class="tos-p">This is a skin site called CSGORash. We make it easy for people to win Counter-Strike: Global Offensive skins by playing 1v1 coinflip matches, playing classic games or playing in double. 
                    </p>
                    <br>
                    <h4>How does it work?</h4>
                    <p class="tos-p">Sign in through Steam and deposit a skin. Pick a game, and choose which side of the coin you think will win; Terrorist or Counter Terrorist. If the coin lands on the side you chose, you win double! 
                    </p>
                    <br>
                    <h4>Are there any fees?</h4>
                    <p class="tos-p">
                        Fees matter from the game type on our site. As for our roulette there are completely no fees. Only a 10% fee exists for the CoinFlip and Clasic game, this fee is taken from every flip/game. 
                    </p>
                    <br>
                    <h4>So, how much can I win?</h4>
                    <p class="tos-p">
                        You can play for 1.00 or go big for 10,000. We see games in the 1,000+ range happening every day. 
                    </p>
                    <br>
                    
                    <h4>Is there a secret to improve my chance of winning?</h4>
                    <p class="tos-p">
                        
                    </p>
                    <br>
                   
                    <h4>Who are you guys?</h4>
                    <p class="tos-p">
                        Were a group of experienced internet personalities and technology developers. Our staff is hand-picked and trained to help you as quickly and kindly as possible. Please contact us anytime for questions, suggestions or just to say hi. 
                    </p>
                    <br>
                    <h4>Why are you better than other similar services?</h4>
                    <p class="tos-p">
                        Were the fastest in the business.
No more waiting for games to start or trades to be sent. Deposit, withdraw and win skins. Instantly. 
                    </p>
                    <br>
                    <h4>I dont receive any tradeoffer</h4>
                    <p class="tos-p">
                        Make sure:
                         <ul>
                        <li>Your inventory is <a href="#" onClick="MyWindow=window.open('https://steamcommunity.com/id/me/edit/settings/','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=500,top=-200'); return false;">public</a>.</li>
                        <li>Your added correct tradelink in your <a href="#" onClick="MyWindow=window.open('http://CSGORash.com/profile','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=500,top=-200'); return false;">profile</a>.</li>

                    </ul>
                    </p>









                </div>
            </section>
        </div>

        <div class="
    col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <section id="game-area-section" style="color: #5e7c89 !important;">
                <div class="settings box squished-box" style="padding:25px;">

                    <div class="box-padded-header" style="margin-bottom: 10px;">
                        <div class="semi-bold box-header" style="margin: 0 auto;">
                            <span class="very-bold">Coin Flip</span>
                        </div>
                    </div>
                    <p style="text-align: left">
                        To spectate, click on the box of the specified game. To join or create a game, please follow these steps: 
                        <br>
                        <br>
                    <ul>
                        <li>Choose terrorist or counter terrorist as the side of the coin to bet on.</li>
                        <li>Select how much you want to bet.</li>
                        <li>Click create game.</li>
                        <li>Wait for someone to join and claim your winnings!</li>
                    </ul>
                    <span class="semi-bold">Coin Explanation</span>
                    <br>
                    <br>
                    <img class="coin" src="/assets/images/terrorist.png">
              <span style="vertical-align: middle">
                Terrorist will put your bet on the first 50% of the pot (0%-49%).
              </span>
                    <br>
                    <img class="coin" src="/assets/images/counter-terrorist.png">
              <span style="vertical-align: middle">
                Counter Terrorist will put your bet on the last 50% of the pot (50%-100%).
              </span>
                    <br>
                    <br>
              <span class="semi-bold">
                Minimum Bet = <i class="fa fa-diamond"></i> 0.10
              </span>
                    </p>
                </div>

                <div class="settings box squished-box" style="padding:25px;">
                    <div class="box-padded-header" style="margin-bottom: 10px;">
                        <div class="semi-bold box-header" style="margin: 0 auto;">
                            <span class="very-bold">Double</span>
                        </div>
                    </div>
                    <p style="text-align: left">
                        Roulette is one of the easiest games to play and understand. Pick a color, make a bet and watch the wheel to land on your chosen side to win.
                        <br>
                        <br>
                    <ul>
                        <li>Choose an amount to deposit.</li>
                        <li>Pick a color: Red, Black or Green.</li>
                        <li>Win when the wheel lands on your color.</li>
                    </ul>
                    <span class="semi-bold">Payout Explanation</span>
                    <br>
                    <br>
                   
              <span style="vertical-align: middle">
                Red will pay out 2x your original bet.
              </span>
                    <br>
                    
              <span style="vertical-align: middle">
                Black will pay out 2x your original bet.
              </span>
                    <br>
                   
              <span style="vertical-align: middle">
                Green will pay out 14x your original bet.
              </span>
                    <br>
                    <br>
              <span class="semi-bold">
                Minimum Bet = <i class="fa fa-diamond"></i> 0.10
              </span>
                    </p>
                </div>
                 <div class="settings box squished-box" style="padding:25px;">
                    <div class="box-padded-header" style="margin-bottom: 10px;">
                        <div class="semi-bold box-header" style="margin: 0 auto;">
                            <span class="very-bold">Classic game</span>
                        </div>
                    </div>
                    <p style="text-align: left">
                        Classic game is one of the first games of csgo gamble, its a very simple game and you can get a lot of money.<br>
                        <br>
                    <ul>
                        <li>The more emeralds you deposit, higer you chance is.</li>
                        <li>You will always have a chance to win, but if you bet low it will be minimum</li>
                        <li>You win when it stops at your profile picture.</li>
                    </ul>
                    <span class="semi-bold">Payout Explanation</span>
                    <br>
                    <br>
                   
              <span style="vertical-align: middle">
                If you win you will get all the emeralds in the pot
              </span>
                    <br>
                    <br>
              <span class="semi-bold">
                Minimum Bet = <i class="fa fa-diamond"></i> 0.10
              </span>
                    </p>
                </div>
            </section>
        </div>

   </div>
	</section>
	</div>
        </main>
    </div>
</div>
<div id="chat" class="chat">
    <div class="menu-name" style="display: block;">
			<b style="margin-left: 25px;">CHAT</b>
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

<script src='/js/vendor.js'></script>
<script src="/js/lang/en.js"></script>

    <script src="/js/roulette.js"></script>
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