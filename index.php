<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="main.css">
  <link rel="icon" href="child-solid.svg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--Ensures the website is responsive with mobile devices-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
  <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg fixed-top text-uppercase align-left">
    <div class="container-fluid header">
      <a class="navbar-brand js-scroll-trigger a1" href="index.php" id="header">Kirsty's Child Minding Services</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars a1"></i>
        </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav-brand ml-auto">
          <li class="nav mx-0 mx-lg-1">
            <input type="button" id="login" class="btn btn-outline-light nav-link rounded js-scroll-trigger" name="login" value="Login" onclick="location.href='login.php'" style="margin-top: 15px">
          </li>
        </ul>
        <ul>
          <li>
            <input type="button" id="register" class="btn btn-outline-light nav-link rounded js-scroll-trigger" name="register" value="Register" onclick="location.href='register.php'" style="margin-top: 15px">
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <div id="demo" class="carousel slide py" data-ride="carousel">
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
    </ul>
    <div class="carousel-inner upper">
      <div class="carousel-item active">
        <img class="img-fluid" src="https://imgur.com/a/cSsIjZU" alt="table">
      </div>
      <div class="carousel-item">
        <img class="img-fluid" src="https://imgur.com/a/cSsIjZU" alt="garden">
      </div>
      <div class="carousel-item">
        <img class="img-fluid" src="https://imgur.com/a/cSsIjZU" alt="toys">
      </div>
    </div>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a>
  </div>
  
<div class="col-md-auto container fixed-center">
  <div class="row">
    <div class="col-xl-6 offset">
      <div align="center">
        <h1 h1 style="font-size: 1.3vmax">Hello everyone, Welcome to my website. I am 24 years old, have worked in childcare for 8 years from nurseries, being a Nanny and working in a primary school. I now have a child of my own and want to use my skills to set up my own business and care
        for children in my own home so I can be with my son too. </h1>
      </div>
    </div>
      <div class="col-xl-6">
        <div align="center">
        <h1 style="font-size: 1.3vmax">
          I have a level 3 diploma in child care and education, foundation degree in learning and teaching and just completed my honours degree in learning and teaching. I am level 3 paediatric first aid trained, Safeguard trained, E-safety trained and hold a full
          UK driving licence. I am registered as a childminder and have a full DBS check, I have a sound knowledge of the EYFS and will ensure all children in my care can reach their full potential.
          </h1>
       </div>
     </div>
  </div>
</div>
  <!-- Footer -->
  <footer class="page-footer footer py-5 fixed-bottom" style="
  left: 0;
  bottom: 0;
  width: 100%;">
    <div class="container-fluid text-center text-">
      <div class="row">
        <div class="mx-auto text-center">
          <a style="color: #ffffff; font-weight: bold">Social Media
          <br>
          </a>
          <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://m.facebook.com/kirstygCMS/">
           <i class="fa fa-facebook-f"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>
 </head>
</body>
</html>