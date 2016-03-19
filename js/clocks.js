var self = this;

var digitalClock;
var digitalClockAus;
var digitalClockNY;
var digitalClockBL;
var digitalClockIndia;

var canvasElementLocal;
var canvasElementAus;
var canvasElementNY;
var canvasElementBL;
var canvasElementIndia;

var now;

var ctxLocal;
var ctxAus;
var ctxNY;
var ctxBL;
var ctxIndia;

var completeCycle = ((2*Math.PI)/60);
var completeCycleHours = ((2*Math.PI)/12);
var haveBeenIncreased = false;
var isSpeedIncreased = false;
var speedVeloc = 1;

var increaseInterval;
var decreaseInterval;

var addLog = function(msj) {
  $('#log').append(msj+'<br />--------------------<br />');
}
	
var updateClocks = function(offset){
  if(!isSpeedIncreased && !haveBeenIncreased) {
    if(offset==null)
    {
      now = new Date();
    }
    else
    {
      var aux = new Date();
      var utc = aux.getTime() + (aux.getTimezoneOffset() * 60000);
      now = new Date(utc + (3600000*offset));
    }      
  } else {
    now.setMilliseconds(now.getMilliseconds()+(Math.pow(10, speedVeloc)));
  }
  updateAnalogClock();
}

var updateClocksAus = function(offset){
  if(!isSpeedIncreased && !haveBeenIncreased) {
    if(offset==null)
    {
      now = new Date();
    }
    else
    {
      var aux = new Date();
      var utc = aux.getTime() + (aux.getTimezoneOffset() * 60000);
      now = new Date(utc + (3600000*offset));
    }      
  } else {
    now.setMilliseconds(now.getMilliseconds()+(Math.pow(10, speedVeloc)));
  }
  updateAnalogClockAus();
}

var updateClocksNY = function(offset){
  if(!isSpeedIncreased && !haveBeenIncreased) {
    if(offset==null)
    {
      now = new Date();
    }
    else
    {
      var aux = new Date();
      var utc = aux.getTime() + (aux.getTimezoneOffset() * 60000);
      now = new Date(utc + (3600000*offset));
    }      
  } else {
    now.setMilliseconds(now.getMilliseconds()+(Math.pow(10, speedVeloc)));
  }
  updateAnalogClockNY();
}

var updateClocksBL = function(offset){
  if(!isSpeedIncreased && !haveBeenIncreased) {
    if(offset==null)
    {
      now = new Date();
    }
    else
    {
      var aux = new Date();
      var utc = aux.getTime() + (aux.getTimezoneOffset() * 60000);
      now = new Date(utc + (3600000*offset));
    }      
  } else {
    now.setMilliseconds(now.getMilliseconds()+(Math.pow(10, speedVeloc)));
  }
  updateAnalogClockBL();
}

