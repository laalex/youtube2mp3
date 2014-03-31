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
  </div>
  <div class="navbar-collapse collapse">
    <?php echo form_open("auth/login",array('class'=>'navbar-form navbar-right'));?>
      <div class="form-group">
        <input type="text" placeholder="Email" class="form-control" name="identity">
      </div>
      <div class="form-group">
        <input type="password" placeholder="Password" class="form-control" name="password">
      </div>
      <button type="submit" class="btn btn-success">Sign in</button>
      <span style="color:#fff">&nbsp;or&nbsp;</span>
      <a href="<?php print base_url();?>register" class="btn btn-primary">Sign up</a>
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
    <a href="<?php print base_url();?>register"><div class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok"></span> &nbsp; CREATE ACCOUNT</div></a>
    <br />
  </div>
</div>


<div class="container">

  <div class="row">
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-user"></span></h2>
      <h3>Create account</h3>
      <p>First of all create an account to keep track of your download history and build download playlists</p>
    </div>
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-download-alt"></span></h2>
      <h3>Download application</h3>
      <p>Get the Android application, log in, and start downloading</p>
   </div>
    <div class="col-md-4 center">
      <h2><span class="glyphicon glyphicon-headphones"></span></h2>
      <h3>Listen</h3>
      <p>What next? Nothing more. Sit back and relax enjoying the music on your android device</p>
    </div>
  </div>
  <br /><br />
</div>
<hr>
<div class="container center">
  <h1>Download the ZongList application for Android</h1>
  <br />
  <p>Get all your music to your mobile phone in one simple click. 
  <br />
  Click the button below and get started right away</p>
  <br />
  <a href="<?php base_url();?>assets/apk/beta-zonglist.apk"><div class="btn btn-success btn-lg"><span class="glyphicon glyphicon-phone"></span>&nbsp;DOWNLOAD</div></a>
</div>
<hr>


<footer class="container">
  <p>&copy; ZongList. A project by <a href="mailto:roshkattu94@gmail.com" target="_blank">Alexandru Lamba</a></p>
</footer>