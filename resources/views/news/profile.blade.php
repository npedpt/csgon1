
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
    <a class="expandable" title="" href="/user/profile" style="border-right: 3px solid #ffcc01;">
      <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/my-profile-selected.png">
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
        <a class="expandable" title="" href="/faq">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/about.png">
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
        <a class="expandable" title="" href="/faq">
          <span class="glyphicon collapsed-element">
            <img class="sidebar-icon" src="/assets/images/menu/about.png">
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

  
<!--<div class="center">
    <div class="top-navigation">
    </div>
	
    <div class="main-wrapper">
        <main>
		<div style="height: 10px;" class="top-line row 100% page"></div>
                <div class="roulette">
				<section id="roulette-section">
    <div class="content">

    <div id="middle" class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div id="tos" class="settings tos box squished-box" style="padding: 25px">

            <div class="box-padded-header" style="margin-bottom: 10px;">
                <div class="semi-bold box-header" style="margin: 0 auto;">
                    <span class="very-bold"><h1>Terms of Service</h1></span>
                </div>
            </div>

            <p>
                Attention! The present terms of service (further in the text also the Agreement) extends to all legal relationship arising between the owner of the network CSGOTurbo resource and its visitor (consumer).
                <br>
                <br>
                <i>When using this network resource it is supposed that the equipment of each of participants of legal relationship technically regularly, has no program and other defects, doesnt work under the influence of a malicious code and has the sufficient capacity and other characteristics of a communication channel allowing to use contents of this network resource fully.</i>
            </p>
			
			<p>
                This Agreement provides formalization of process of use by the visitor (consumer) of all opportunities of the network CSGOTurbo resource. Following points belong to opportunities of the specified network resource, but without being limited:
                <br>
                <br>
                <i>a) providing information on the software products which are in addition used when using the software of CS:GO which is a computer multiplayer team game of a genre of FPS (further in the text also CS:GO), and also about their cost;</i>
            </p>
			
			<p>
                b) the formal proposal of the owner of this network resource addressed to an unlimited circle of visitors (consumers) to conclude the bargain on rendering services upon purchase of any additional software products, with the indication of all of conditions necessary for this purpose (the public offer provided by Art. 437 of the Civil code of the Russian Federation);
                <br>
                <br>
                <i>v) the program code integrated into structure of this network resource which result of action represents automatic not representative selection of the additional software product in case of the conclusion of the transaction with the visitor (consumer) of a resource;</i>
            </p>

			<p>
                g) integration with service for payment of the made purchase of Unitpay;
                <br>
                <br>
                <i>d) integration with services of digital distribution of computer games and programs (including Steam from the Valve company);</i>
            </p>
            
			<p>
                e) the technical support realized in the form of feedback and by means of the list most of frequently asked questions (FAQ).
                <br>
                <br>
                <i>This Agreement, at its unconditional acceptance by the visitor (consumer) by putting down of a tick &quot;I agree with conditions of terms of service&quot;, it is considered accepted and gets force of the public contract (Art. 426 of the Civil code of the Russian Federation).</i>
            </p>

			<p>
                Subject of the Agreement, at his acceptance the visitor (consumer), purchase and sale of services in receiving additional software products for use in CS:GO, according to the catalog of categories of products placed on the main page of the network CSGOTurbo resource, and also services in alienation (including sale) such products which are available for the visitor (consumer) is.
                <br>
                <br>
                <i>Feature of receiving the additional software product is the choice by the visitor (consumer) of the category interesting him additional program product. The cost of each product entering concrete category is specified in the catalog and is invariable.</i>
            </p>
			
			<p>
                The software products entering one category are equated among themselves at cost and on all other indicators.
                <br>
                <br>
                <i>In this regard after the choice of the interesting category there is an automatic not representative selection of a certain product which is carried out in the automatic mode by the special program code integrated into structure of the network CSGOTurbo resource then the visitor (consumer) gets technical access to the concrete automatically chosen software product. This condition is obligatory, and in case of disagreement with him the visitor (consumer) of a resource has the right to refuse the conclusion of the transaction.</i>
            </p>
			
			<p>
                When using of the acquired additional software product in CS:GO his operability and compliance to characteristics of the corresponding category of software products is guaranteed. At the same time it must be kept in mind that, despite the identical cost of software products of one category, their value when using in CS:GO can fluctuate in the wide range.
                <br>
                <br>
                <i>The risk of further use of the acquired software product from the moment of his input into CS:GO passes completely to the visitor. The owner of the network CSGOTurbo resource doesnt bear responsibility for possible consequences of use of the software product acquired by the visitor (consumer) in CS:GO.</i>
            </p>
			
			<p>
                The detailed statement of processes of purchase, sale, receiving the acquired goods, transfers of the alienated goods and so forth is published on pages of the network CSGOTurbo resource.
                <br>
                <br>
                <i>Acquaintance with all information placed on pages of the network CSGOTurbo resource is an obligatory stage before acceptance of this Agreement.</i>
            </p>
			
			<p>
                The owner of the network CSGOTurbo resource doesnt bear responsibility for the difficulties arising at the visitor (consumer) in use by the acquired service, caused by poor quality of the lines and communication channels provided to the visitor (consumer) by the third parties and also for the difficulties connected with application of the counterfeit software.
                <br>
                <br>
                <i>Use in the description of the provided service of the term &quot;lottery&quot; is the extra legal comparison of some signs of service more clear to the ordinary visitor (consumer), and doesnt attract the consequences provided by chapter 58 of the Civil code of the Russian Federation as these services arent a lottery or other type of games and a bet.</i>
            </p>
			
			<p>
                Cancellation of the made acceptance (approval and an unconditional consent with all conditions) is allowed only in case of technical failure, an unpremeditated mistake from this or that party of the transaction or in connection with emergence of force majeure circumstances. In all other cases the transaction cant be cancelled. At emergence of disputes and disputable situations of the party undertake to resolve the arisen question extrajudicially. The visitor (consumer) has to report about all cases of illegal use of personal data, others electronic means of payment and other violations immediately in a support service of the network CSGOTurbo resource.
                <br>
                <br>
                <i>In case of impossibility to settle dispute extrajudicially or at commission of an offense with use of personal data all further relationship can be brought to trial for proceedings on the merits.</i>
            </p>
        </div>
    </div>
    </div>
	</section>
	</div>
        </main>
    </div>
</div> -->
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