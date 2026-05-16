<html>
<?php
/*
if (isset($this->session->userdata['logged_in'])) {
  header("location: ".base_url()."penggunaan/ruang");
}
*/
$base_url = 'https://ppf.fisip.ui.ac.id/backend/';
?>
<head>
<title>Login Form</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Surat Tugas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=$base_url;?>assets/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$base_url;?>assets/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?=$base_url;?>assets/AdminLTE/dist/css/skins/skin-blue.css">
  <link rel="stylesheet" href="<?=$base_url;?>assets/css/style.css">
</head>

<body>

<?php
/*
if (isset($logout_message)) {
    echo "<div class='message'>";
    echo $logout_message;
    echo "</div>";
}
?>
<?php
if (isset($message_display)) {
    echo "<div class='message'>";
    echo $message_display;
    echo "</div>";
}
*/
?>

<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-sm-8 col-md-8 col-lg-8"><hr></div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
    	<div class="title-1">
        	<span class="title-1">SURAT TUGAS</span>
            <span class="title-2">ONLINE</span>
        </div>	
	</div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12" style="font-family: 'Poiret One', cursive; color:#fff; text-align: center">
    	<div style="font-size:18px"></div>
        <div style="line-height: 12px">&nbsp;</div>  
         <div style="font-size:18px; font-weight: bold; color:#fa0">Fakultas Ilmu Sosial dan Ilmu Politik<br> Universitas Indonesia</div>
    </div>
</div>

<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-sm-8 col-md-8 col-lg-8"><hr></div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>


<div class="row">
    <div class="col-md-8 col-lg-8" style="left: 10%; transform: translateX(-10%);">

        <br>

<link href="https://fonts.googleapis.com/css?family=Raleway:200,100,400" rel="stylesheet" type="text/css" />

        <br>
        
        <div class="box box-warningx" style=" background: #ddd; color: #000">
            <div class="box-header with-border" style="text-align:center">
                <h3 class="box-title" style="overflow:hidden; white-space: nowrap;"><div class="anim-typewriter" style="color: #ff5252;">Informasi</div></h3>            
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <span class="label label-warning">!</span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-bodyx">
            	
   			        <div class="callout">
                    <!--<p>
                        Dalam upaya untuk mengurangi penggunaan kertas di lingkungan FISIP UI, maka untuk proses pengajuan pembuatan surat tugas akan dilakukan uji coba secara online.
                    </p>-->
                    <p>
                    Dalam upaya untuk mengurangi penggunaan kertas di lingkungan FISIP UI, maka untuk proses pengajuan pembuatan surat tugas dilakukan secara online.
                    </p>        
                </div><br>
            </div>
            
        </div>  

    </div>
    <div class="col-md-4 col-lg-4">

        <div class="container">
            <div id="login-box" style="margin-top:0px">
                <div class="logo">
                    <img src="<?=$base_url?>assets/images/UI_logo.png" class="img img-responsive img-circle center-block" height="150" width="150"/>
                    <h2 class="logo-caption">
                        <span class="tweak">S</span>ingle <span class="tweak">S</span>ign <span class="tweak">O</span>n <br><small>Universitas Indonesia</small>
                    </h2>
                </div><!-- /.logo -->
                <div style="border-top:1px solid:#fff;"></div>
                <div class="controls">
                  <form class="form-signin" role="form" action="views/otentikasi.php" method="post">
                    <input type="text" name="username" id="name" placeholder="Username" class="form-control" />
                    <input type="password" name="password" placeholder="Password" class="form-control" />
                    <!--<button type="button" class="btn btn-default btn-block btn-custom">Login</button>-->
                    <input type="submit" class="btn btn-default btn-block btn-custom" value=" Login " name="submit"/>
                  </form>
                </div><!-- /.controls -->
            </div><!-- /#login-box -->
        </div><!-- /.container -->        
    </div> 
    
</div>

<div id="xparticles-js"></div>
</body>

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>-->
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<style>
@import url('https://fonts.googleapis.com/css?family=Nunito');
@import url('https://fonts.googleapis.com/css?family=Poiret+One');

