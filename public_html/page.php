<?php
// Creates the elements in the <head> of the page
function WriteHead($title = "DeBary Disc Golf Club", $desc = "DeBary Disc Golf Club", $shouldIndex = 1)
{
    ?>
    <!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="description" content="<?=$desc?>">
    <meta name="robots" content="<?=$shouldIndex ? 'index' : 'noindex' ?>">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa|Righteous" rel="stylesheet">
    <link rel="icon" href="images/logo_200.png">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113170186-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-113170186-1');
    </script>
    </head>
    <?php
}

// Write the header section/nav of the page
function WriteHeader()
{
    ?>
        <header>
            <a href="index.php"><img src="images/logo_200.png" alt="DeBary Disc Golf Club Logo" ></a>
            <div id="headerContent">
            <div id="headerTitle"><h1>DeBary Disc <span class="nowrap">Golf Club</span></h1></div>
        <?php AddNav(); ?>
        </div>
	    </header>
    <?php
}

// Adds the nav buttons
function AddNav()
{
    $navButtons = array(
        "Members" => "members.php",
        "Courses" => "courses.php",
        "Calendar" => "calendar.php",
        "Links" => "links.php"
    );
    ?>
    <div class="nav">
	    	<ul>
            <?php
                while (list($name, $url) = each($navButtons))
                {
                    AddNavButton($name, $url);
                }
            ?>		
	    	</ul>
	    </div>
    <?php
}

// Adds a nav button
function AddNavButton($name, $url)
{
    echo "<li ";
    if (isCurrentUrl($url))
    {
        echo "class=''current' ";
    }
    echo '><a href="'.$url.'">'.$name."</a></li>";
}

// Returns true if $url is the current page
function isCurrentUrl($url)
{
    if(strpos($_SERVER['PHP_SELF'], $url) === false)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function AddFooter()
{
    ?>
    <footer>
 <p>
 <a href="https://www.facebook.com/groups/192035720947651/"><img src="images/FB.png" alt="FaceBook Logo"></a> 
 <span class="nowrap">Club Information: <a href="mailto:brianroberts2526@yahoo.com" >Brian Roberts</a></span> | 
 <span class="nowrap">Webmaster: <a href="mailto:stevekentsphone@gmail.com" >Steve Kent</a></span> <br>
    &copy; Copyright 2019 DeBary Disc Golf Club</p>
    
 </footer>
</body>
</html>
    <?php
}
?>