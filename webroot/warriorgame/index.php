<!DOCTYPE html>
<html lang="en">
<head>
<title>Warrior Game</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

/* Style the body */
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

/* Header/logo Title */
.header {
  padding: 30px;
  text-align: center;
  background: #1abc9c;
  color: white;
}

/* Increase the font size of the heading */
.header h1 {
  font-size: 40px;
}

/* Sticky navbar - toggles between relative and fixed, depending on the scroll position. It is positioned relative until a given offset position is met in the viewport - then it "sticks" in place (like position:fixed). The sticky value is not supported in IE or Edge 15 and earlier versions. However, for these versions the navbar will inherit default position */
.navbar {
  overflow: hidden;
  background-color: #333;
  position: sticky;
  position: -webkit-sticky;
  top: 0;
}

/* Style the navigation bar links */
.navbar a {
  float: centre;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 20px;
  text-decoration: none;
}


/* Right-aligned link */
.navbar a.right {
  float: right;
}

/* Change color on hover */
.navbar a:hover {
  background-color: #ddd;
  color: black;
}

/* Active/current link */
.navbar a.active {
  background-color: #666;
  color: white;
}

/* Column container */
.row {  
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
}

/* Create two unequal columns that sits next to each other */
/* Sidebar/left column */
.side {
  -ms-flex: 30%; /* IE10 */
  flex: 30%;
  background-color: #f1f1f1;
  padding: 20px;
}

/* Main column */
.main {   
  -ms-flex: 70%; /* IE10 */
  flex: 70%;
  background-color: white;
  padding: 20px;
}

/* Fake image, just for this example */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
}

/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
  .row {   
    flex-direction: column;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .navbar a {
    float: none;
    width: 100%;
  }
}
</style>
</head>
<body>

<div class="header">
  <h1>Warrior Game</h1>
 <h3> <p>A <b>demo</b> game created for testing purpose.</p></h3>

	<h2>Become a part of a decentralised organisation</h2>
    <h3>Contribute to the platform, earn rewards and you will receive voting rights and shares of future profits.</h3>

</div>

<div class="navbar">
  
  <h2><p><a style="text-align:center" href="game.php">DEMO GAME</a></p></h2>
   
</div>

<div class="row">
  <div class="side">
    <h2>Backlog items you can choose</h2>
    
    <ol>
	<li>create menu system:Inventory, quit, character sheet, save game, new game</li>
	<li>Create character creation step: 3 different classes: Warrior, Rogue, Wizard</li>
	<li>create inventories screen and ability to obtain items</li>
	<li>create store where random items can be bought with gold. Place storekeeper on each level of dungeon.</li>
	<li>create combat mechanics: taking turns,, damage healing,</li>
	<li>create items: healing potion, mana potion, which can be bought at the store</li>
	<li>Weapons and armour: random statistics such as damage, speed, armour rating</li>
	<li>create level up process and unique abilities that can be chosen for each class as they level up<li>
	<li>Create user interface</li>
	<li>Create map: 3 levels of a dungeon that get harder as you progress</li>
	<li>create movement across map</li>
	<li>create monsters</li>
	<li>add random monsters to map</li>
	<li>create final boss and add to map</li>
	</ol>

   </div>
  <div class="main">
    <h2>EARN REWARDS BY CONTRIBUTING TO OPEN SOURCE SOFTWARE</h2> 
   <li>Welcome Testers to the Commenticode platform. This is an experiment in decentralised organisations and we could really use your opinion about the idea and the platform, as well as your input about what may be changed and improved.
</li>
<br>
    <li>                                                    
    Use the code contribution system to help us create a game. 1st, take a look at the demo. Then, pick a feature you would like to add and help us by submitting your code.</p></li>
    
<li>Pick a backlog item and upload your code. If your solution receives enough votes, ,you will receive rewards.
Or you can also review and vote on other developers contributions to receive rewards.</li>
    
       
 
<h2>
Note: This application is in a testing phase and the coin rewards currently do not have any value.
</h2>
    
  </div>
</div>

<div class="footer">
  <h2>Commenticode@2021</h2>
</div>

</body>
</html>