var updateDigitalClock = function() {
 var time = ('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2);
	digitalClock.html(time);
}

var updateClocksIndia = function(offset){
  if(!isSpeedIncreased && !haveBeenIncreased) {
    if(offset==null)
    {
      now = new Date();
    }
    else
    {
      var aux = new Date();
      var utc = aux.getTime() + (aux.getTimezoneOffset() * 60000);
      now = new Date(utc + (3600000*offset));
    }      
  } else {
    now.setMilliseconds(now.getMilliseconds()+(Math.pow(10, speedVeloc)));
  }
  updateAnalogClockIndia();
}

var updateDigitalClock = function() {
 var time = ('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2);
	digitalClock.html(time);
}

var updateAnalogClock = function() {
  
  ctxLocal.clearRect(0,0, 500, 500);
  
	ctxLocal.beginPath();
	ctxLocal.arc(250,250,200,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000)+now.getSeconds()))-0.5*Math.PI);
	
  //Seconds marker style
  ctxLocal.strokeStyle = '#C8CBD0';
	ctxLocal.lineWidth = 5;
	ctxLocal.stroke();
  
  //Minutes marker style
	ctxLocal.beginPath();
	ctxLocal.arc(250,250,185,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000/60)+now.getSeconds()/60 + now.getMinutes()))-0.5*Math.PI);
	ctxLocal.strokeStyle = '#128aef';
	ctxLocal.lineWidth = 13;
	ctxLocal.stroke();
  
  var hours = ((now.getHours() + 11) % 12 + 1);
  
	ctxLocal.beginPath();
	ctxLocal.arc(250,250,160,(1.5*Math.PI),(completeCycleHours*((now.getMilliseconds()/1000/60/60)+now.getSeconds()/60/60 + now.getMinutes()/60 + hours))-0.5*Math.PI);
	
  //Hours marker style
  ctxLocal.strokeStyle = '#00FCC9';
	ctxLocal.lineWidth = 20;
	ctxLocal.stroke();
  
  ctxLocal.beginPath();
  ctxLocal.lineWidth = 1;
  
  ctxLocal.font = "22px Roboto";
  ctxLocal.fillStyle = 'white';
  ctxLocal.strokeStyle = 'white';
  for(var j=1; j<=12; j++) {
    ctxLocal.fillText(j, getNumberPositions(j)[0],  getNumberPositions(j)[1]);
  }
  
  ctxLocal.font = "100px 'Roboto'";
  ctxLocal.fillStyle = 'white';
  ctxLocal.fontWeight = '100';
  ctxLocal.fillText(('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2), 125, 278);
}

var updateAnalogClockAus = function(offset) {
  
  ctxAus.clearRect(0,0, 500, 500);
  
  ctxAus.beginPath();
  ctxAus.arc(250,250,200,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000)+now.getSeconds()))-0.5*Math.PI);
  
  //Seconds marker style
  ctxAus.strokeStyle = '#C8CBD0';
  ctxAus.lineWidth = 5;
  ctxAus.stroke();
  
  //Minutes marker style
  ctxAus.beginPath();
  ctxAus.arc(250,250,185,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000/60)+now.getSeconds()/60 + now.getMinutes()))-0.5*Math.PI);
  ctxAus.strokeStyle = '#128aef';
  ctxAus.lineWidth = 13;
  ctxAus.stroke();
  
  var hours = ((now.getHours() + 11) % 12 + 1);
  
  ctxAus.beginPath();
  ctxAus.arc(250,250,160,(1.5*Math.PI),(completeCycleHours*((now.getMilliseconds()/1000/60/60)+now.getSeconds()/60/60 + now.getMinutes()/60 + hours))-0.5*Math.PI);
  
  //Hours marker style
  ctxAus.strokeStyle = '#00FCC9';
  ctxAus.lineWidth = 20;
  ctxAus.stroke();
  
  ctxAus.beginPath();
  ctxAus.lineWidth = 1;
  
  ctxAus.font = "22px Roboto";
  ctxAus.fillStyle = 'white';
  ctxAus.strokeStyle = 'white';
  for(var j=1; j<=12; j++) {
    ctxAus.fillText(j, getNumberPositions(j)[0],  getNumberPositions(j)[1]);
  }
  
  ctxAus.font = "100px 'Roboto'";
  ctxAus.fillStyle = 'white';
  ctxAus.fontWeight = '100';
  ctxAus.fillText(('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2), 125, 278);
}

var updateAnalogClockNY = function(offset) {
  
  ctxNY.clearRect(0,0, 500, 500);
  
  ctxNY.beginPath();
  ctxNY.arc(250,250,200,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000)+now.getSeconds()))-0.5*Math.PI);
  
  //Seconds marker style
  ctxNY.strokeStyle = '#C8CBD0';
  ctxNY.lineWidth = 5;
  ctxNY.stroke();
  
  //Minutes marker style
  ctxNY.beginPath();
  ctxNY.arc(250,250,185,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000/60)+now.getSeconds()/60 + now.getMinutes()))-0.5*Math.PI);
  ctxNY.strokeStyle = '#128aef';
  ctxNY.lineWidth = 13;
  ctxNY.stroke();
  
  var hours = ((now.getHours() + 11) % 12 + 1);
  
  ctxNY.beginPath();
  ctxNY.arc(250,250,160,(1.5*Math.PI),(completeCycleHours*((now.getMilliseconds()/1000/60/60)+now.getSeconds()/60/60 + now.getMinutes()/60 + hours))-0.5*Math.PI);
  
  //Hours marker style
  ctxNY.strokeStyle = '#00FCC9';
  ctxNY.lineWidth = 20;
  ctxNY.stroke();
  
  ctxNY.beginPath();
  ctxNY.lineWidth = 1;
  
  ctxNY.font = "22px Roboto";
  ctxNY.fillStyle = 'white';
  ctxNY.strokeStyle = 'white';
  for(var j=1; j<=12; j++) {
    ctxNY.fillText(j, getNumberPositions(j)[0],  getNumberPositions(j)[1]);
  }
  
  ctxNY.font = "100px 'Roboto'";
  ctxNY.fillStyle = 'white';
  ctxNY.fontWeight = '100';
  ctxNY.fillText(('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2), 125, 278);
}

var updateAnalogClockBL = function(offset) {
  
  ctxBL.clearRect(0,0, 500, 500);
  
  ctxBL.beginPath();
  ctxBL.arc(250,250,200,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000)+now.getSeconds()))-0.5*Math.PI);
  
  //Seconds marker style
  ctxBL.strokeStyle = '#C8CBD0';
  ctxBL.lineWidth = 5;
  ctxBL.stroke();
  
  //Minutes marker style
  ctxBL.beginPath();
  ctxBL.arc(250,250,185,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000/60)+now.getSeconds()/60 + now.getMinutes()))-0.5*Math.PI);
  ctxBL.strokeStyle = '#128aef';
  ctxBL.lineWidth = 13;
  ctxBL.stroke();
  
  var hours = ((now.getHours() + 11) % 12 + 1);
  
  ctxBL.beginPath();
  ctxBL.arc(250,250,160,(1.5*Math.PI),(completeCycleHours*((now.getMilliseconds()/1000/60/60)+now.getSeconds()/60/60 + now.getMinutes()/60 + hours))-0.5*Math.PI);
  
  //Hours marker style
  ctxBL.strokeStyle = '#00FCC9';
  ctxBL.lineWidth = 20;
  ctxBL.stroke();
  
  ctxBL.beginPath();
  ctxBL.lineWidth = 1;
  
  ctxBL.font = "22px Roboto";
  ctxBL.fillStyle = 'white';
  ctxBL.strokeStyle = 'white';
  for(var j=1; j<=12; j++) {
    ctxBL.fillText(j, getNumberPositions(j)[0],  getNumberPositions(j)[1]);
  }
  
  ctxBL.font = "100px 'Roboto'";
  ctxBL.fillStyle = 'white';
  ctxBL.fontWeight = '100';
  ctxBL.fillText(('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2), 125, 278);
}

var updateAnalogClockIndia = function(offset) {
  
  ctxIndia.clearRect(0,0, 500, 500);
  
  ctxIndia.beginPath();
  ctxIndia.arc(250,250,200,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000)+now.getSeconds()))-0.5*Math.PI);
  
  //Seconds marker style
  ctxIndia.strokeStyle = '#C8CBD0';
  ctxIndia.lineWidth = 5;
  ctxIndia.stroke();
  
  //Minutes marker style
  ctxIndia.beginPath();
  ctxIndia.arc(250,250,185,(1.5*Math.PI),(completeCycle*((now.getMilliseconds()/1000/60)+now.getSeconds()/60 + now.getMinutes()))-0.5*Math.PI);
  ctxIndia.strokeStyle = '#128aef';
  ctxIndia.lineWidth = 13;
  ctxIndia.stroke();
  
  var hours = ((now.getHours() + 11) % 12 + 1);
  
  ctxIndia.beginPath();
  ctxIndia.arc(250,250,160,(1.5*Math.PI),(completeCycleHours*((now.getMilliseconds()/1000/60/60)+now.getSeconds()/60/60 + now.getMinutes()/60 + hours))-0.5*Math.PI);
  
  //Hours marker style
  ctxIndia.strokeStyle = '#00FCC9';
  ctxIndia.lineWidth = 20;
  ctxIndia.stroke();
  
  ctxIndia.beginPath();
  ctxIndia.lineWidth = 1;
  
  ctxIndia.font = "22px Roboto";
  ctxIndia.fillStyle = 'white';
  ctxIndia.strokeStyle = 'white';
  for(var j=1; j<=12; j++) {
    ctxIndia.fillText(j, getNumberPositions(j)[0],  getNumberPositions(j)[1]);
  }
  
  ctxIndia.font = "100px 'Roboto'";
  ctxIndia.fillStyle = 'white';
  ctxIndia.fontWeight = '100';
  ctxIndia.fillText(('0' + now.getHours()).slice(-2)+':'+('0' + now.getMinutes()).slice(-2), 125, 278);
}

