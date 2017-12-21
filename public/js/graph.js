function style(theme, width) {
	function combineTheme(obj) {
		if (typeof obj[theme] === "string") {
			return obj[theme]
		} else {
			return Object.assign({}, obj.base, obj[theme]);
		}
	}

	function combineState(obj) {
		var states = {
			playing: [],
			cashed: [],
			lost: [],
			starting: [],
			startingBetting: ["starting", "playing"],
			progress: [],
			progressPlaying: ["progress", "playing"],
			progressCashed: ["progress", "cashed"],
			ended: [],
			endedCashed: ["ended", "cashed"]
		};
		var ret = {};
		Object.keys(states).forEach(function(state) {
			var sups = states[state];
			var res = Object.assign({}, obj.base || {});
			sups.forEach(function(sup) {
				Object.assign(res, obj[sup] || {})
			});
			Object.assign(res, obj[state]);
			ret[state] = res
		});
		return ret
	}

	function fontSizeNum(times) {
		return times * width / 100
	}

	function fontSizePx(times) {
		var fontSize = fontSizeNum(times);
		return fontSize.toFixed(2) + "px"
	}
	var strokeStyle = combineTheme({
		white: "Black",
		black: "#ffffff"
	});
	var fillStyle = combineTheme({
		white: "black",
		black: "#ffffff"
	});
	return {
		fontSizeNum: fontSizeNum,
		fontSizePx: fontSizePx,
		graph: combineState({
			base: {
				lineWidth: 6,
				strokeStyle: "#3be66e"
			},
			playing: {
				lineWidth: 6,
				strokeStyle: "#7cba00"
			},
			cashed: {
				lineWidth: 6
			}
		}),
		axis: {
			lineWidth: 1,
			font: "10px 'lato'",
			textAlign: "center",
			strokeStyle: "white",
			fillStyle: fillStyle
		},
		data: combineState({
			base: {
				textAlign: "center",
				textBaseline: "middle"
			},
			starting: {
				font: fontSizePx(5) + " 'lato'",
				fillStyle: "grey"
			},
			progress: {
				font: fontSizePx(20) + " 'lato'",
				fillStyle: "#ffffff"
			},
			progressPlaying: {
				fillStyle: "#7cba00"
			},
			ended: {
				font: fontSizePx(15) + " 'lato'",
				fillStyle: "#3be66e"
			}
		})
	}
}
var XTICK_LABEL_OFFSET = 20;
var XTICK_MARK_LENGTH = 5;
var YTICK_LABEL_OFFSET = 11;
var YTICK_MARK_LENGTH = 5;

function getEmHeight(font) {
	var sp = document.createElement("span");
	sp.style.font = font;
	sp.style.display = "inline";
	sp.textContent = "Hello world!";
	document.body.appendChild(sp);
	var emHeight = sp.offsetHeight;
	document.body.removeChild(sp);
	return emHeight
}

function tickSeparation(s) {
	if (!Number.isFinite(s)) {
		throw new Error("Is not a number: ", s)
	};
	var r = 1;
	while (true) {
		if (r > s) {
			return r
		};
		r *= 2;
		if (r > s) {
			return r
		};
		r *= 5
	}
}

