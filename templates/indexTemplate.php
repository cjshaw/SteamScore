<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Steam Achievement Counter</title>
    <link rel="stylesheet" href="styles/stylesheet.css" type="text/css">
</head>
<body>
<nav id="topBar">
        <a href="index.php"><img id="logo" src="images/homeLogo.png"></a></li>
</nav>
<div id="wrapper">
    <main>
        <h1 id="header">See your Steam Score</h1>
        <form id="userForm" name="searchForm" method="GET" action="profile.php">
        <h4 id="indexForm">
            http://steamcommunity.com/id/
            <input id="username" type="text" class="placeholder" name="username" placeholder="(Steam Custom URL or 17-digit CommunityID)">
            <input id="indexForm" type="submit"  value="Go">
        </h4>
        </form>
    </main>
    <div id="empty">
    </div>
        <footer>
            <ul>
                <li>Steam Achievement Counter.  All data is <a href="http://steampowered.com">powered by Steam</a>.</li>
                <li>Not affiliated with Valve in any way.  All trademarks are property of their respective owners.</li>
            </ul>
        </footer>
</div><!-- end wrapper -->
</body>
</html>