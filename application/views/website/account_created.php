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
    <br /><br />
    <h1><?php print $this->session->flashdata('message'); ?></h1>
    <br />
    <h3>Please check your email for more information!</h3>
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

<footer class="container" style="text-align:center">
  <p>Copyright &copy; ZongList. All rights reserved</p>
  <br />
  <a href="/tos">Terms of Use</a> &middot; <a href="https://www.facebook.com/ZongList" target="_blank">FaceBook Page</a> &middot; <a href="https://www.twitter.com/ZongList" target="_blank">Follow us on Twitter</a>
  <br /><br />
</footer>