function Graph() {
	this.canvas = null;
	this.ctx = null;
	this.animRequest = null;
	this.renderBound = this.render.bind(this)
}
Graph.prototype.startRendering = function(canvasNode, config) {
	console.assert(!this.canvas && !this.ctx);
	if (!canvasNode.getContext) {
		return console.error("No canvas")
	};
	this.ctx = canvasNode.getContext("2d");
	this.canvas = canvasNode;
	this.configPlotSettings(config, true);
	this.animRequest = window.requestAnimationFrame(this.renderBound)
};
Graph.prototype.stopRendering = function() {
	window.cancelAnimationFrame(this.animRequest);
	this.canvas = this.ctx = null
};
Graph.prototype.configPlotSettings = function(config, forceUpdate) {
	var devicePixelRatio = window.devicePixelRatio || 1;
	var backingStoreRatio = this.ctx.webkitBackingStorePixelRatio || this.ctx.mozBackingStorePixelRatio || this.ctx.msBackingStorePixelRatio || this.ctx.oBackingStorePixelRatio ||
		this.ctx.backingStorePixelRatio || 1;
	var ratio = devicePixelRatio / backingStoreRatio;
	if (this.canvasWidth !== config.width || this.canvasHeight !== config.height || this.devicePixelRatio !== devicePixelRatio || this.backingStoreRatio !==
		backingStoreRatio || forceUpdate) {
		this.canvasWidth = config.width;
		this.canvasHeight = config.height;
		this.devicePixelRatio = devicePixelRatio;
		this.backingStoreRatio = backingStoreRatio;
		this.canvas.style.width = config.width + "px";
		this.canvas.style.height = config.height + "px";
		this.canvas.width = config.width * ratio;
		this.canvas.height = config.height * ratio
	};
	this.ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
	this.style = style(config.currentTheme, this.canvasWidth);
	this.xMinTickSeparation = 2 * this.ctx.measureText("10000").width;
	this.yMinTickSeparation = getEmHeight(this.style.axis.font) * (config.controlsSize === "small" ? 1.75 : 4);
	this.xStart = 30;
	this.yStart = 20;
	this.plotWidth = this.canvasWidth - this.xStart;
	this.plotHeight = this.canvasHeight - this.yStart;
	this.XTimeMinValue = 10000;
	this.YPayoutMinValue = 200;
};
Graph.prototype.calculatePlotValues = function() {
	this.currentTime = getElapsedTimeWithLag(Engine);
	this.currentGrowth = 100 * growthFunc(this.currentTime);
	this.currentPayout = 100 * calcGamePayout(this.currentTime);
	this.XTimeBeg = 0;
	this.XTimeEnd = Math.max(this.XTimeMinValue, this.currentTime);
	this.YPayoutBeg = 100;
	this.YPayoutEnd = Math.max(this.YPayoutMinValue, this.currentGrowth);
	this.XScale = this.plotWidth / (this.XTimeEnd - this.XTimeBeg);
	this.YScale = this.plotHeight / (this.YPayoutEnd - this.YPayoutBeg);
};
Graph.prototype.trX = function(t) {
	return this.XScale * (t - this.XTimeBeg)
};
Graph.prototype.trY = function(p) {
	return -(this.YScale * (p - this.YPayoutBeg))
};
Graph.prototype.render = function() {
	this.calculatePlotValues();
	this.clean();
	this.ctx.save();
	this.ctx.translate(this.xStart, this.canvasHeight - this.yStart);
	this.drawAxes();
	this.drawGraph();
	this.ctx.restore();
	this.drawGameData();
	this.animRequest = window.requestAnimationFrame(this.renderBound)
};
Graph.prototype.clean = function() {
	this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight)
};
Graph.prototype.drawGraph = function() {
	var style = this.style.graph;
	var ctx = this.ctx;
	Object.assign(ctx, Engine.currentlyPlaying ? style.playing : style.progress);
	var tstep = this.YPayoutEnd < 1000 ? 100 : Math.max(100, Math.floor(2 / this.XScale));
	ctx.beginPath();
	for (var t = this.XTimeBeg; t < this.currentTime; t += tstep) {
		var x = this.trX(t);
		var y = this.trY(100 * calcGamePayout(t));
		ctx.lineTo(x, y)
	};
	ctx.stroke()
};
Graph.prototype.drawAxes = function() {
	var ctx = this.ctx;
	Object.assign(ctx, this.style.axis);
	var payoutSeparation = tickSeparation(this.yMinTickSeparation / this.YScale);
	var timeSeparation = tickSeparation(this.xMinTickSeparation / this.XScale);
	var x, y, payout, time;
	ctx.beginPath();
	payout = this.YPayoutBeg + payoutSeparation;
	for (; payout < this.YPayoutEnd; payout += payoutSeparation) {
		y = this.trY(payout);
		//ctx.moveTo(0, y);
		//ctx.lineTo(XTICK_MARK_LENGTH, y);
	}
	time = timeSeparation;
	for (; time < this.XTimeEnd; time += timeSeparation) {
		x = this.trX(time);
		ctx.moveTo(x, 0);
		ctx.lineTo(x, -YTICK_MARK_LENGTH);
	}
	var x0 = this.trX(this.XTimeBeg),
		x1 = this.trX(this.XTimeEnd),
		y0 = this.trY(this.YPayoutBeg),
		y1 = this.trY(this.YPayoutEnd);
	ctx.moveTo(x0, y1);
	ctx.lineTo(x0, y0);
	ctx.lineTo(x1, y0);
	ctx.stroke();
	payout = this.YPayoutBeg + payoutSeparation;
	/*for (; payout < this.YPayoutEnd; payout += payoutSeparation) {
		y = this.trY(payout);
		ctx.fillText((payout / 100) + 'x', -XTICK_LABEL_OFFSET, y);
	}*/
	time = 0;
	for (; time < this.XTimeEnd; time += timeSeparation) {
		x = this.trX(time);
		ctx.fillText(time / 1000, x, YTICK_LABEL_OFFSET);
	}
};
Graph.prototype.drawGameData = function() {
	var style = this.style.data;
	var ctx = this.ctx;
	switch (Engine.gameState) {
		case "STARTING":
			var timeLeft = (Engine.startTime).toFixed(1);
			Object.assign(ctx, style.starting);
			ctx.fillText("Next round in " + timeLeft + "s", this.canvasWidth / 2, this.canvasHeight / 2);
			break;
		case "IN_PROGRESS":
			Object.assign(ctx, Engine.currentlyPlaying ? style.progressPlaying : style.progress);
			ctx.fillText((Engine.currentCrashNumber / 100).toFixed(2) + "x", this.canvasWidth / 2, this.canvasHeight / 2);
			currentCrash = Engine.currentCrashNumber / 100;
			break;
		case "ENDED":
			Object.assign(ctx, style.ended);
			ctx.fillText("Busted", this.canvasWidth / 2, this.canvasHeight / 2 - this.style.fontSizeNum(15) / 2);
			ctx.fillText("@ " + formatDecimals(Engine.gameCrash / 100, 2) + "x", this.canvasWidth / 2, this.canvasHeight / 2 + this.style.fontSizeNum(15) / 2);
			break;
	}
};

