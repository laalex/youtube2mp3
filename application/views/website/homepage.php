<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#" id="project-title"><img src="<?php print base_url();?>assets/img/logo.png"></a>
    <span class="beta">1.0 BETA</span>
  </div>
  <div class="navbar-collapse collapse">
    <?php echo form_open("auth/login",array('class'=>'navbar-form navbar-right'));?>
      <div class="form-group">
        <input type="text" placeholder="Email" class="form-control" name="identity">
      </div>
      <div class="form-group">
        <input type="password" placeholder="Password" class="form-control" name="password">
      </div>
      <button type="submit" class="btn btn-success">LOGIN</button>
     <?php echo form_close();?>
  </div><!--/.navbar-collapse -->
</div>
</div>


<div class="jumbotron">
  <div class="container center">
    <br />
    <h1><span class="glyphicon glyphicon-music"></span></h1>
    <h2>Grab your music to your phone in just 3 clicks. As easy as that</h2>
    <h4>download the application and get your MP3 songs instantly</h4>
    <br />
    <br />
  </div>
</div>


<div class="container">

  <div class="row">
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-user"></span></h2>
      <h3>LOGIN</h3>
      <p>Login to your account and manage your playlists</p>
      <p>Customize everything to take advantage of our application</p>
    </div>
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-download-alt"></span></h2>
      <h3>Android Application</h3>
      <p>Get the Android application to download music to your device</p>
      <p>One song at a time or an entire playlist</p>
   </div>
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-headphones"></span></h2>
      <h3>ENJOY</h3>
      <p>Enjoy your music on your PC, laptop, tablet or phone</p>
      <p>ZongList offers you this comfort</p>
    </div>
  </div>
  <br /><br />
</div>
<hr>

<div class="container center">
  <h3>ZongList 1.0 BETA</h3>
  <br />
  <p>ZongList is currently BETA and released to a small public. There might be a lot of glitches and problems, so we encourage you to offer us the propper feedback so we can fix everything for you and offer you the best experience. Come back over here to keep in touch with our release notes.
  <br />
</div>
<hr>


<footer class="container" style="text-align:center">
  <p>Copyright &copy; ZongList. All rights reserved</p>
  <br />
  <a href="/tos">Terms of Use</a> &middot; <a href="https://www.facebook.com/ZongList" target="_blank">FaceBook Page</a> &middot; <a href="https://www.twitter.com/ZongList" target="_blank">Follow us on Twitter</a>
  <br /><br />
</footer>