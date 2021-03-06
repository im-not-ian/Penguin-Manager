<?php

include 'session.php';

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Penguin - Search</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>

<div class="overlay">
<ul>
<div class="default-li">
<li><a class="links" href="home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
<li><a class="active" href="search.php"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
<?php
if ($_SESSION['isStaff'] == true) {
?>
<li><a class="links" href="moderator.php">Mod Panel</a></li>
<?php if ($_SESSION['isAdmin'] == true) { ?>
<li><a class="links" href="admin.php">Admin Panel</a></li>
<?php } } ?>
<li><a class="links" href="store.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Store</a></li>
<li><a class="links" href="server.php"><i class="fa fa-server" aria-hidden="true"></i> Server</a></li>
<li><a class="links" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
</div>
<div class="profile-li">
<li class="profile-li">   <div class="dropdown-content">
      <a class="test2" href="settings.php"><font color="white"><i class="fa fa-cog" aria-hidden="true"></i> Settings<font></a>
      <a class="test" href="logout.php"><font color="white"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</font></a>
    </div><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i>
<?php

include 'config.php';

$strUsername = $_SESSION['login_user'];

$mysql = mysqli_connect($strDBHost, $strDBUser, $strDBPass, $strDBName);

$resQuery = mysqli_query($mysql, "SELECT * FROM users WHERE username = '$strUsername'");


echo ' ' . $arrResults['username'] . '';
?>
</a>
</li></li>
</ul>
<div class="container">
<div class="login-page">

<form class="form" name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php

include 'config.php';

$strError = '';

$mysql = mysqli_connect($strDBHost, $strDBUser, $strDBPass, $strDBName);

if (isset($_POST['submit'])) {
    $strSearch = $_POST['search'];
    if (isset($strSearch)) {
       $strSearch = mysqli_real_escape_string($mysql, $strSearch);
       $strSearch = addslashes($strSearch);
       $resQuery = mysqli_query($mysql, "SELECT * FROM users WHERE username = '$strSearch'");
       $arrResults = mysqli_fetch_assoc($resQuery);
       if (!empty($arrResults)) {
           $arrRanks = array(
                1 => 'Member',
                2 => 'Member',
                3 => 'Mediator',
                4 => 'Moderator',
                5 => 'Administrator',
                6 => 'Owner'
           );
          echo '<center>';
          echo '<img  src="avatar.php?avatarInfo=' . implode('|', array($arrResults['colour'], $arrResults['head'], $arrResults['face'], $arrResults['body'], $arrResults['neck'], $arrResults['feet'])) . '&avatarSize=300">';
          echo '<br><br>';
          echo '<p>Username: ' . $arrResults['username'] . '</p>';
          echo '<p>Email: ' . $arrResults['email'] . '</p>';
          echo '<p>Penguin Age: ' . round((time() - strtotime($arrResults['age'])) / 86400) . '</p>';
          echo '<p>Coins: ' . $arrResults['coins'] . '</p>';
          echo '<p>Rank: ' . $arrRanks[$arrResults['rank']] . '</p>';
          echo '<p>Last Seen: ' . $arrResults['LastLogin'] . '</p>';
          echo "</center>";
      } else {
          $strError = 'No user found with provided details';
      }
    } else {
       $strError = 'Please fill in your search information';
    }
}
?>
       <input type="text" name="search" maxlength="25" placeholder="Type a username">
       <input type="submit" id="login-button" name="submit" value="Search">
       <span><?php echo $strError; ?></span>
</form>
</div>
</div>

</div>
<div class="footer">Designed by Jack. Coded by Lynx.</div> <!--Please don't remove this line.-->
</div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</html>
