/*
 * jQueryInstrument 
 * 
 * Version 0.0.1 (Beta)
 * 
 * Copyright (c) 2011 Rodrigo Aguilar, roaguilar@utalca.cl
 *
 * http://www.gnu.org/licenses/gpl.html
 * 
 * Last update - January, 2011
 */

jQuery.fn.jQueryInstrument = function(options){
	var opts = jQuery.extend(jQuery.fn.jQueryInstrument.defaults, options);
	
	return this.each(function(){
		instrument = jQuery("<div></div>")
			.addClass("jQuery-Instrument-background")
			.attr("id","__jQuery-Instrument-"+opts.instrumentType)
			.css({	"background" : "url("+opts.imgFolder+opts.instrumentType+"_DOWN.png) no-repeat center bottom",
				"width" : opts.imgWidth,
				"height": opts.imgHeight});
		
		
		if(opts.instrumentType == "WINDSPEED"){
			
			arrow = jQuery("<img/>")
				.attr("id","__jQuery-Instrument-level-WINDSPEED")
				.attr("src",opts.imgFolder+"WINDSPEED_UP.png")
				.css({ 	"width" : opts.imgWidth,
					"height": opts.imgHeight,
					"background" : "transparent",
					"margin" : "0px"});
			
			instrument.append(arrow);
			$(this).append(instrument);
			$.changeInstrumentLevel({
				instrumentLevel	: -122, 
				instrumentType	:"WINDSPEED", 
				imgWidth	:"250px", 
				imgHeight	:"250px"});			
			
		}
		else if(opts.instrumentType == "WINDDIR"){
			
			arrow = jQuery("<img/>")
				.attr("id","__jQuery-Instrument-level-WINDDIR")
				.attr("src",opts.imgFolder+"WINDDIR_UP.png")
				.css({ 	"width" : opts.imgWidth,
					"height": opts.imgHeight,
					"background" : "transparent",
					"margin" : "0px"});
			
			instrument.append(arrow);
			$(this).append(instrument);
			$.changeInstrumentLevel({
				instrumentLevel	: 0, 
				instrumentType	:"WINDDIR", 
				imgWidth	:"250px", 
				imgHeight	:"250px"});			
			
		}
		else{
			levelNumber = opts.instrumentLevel;
			levelNumberDiff = 100 - levelNumber;
			
			levelDiff = jQuery("<div></div>")
				.addClass("jQuery-Instrument-level-diff")
				.attr("id","__jQuery-Instrument-level-diff-"+opts.instrumentType)
				.css({"height": levelNumberDiff+"%"});
			
			
			level = jQuery("<div></div>")
				.addClass("jQuery-Instrument-level")
				.attr("id","__jQuery-Instrument-level-"+opts.instrumentType)
				.css({	"background" : "url("+opts.imgFolder+opts.instrumentType+"_UP.png) no-repeat center bottom",
					"width" : opts.imgWidth,
					"height": levelNumber+"%"});
		
			instrument.append(levelDiff);
			instrument.append(level);
		
			$(this).append(instrument);
		}
	});
};

jQuery.changeInstrumentLevel = function(options){
	
	var opts = jQuery.extend(jQuery.fn.jQueryInstrument.defaults, options);
	
	levelNumber = opts.instrumentLevel;
	
	if(opts.instrumentType == "WINDSPEED"){
		$("#__jQuery-Instrument-level-WINDSPEED").rotateAnimation(levelNumber);
	}
	else if(opts.instrumentType == "WINDDIR"){
		$("#__jQuery-Instrument-level-WINDDIR").rotateAnimation(levelNumber);
	}
	else{
		levelNumberDiff = 100 - levelNumber;
		$("#__jQuery-Instrument-level-"+opts.instrumentType).animate({"height":levelNumber+"%"},{queue:false,duration:500});
		$("#__jQuery-Instrument-level-diff-"+opts.instrumentType).animate({"height":levelNumberDiff+"%"},{queue:false,duration:500});
	}	
};

jQuery.changeInstrumentValue = function(options){
	
	var opts = jQuery.extend(jQuery.fn.jQueryInstrument.defaults, options);
	
	levelNumber = jQuery.fn.jQueryInstrument.value2Level(opts);
	
	if(opts.instrumentType == "WINDSPEED"){
		$("#__jQuery-Instrument-level-WINDSPEED").rotateAnimation(levelNumber);
	}
	else if(opts.instrumentType == "WINDDIR"){
		$("#__jQuery-Instrument-level-WINDDIR").rotateAnimation(levelNumber);
	}
	else{
		levelNumberDiff = 100 - levelNumber;
		$("#__jQuery-Instrument-level-"+opts.instrumentType).animate({"height":levelNumber+"%"},{queue:false,duration:500});
		$("#__jQuery-Instrument-level-diff-"+opts.instrumentType).animate({"height":levelNumberDiff+"%"},{queue:false,duration:500});
	}	
};

jQuery.fn.jQueryInstrument.value2Level = function(options){
	var opts = jQuery.extend(jQuery.fn.jQueryInstrument.defaults, options);
	
	valor = parseFloat(opts.instrumentValue);
	
	levelMax = 86;
	levelMin = 13;
	valueMax = opts.max;
	valueMin = opts.min;
	
	if(opts.instrumentType == "TEMP"){
		levelMax = 86;
		levelMin = 13;
		valueMax = 60;
		valueMin = -20;
	}
	else if(opts.instrumentType == "RH"){
		levelMax = 90;
		levelMin = 11;
		valueMax = 100;
		valueMin = 0;
	}
	else if(opts.instrumentType == "RAIN"){
		levelMax = 90;
		levelMin = 10;
		valueMax = 20;
		valueMin = 0;	
	}
	else if(opts.instrumentType == "GR"){
		levelMax = 90;
		levelMin = 10;
		valueMax = 1500;
		valueMin = 0;	
	}
	else if(opts.instrumentType == "WINDSPEED"){
		levelMax = 122;
		levelMin = -122;
		valueMax = 100;
		valueMin = 0;	
	}
	else if(opts.instrumentType == "WINDDIR"){
		levelMax = 360;
		levelMin = 0;
		valueMax = 360;
		valueMin = 0;	
	}
	else if(opts.instrumentType == "LW"){
		levelMax = 90;
		levelMin = 10;
		valueMax = 10;
		valueMin = 0;	
	}
	
	valor = (valor > valueMax ? valueMax : valor);
	valor = (valor < valueMin ? valueMin : valor);
	
	level = (valor + (valueMin < 0 ? Math.abs(valueMin) : 0)) * (levelMax - levelMin) / (Math.abs(valueMax)+Math.abs(valueMin));
	
	level = level + levelMin;
	
	return level;
};

jQuery.fn.jQueryInstrument.defaults = {
	instrumentType 	: "TEMP",
	instrumentValue	: 0,
	imgFolder 	: "../img/jQueryInstrument/",
	imgWidth 	: "106px",
	imgHeight	: "250px",
	instrumentLevel : 100,
	max		: 60,
	min		: -20
};
