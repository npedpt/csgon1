function Functions() {
}

function _hash(data) {
  var $hash = '';

  for(var index in data) {
    $hash += index;

    if(data[index] instanceof Array || data[index] instanceof Object)
      $hash += _hash(data[index]);
    else
      $hash += data[index];

    $hash += $app.config.security_key;
  }
  return $hash;
}

Functions.prototype.checkHash = function(data, hash) {
  var $hash = _hash(data);
  var $result = hash == $app.sha1($hash);
  if(!$result) {
    console.log("Некорректный хэш: " + $app.sha1($hash) + " / " + hash);
    //return false;
  }

  return true;
};

module.exports = Functions;
