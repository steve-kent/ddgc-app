<?php

class Page
{
    private $content = "";
    private $desc = "DeBary Disc Golf Club";
    private $title = "DeBary Disc Golf Club";
    private $navButtons = array(
        "Members" => "members.php",
        "Courses" => "courses.php",
        "Calendar" => "calendar.php",
        "Links" => "links.php"
    );
    private $headAdditions = "";
    private $styleSheet = "css/styles.css";
    private $shouldIndex = 1;
    // Setter for private variables
    public function __set($name, $val)
    {
        $this->$name = $val;
    }

    // Creates the elements in the <head> of the page
    private function WriteHead()
    {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta name="description" content="<?=$this->desc?>">
        <meta name="robots" content="<?=$this->shouldIndex ? 'index' : 'noindex' ?>">
        <title><?=$this->title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?=$this->styleSheet?>">
        <link href="https://fonts.googleapis.com/css?family=Comfortaa|Righteous" rel="stylesheet">
        <link rel="icon" href="images/logo_200.png">
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113170186-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-113170186-1');
        </script>
        <?=$this->headAdditions?>
        </head>
        <?php
    }

    // Write the header section/nav of the page
    private function AddHeader()
    {
        ?>
            <header><a href="index.php"><img src="images/logo_200.png" alt="DeBary Disc Golf Club Logo" ></a>
    	    <div id="mobile_header_breaks">
    	    <br><br><br>
    	    </div>
    	    <h1>DeBary Disc Golf Club</h1>
            <?php $this -> AddNav(); ?>
    	    </header>
        <?php
    }

    // Adds the nav buttons
    private function AddNav()
    {
        ?>
        <div class="nav">
    	    	<ul>
                <?php
                    while (list($name, $url) = each($this->navButtons))
                    {
                        $this -> AddNavButton($name, $url);
                    }
                ?>		
    	    	</ul>
    	    </div>
        <?php
    }

    // Adds a nav button
    private function AddNavButton($name, $url)
    {
        echo "<li ";
        if ($this->isCurrentUrl($url))
        {
            echo "class=\"current\" ";
        }
        echo '><a href="'.$url.'">'.$name."</a></li>";

    }

    // Returns true if $url is the current page
    private function isCurrentUrl($url)
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

    private function AddFooter()
    {
        ?>
        <footer>
	    <p>
	    <a href="https://www.facebook.com/groups/192035720947651/"><img src="images/FB.png" alt="FaceBook Logo"></a> 
	    <span class="nowrap">Club Information: <a href="mailto:brianroberts2526@yahoo.com" >Brian Roberts</a></span> | 
	    <span class="nowrap">Webmaster: <a href="mailto:stevekentsphone@gmail.com" >Steve Kent</a></span> <br>
        &copy; Copyright 2019 DeBary Disc Golf Club</p>
        
	    </footer>
        
        <?php
    }

    // diplay the page
    public function Display()
    {
        $this -> WriteHead();
        $this -> AddHeader();
        echo $this -> content;
        $this -> AddFooter();


    }
}

?>