$(function() {

  var coin_sound = new Howl({
    urls: ['/assets/sound/coinflip.mp3']
  })
  
  var url = window.location.href;
	var hash_url = url.replace('http://138.68.104.53/game/', '');

  var app = new App();

  var joingame = false;

  var end = false;
  app.socket.on('join-game', function(game) {
    if(!joingame) {
      joingame = true;
      console.log('Player '+game.enemy_name+' has joined');
      if (game.owner_id != app.getSteamId()) {
        return false;
      }

      $("#competitor-player-image").attr('src', game.enemy_img);
      $("#competitor-player-name").text(game.enemy_name);

                 }
  });


  app.socket.on('end-game', function(game) {

    //не обновляем инфу у тех, кто к игре отношения не имеет
    if(game.owner_id != app.getSteamId() && game.enemy_id != app.getSteamId()) {
      return false;
    }
	
	if(hash_url != game.id){
		return false;
	}

    if(end){
      return false;
    }

    end = true;

    var $current_game = $('#game-' + game.id);
    $current_game.find("#winner-text").html('Flipping...');
    setTimeout(function() {
      $current_game.find("#vs").html('5');
      var a = 5;
      var timer = setInterval(function() {
        a--;
        $current_game.find("#vs").text(a);
        if(a < 1) {
          clearInterval(timer);

          $current_game.find("#vs").text("VS");

          if(game.winner_team == 't') {
          	random = Math.random()
          	gift = '<center><img width="300" loop="1" height="300" src="/assets/images/animation/terrorist_3.gif?nocache=' + random + '"></center>';
            $current_game.find("#result").html(gift);
          } else {
          	random2 = Math.random()
          	gifct = '<center><img width="300" loop="1" height="300" src="/assets/images/animation/counterterrorist_3.gif?nocache=' + random2 + '"></center>';
            $current_game.find("#result").html(gifct);
          }
          var mute = $('meta[name="muted"]').attr('content');
          if(mute == 'false') coin_sound.play();

          setTimeout(function() {
			  if(game.winner_team == 't') {
            $current_game.find('#room-terrorist-shadow').addClass('active-winner-coin');
          } else {
            $current_game.find('#room-counterterrorist-shadow').addClass('active-winner-coin');
          }
            console.log('Winner: '+game.winner_name);

            $current_game.find("#winner-text").html('Winner: <span id="winner-name">' + game.winner_name + '</span>');
            $current_game.find("#winner-text").html('Winner is ' + game.winner_name);

            if(game.winner_steam_id == app.getSteamId()) {
              app.post('/ajax/updateBalance', {}, function(success) {
                if(success != undefined) {
                  balanceNow = $('#balance').text();
                  $('#balance').prop('number', balanceNow).animateNumbers(success);
             $('#create-game').show('slow');



                  //$('#balance').text(success);
                }
              });
            }
            setTimeout(function() {
              $('#verify').css('display', 'block');
              $('#winning-percentage').text(game.chance);
              $('#round-hash').text(game.id);
              $('#random').val(JSON.stringify(game.verify.random));
              $('#signature').val(game.verify.signature);

              console.log('Game Over');
            },1000);
          }, 1200);
        }
      }, 1000);
    }, 1000);
  });
});