var getNumberPositions = function(hour) {
  var x = Math.cos(Math.PI/2 - (Math.PI/6*hour)) * 235;
  var y = Math.sin(Math.PI/2 - (Math.PI/6*hour)) * -235;
  x += 240;
  y += 255;
  return [x, y];
}

var init = function(offset) {
  canvasElementLocal=$('#canvasElementlocal');
  digitalClock=$('#digitalClock');  
  ctxLocal = canvasElementLocal[0].getContext('2d');
  setInterval(function(){updateClocks(offset)}, 50);
}

var initAus = function(offset){
  canvasElementAus=$('#canvasElementAus');
  digitalClockAus=$('#digitalClockAus');  
  ctxAus = canvasElementAus[0].getContext('2d');
  setInterval(function(){updateClocksAus(offset)}, 50);  
}

var initNY = function(offset){
  canvasElementNY=$('#canvasElementNY');
  digitalClockNY=$('#digitalClockNY');  
  ctxNY = canvasElementNY[0].getContext('2d');
  setInterval(function(){updateClocksNY(offset)}, 50);  
}

var initBL = function(offset){
  canvasElementBL=$('#canvasElementBL');
  digitalClockBL=$('#digitalClockBL');  
  ctxBL = canvasElementBL[0].getContext('2d');
  setInterval(function(){updateClocksBL(offset)}, 50);  
}

var initIndia = function(offset){
  canvasElementIndia=$('#canvasElementIndia');
  digitalClockIndia=$('#digitalClockIndia');  
  ctxIndia = canvasElementIndia[0].getContext('2d');
  setInterval(function(){updateClocksIndia(offset)}, 50);  
}