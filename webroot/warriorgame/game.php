<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
canvas {
    border: 1px solid #d3d3d3;    
    background-image: url("gamecanvas.png");	
}

#clickable-overlay {
    position: absolute;
    height: 28%;
    width: 33%;
    background-color: rgba(0, 0, 0, 0);
    //border: 1px dashed #fff;
    cursor: pointer;
	margin-left : 25%;
	margin-top:28%;
}
</style>
<link rel="stylesheet" href="stylegame.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="navbar" id="menuDiv" style="display:none;">
  <a class="active" href="#"><i class="fa fa-fw fa-folder-open"></i> INVENTORY</a>  
  <a href="javascript:characterSheet();"><i class="fa fa-fw fa-edit"></i> CHARACTER SHEET</a>
  <a href="#"><i class="fa fa-fw fa-save"></i> SAVE GAME</a>
  <a href="#"><i class="fa fa-fw fa-plus-square"></i> NEW GAME</a>
  <a href="#"><i class="fa fa-fw fa-sign-out"></i> QUIT</a>

</div>
<div>
        <div id='clickable-overlay'></div>
        <canvas id="myCanvas" width="1200" height="600" style="border:1px solid #000000;background-image: url('landing.png');">
        </canvas>
</div>		
</div>

<audio controls autoplay loop>
  <source src="bensound-sweet.mp3" type="audio/mpeg">  
  Your browser does not support the audio element.
</audio>

<script>

function startGame() {
	scrollToTop();	
     document.getElementById("menuDiv").style.display = "block";
     myGameArea.start();    	
}

document.getElementById("clickable-overlay").onclick=function(){
  swapCanvases();
};

function inventory() { 
 console.log('Inventory');
}

function characterSheet()
{
 console.log('Character Sheet');
}

function saveGame()
{

}

function newGame()
{

}

var myGameArea = {
    canvas : document.createElement("canvas"),
    start : function() {	
        this.canvas.width = 1200;
        this.canvas.height = 600;
	    this.canvas.id = "gamearena2";
        this.context = this.canvas.getContext("2d");        
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
    }
}

function swapCanvases(){
	startGame();  
    removeElement('myCanvas');
  
}

function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

function scrollToTop() { 
            window.scrollTo(0, 0); 
        } 

</script>
</body>
</html>
