<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
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
          <ul class="nav navbar-nav navbar-right">
            <li><a class="pointer" id="toggle_mp3"><span class="glyphicon glyphicon-headphones"></span>&nbsp;Toggle Player</a>
            <li><a id="toggle-downloads" data-visible="ok"><span class="glyphicon glyphicon-resize-small"></span>&nbsp;Hide downloads</a></li>
            <li><a href="<?php print base_url();?>dashboard/#/"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
            <!--<li><a href="<?php print base_url();?>dashboard/#/settings"><span class="glyphicon glyphicon-cog"></span>&nbsp;Settings</a></li>-->
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="<?php print base_url();?>dashboard/#/"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
            <li id="playlist_tut"><a href="<?php print base_url();?>dashboard/#/playlists"><span class="glyphicon glyphicon-tasks"></span>&nbsp;Playlists</a></li>
            <li id="invite_tut"><a href="<?php print base_url();?>dashboard/#/invite"><span class="glyphicon glyphicon-user"></span>&nbsp;Invite friend</a></li>
            <li><a href="<?php print base_url();?>dashboard/#/settings"><span class="glyphicon glyphicon-cog"></span>&nbsp;Settings</a></li>
            <hr />
            <li><a href="<?php print base_url();?>logout"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Logout</a></li>
            <hr />
            <li><a href="<?php print base_url();?>dashboard/#/android" style="color:#690 !important"><span class="glyphicon glyphicon-download"></span>&nbsp;Android APP</a></li>
            <hr />
            <li>
              <a href="" onclick="dispatchFeedback()"><span class="glyphicon glyphicon-flag"></span>&nbsp;Send feedback</a>
            </li>
          </ul>
        </div>