body, html {
  height: 100%;
  background-repeat: no-repeat;    /*background-image: linear-gradient(rgb(12, 97, 33),rgb(104, 145, 162));*/
  background:black;
  position: relative;
  background:  linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../../assets/images/10893207.png');
}
.callout{
    margin: 5px;
    font-family: verdana;
    padding:5px;
    border-left-color: #fa0;
    border-bottom: 1px solid #fa0;
    border-top: 1px solid #fa0;
}
p {
    font-family: 'Raleway', sans-serif;
    z-index: 9999;
    color: #000;
    /*top:50%;
     transform: translateY(-50%);   */
}
.title-1{
	font-family: 'Poiret One', cursive;
	font-size:32px;
	color:gold;
	font-weight:bold;
	text-align:center;
}
.title-2{
	font-family: 'Poiret One', cursive;
	font-size:27px;
	color:#fff;
	font-weight:bold;
	text-align:center;
}
#login-box {
  position: absolute;
  top: 0px;
  left: 50%;
  transform: translateX(-50%);
  width: 250px;
  margin: 0 auto;
  border: 1px solid black;
  background: rgba(48, 46, 45, 1);
  min-height: 250px;
  padding: 20px;
  z-index: 9999;
}
#login-box .logo .logo-caption {
  font-family: 'Poiret One', cursive;
  color: white;
  text-align: center;
  margin-bottom: 0px;
}
#login-box .logo .tweak {
  color: #ff5252;
}
#login-box .controls {
  padding-top: 30px;
}
#login-box .controls input {
  border-radius: 0px;
  background: rgb(98, 96, 96);
  border: 0px;
  color: white;
  font-family: 'Nunito', sans-serif;
}
#login-box .controls input:focus {
  box-shadow: none;
}
#login-box .controls input:first-child {
  border-top-left-radius: 2px;
  border-top-right-radius: 2px;
}
#login-box .controls input:last-child {
  border-bottom-left-radius: 2px;
  border-bottom-right-radius: 2px;
}
#login-box button.btn-custom, #login-box input[type=submit].btn-custom {
  border-radius: 2px;
  margin-top: 8px;
  background:#ff5252;
  border-color: rgba(48, 46, 45, 1);
  color: white;
  font-family: 'Nunito', sans-serif;
}
#login-box button.btn-custom:hover, #login-box input[type=submit].btn-custom:hover{
  -webkit-transition: all 500ms ease;
  -moz-transition: all 500ms ease;
  -ms-transition: all 500ms ease;
  -o-transition: all 500ms ease;
  transition: all 500ms ease;
  background: rgba(48, 46, 45, 1);
  border-color: #ff5252;
    border: 1px solid #ff5252;
}
#particles-js{
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: 50% 50%;
    position: fixed;
    top: 0px;
    z-index:1;
}
/* Animation */
.anim-typewriter{
  animation: typewriter 4s steps(44) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
             animation-iteration-count: infinite;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 24em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}
</style>

<script>
$.getScript("https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js", function(){
    particlesJS('particles-js',
      {
        "particles": {
          "number": {
            "value": 80,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            },
            "polygon": {
              "nb_sides": 5
            },
            "image": {
              "width": 100,
              "height": 100
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 5,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "repulse"
            },
            "onclick": {
              "enable": true,
              "mode": "push"
            },
            "resize": true
          },
          "modes": {
            "grab": {
              "distance": 400,
              "line_linked": {
                "opacity": 1
              }
            },
            "bubble": {
              "distance": 400,
              "size": 40,
              "duration": 2,
              "opacity": 8,
              "speed": 3
            },
            "repulse": {
              "distance": 200
            },
            "push": {
              "particles_nb": 4
            },
            "remove": {
              "particles_nb": 2
            }
          }
        },
        "retina_detect": true,
        "config_demo": {
          "hide_card": false,
          "background_color": "#b61924",
          "background_image": "",
          "background_position": "50% 50%",
          "background_repeat": "no-repeat",
          "background_size": "cover"
        }
      }
    );

});
</script>
</html>