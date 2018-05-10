<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Steam Achievement Counter</title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" href="styles/stylesheet.css" type="text/css">
</head>
<body>
<nav id="topBar">
        <a href="index.php"><img id="logo" src="images/homeLogo.png"></a>
</nav>
<div id="wrapper">
    <div id="pCard">
        <div id="leftCol">
            <ul id="leftProfile">
                <h1 id="username"> <?php echo $personaname ?> </h1>
                <a href=" <?php echo $profileURL ?> "><img id="avatar" src="<?php echo $avatarURL ?>"></a>
            </ul>
        </div> <!--end leftCol-->
        <div id="rightCol">
            <h1 id="score">Steam Score: <?php echo $scoreSum ?></h1>
        </div> <!--end rightCol-->
    </div> <!--end pCard-->
    <div id="gridContain">
        <div class='gridItem'>
            <form name="myForm" action="game.php" method="get" target="_blank">
        <?php echo $gridItem?>
            </form>
        </div>
    </div><!--end gridContain -->
    <footer>
        <ul>
            <li>Steam Achievement Counter.  All data is <a href="http://steampowered.com">powered by Steam</a>.</li>
            <li>Not affiliated with Valve in any way.  All trademarks are property of their respective owners.</li>
        </ul>
    </footer>
</div><!-- end wrapper -->
</body>
</html>