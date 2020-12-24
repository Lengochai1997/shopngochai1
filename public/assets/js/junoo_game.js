var game;
var wheel;
var canSpin;
var slices = 8;
var prize, degrees, gift;
var prizeText;
window.onload = function () {
    game = new Phaser.Game(458, 488, Phaser.AUTO, "", null, true);
    game.state.add("PlayGame", playGame);
    game.state.start("PlayGame")
};
var playGame = function (game) {};
playGame.prototype = {
    preload: function () {
        game.load.image("wheel", "../style/images/wheel.png");
        game.load.image("pin", "../style/images/quay.png")
    },
    create: function () {
        game.stage.backgroundColor = "#444";
        wheel = game.add.sprite(game.width / 2, game.width / 2, "wheel");
        wheel.anchor.set(0.5);
        var _0x5923xa = game.add.sprite(game.width / 2, game.width / 2, "pin");
        _0x5923xa.anchor.set(0.5);
        canSpin = true;
        game.input.onDown.add(this.spin, this)
    },
    spin: function () {
        if (canSpin) {
            var _0x5923xb = game.rnd.between(3, 5);
            $.ajax({
                url: "/assets/ajax/junoo_wheel.php",
                method: "POST",
                async: false,
                dataType: "json",
                data: {},
                cache: false,
                complete: function (_0x5923xc) {
                    _0x5923xc = JSON.parse(_0x5923xc.responseText);
                    if (_0x5923xc.status == -1) {
                        alert(_0x5923xc.errormessage);
                        return
                    };
                    degrees = _0x5923xc.degrees;
                    gift = _0x5923xc.gift;
                    canSpin = false;
                    var _0x5923xd = game.add.tween(wheel).to({
                        angle: 360 * _0x5923xb + degrees
                    }, 5000, Phaser.Easing.Quadratic.Out, true);
                    _0x5923xd.onComplete.add(function () {
                        canSpin = true;
                        alert(_0x5923xc.gift)
                    }, this)
                }
            })
        }
    }
}