function str2int(s) {
	s = s.replace(/,/g, "");
	s = s.toLowerCase();
	var i = parseFloat(s);
	if (isNaN(i)) {
		return 0
	} else {
		if (s.charAt(s.length - 1) == "k") {
			i *= 1000
		} else {
			if (s.charAt(s.length - 1) == "m") {
				i *= 1000000
			} else {
				if (s.charAt(s.length - 1) == "b") {
					i *= 1000000000
				}
			}
		}
	};
	return i
}

function calcGamePayout(ms) {
	var gamePayout = Math.floor(100 * growthFunc(ms)) / 100;
	console.assert(isFinite(gamePayout));
	return gamePayout;
}

function growthFunc(ms) {
	var r = 0.00006;
	return Math.pow(Math.E, r * ms);
}

function formatDecimals(n, decimals) {
	if (typeof decimals === "undefined") {
		if (n % 100 === 0) {
			decimals = 0
		} else {
			decimals = 2
		}
	};
	return n.toFixed(decimals).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

function getElapsedTime(startTime) {
	return Date.now() - startTime
}

function getElapsedTimeWithLag(engine) {
	if (engine.gameState == "IN_PROGRESS") {
		var elapsed;
		if (engine.lag) {
			elapsed = engine.lag - engine.startTime
		} else {
			elapsed = getElapsedTime(engine.startTime)
		};
		return elapsed
	} else {
		return 0
	}
}