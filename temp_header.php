<div id="topHeader">
    <div class="wrapper">
        <div class="info">
            <span>
                <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;+381637479753
                </span>
            <span>
                <i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;mirkojosimovic1987@gmail.com
                </span>
            <span><a href="http://localhost/portal/xml/newsportalxml.php" target="_blank">RSS&nbsp;&nbsp;<i class="fa fa-rss" aria-hidden="true" style="color: orange"></i></a> </span>
        </div>
        <div class="social">
            <ul>
                <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com/?lang=sr" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <?php
        if(isset( $_SESSION['first_name']))
        {
            ?>
            <div class="user_account">
                <ul>
                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;<?=$_SESSION['first_name']?>&nbsp;&nbsp;<i class="fa fa-chevron-down" aria-hidden="true" style="font-size:12px"></i></a>
                        <ul>
                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My profile</a></li>
                            <?php
                            if($_SESSION['status'] == 'user')
                                echo "<li><a href='admin/pocetna.php'><i class='fa fa-lock' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['status']."</a></li>";
                            else echo "<li><a href='admin/pocetna.php'><i class='fa fa-unlock-alt' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['status']."</a></li>";
                            ?>
                            <li><a href="index.php?logout"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
</div><!-- end topHeader-->
<div id="midleHeader" class="negativ">
    <div class="wrapper">
        <div class="logo">
            <a href="index.php"><img src="images/news_portal_logo.jpg"></a>
        </div>
        <div class="login">
            <a href="admin/users.php" class="button">sign in or sign up</a>
        </div>
    </div>
</div><!-- end midleHeader -->
<div id="bottomHeader">
    <div class="wrapper" style="position: relative">
        <nav class="nav">
            <ul id="meni">
                <li><a href="index.php">naslovna</a></li>
                <?php
                $db = connect();
                prikaziMeni($db);
                ?>
                <!--
                <li><a href="#">info</a></li>
                <li><a href="#">hronika</a></li>
                <li><a href="#">zabava</a></li>
                <li><a href="#">sport</a></li>
                <li><a href="#">mob&amp;it</a></li>
                -->
				 <li><a href="gallery.php">galerija</a></li>
				 <li><a href="contact.php">contact</a></li>
            </ul>
        </nav>
        <div id="search_form">
            <form action="search.php" method="get" id="mojaForma" name="mojaForma">
                <div class="input-group">
                    <input type="text" name="pretraga" placeholder="Search" class="form-control">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-search"></span>
							</span>
                </div>
            </form>
        </div>
    </div>
</div><!-- end bottomHeader -->
