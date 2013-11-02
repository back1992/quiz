function manageEvent(eventObj, event, eventHandler) {
	if (eventObj.addEventListener) {
		eventObj.addEventListener(event, eventHandler,false);
	} else if (eventObj.attachEvent) {
		event = "on" + event;
		eventObj.attachEvent(event, eventHandler);
	}
}
window.onload=function() {
// events for buttons
manageEvent(document.getElementById("start"),"click",startPlayback);
manageEvent(document.getElementById("stop"),"click",stopPlayback);
manageEvent(document.getElementById("pause"),"click",pausePlayback);
// setup for video playback
var meadow = document.getElementById("meadow");
manageEvent(meadow,"timeupdate",reportProgress);
}
// video fallback
var detect = document.createElement("video");
if (!detect.canPlayType) {
	document.getElementById("controls").style.display="none";
}
// start video, enable stop and pause
// disable play
function startPlayback() {
	var meadow = document.getElementById("meadow");
	meadow.play();
	document.getElementById("pause").disabled=false;
	document.getElementById("stop").disabled=false;
	this.disabled=true;
}
// pause video, enable start, disable stop
// disable pause
function pausePlayback() {
	document.getElementById("meadow").pause();
	this.disabled=true;
	document.getElementById("start").disabled=false;
	document.getElementById("stop").disabled=true;
}
// stop video, return to zero time
// enable play, disable pause and stop
function stopPlayback() {
	var meadow = document.getElementById("meadow");
	meadow.pause();
	meadow.currentTime=0;
	document.getElementById("start").disabled=false;
	document.getElementById("pause").disabled=true;
	this.disabled=true;
}
// for every time divisible by 5, output feedback
function reportProgress() {
	var time = Math.round(this.currentTime);
	var div = document.getElementById("feedback");
	div.innerHTML = time + " seconds";
}
