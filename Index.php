<!DOCTYPE html>
<html>
<head>

 <title>Truii</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">

</head>
<body style="background-image: url('BackGround/StartBackGround.png');background-position:right top;">

  <img src="Logo/truii-full-colour-white.png" alt="TruiiLogo" style="width:50%;height:15%;margin-top:5%;margin-left:25%;margin-right:25%";>

  <div class="container-fluid"
      style="width:90%;margin-top:1%;margin-left:5%;margin-right:5%;background:rgba(253, 103, 26, 0.8);border-radius:25px;">

        <form action="action.php">
          <div class="row" align="center" style="width:90%;margin-top:10%;margin-left:5%;margin-right:5%;">
            <div class="div-username">
              <label style="display:inline-block;width:30%;font-size:150%;color:#FFFFFF;">
                Username
              </label><br>
                <input type="text" name="username" style="width:100%;border-radius:5px;padding-left:2%;font-size:150%;">
            </div>
          </div>

          <div class="row" align="center" style="width:90%;margin-top:5%;margin-left:5%;margin-right:5%;">
            <div class="div-password">
              <label style="display:inline-block;width:30%;font-size:150%;color:#FFFFFF;">
                Password
              </label><br>
                <input type="password" name="password" style="width:100%;border-radius:5px;padding-left:2%;font-size:150%;">
            </div>
          </div>

          <div class="row" align="center" style="width:90%;margin-top:10%;margin-left:5%;margin-right:5%;">
            <div class="div-submit">
              <input type="submit" value="Login"style="width:100%;border-radius:5px;font-size:150%;">
            </div>
          </div>
        </form>

          <div class="row" align="center" style="width:90%;margin-top:10%;margin-left:5%;margin-right:5%; margin-bottom:10%;">
            <div class="div-registration">
              <form action="Registration.php">
                <input type="submit" value="Register" style="width:100%;border-radius:5px;font-size:150%;"/>
              </form>
            </div>
          </div>
  </div>
  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
