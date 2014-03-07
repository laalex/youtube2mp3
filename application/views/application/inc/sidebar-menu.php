<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" id="project-title">ZongList</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?print base_url();?>dashboard"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
            <li><a href="<?print base_url();?>settings"><span class="glyphicon glyphicon-cog"></span>&nbsp;Settings</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="<?print base_url();?>dashboard"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
            <li><a href="<?print base_url();?>playlists"><span class="glyphicon glyphicon-tasks"></span>&nbsp;Playlists</a></li>
            <li><a href="<?print base_url();?>settings"><span class="glyphicon glyphicon-cog"></span>&nbsp;Settings</a></li>
            <li><a href="<?print base_url();?>logout"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Logout</a></li>
          </ul>
          <?php if(!empty($playlists)): ?>
            <hr />
              <h4><span class="glyphicon glyphicon-music"></span>&nbsp;Your playlists</h4>
              <ul class="nav nav-sidebar">
                <?php foreach($playlists as $list): ?>
                  <li><a href="<?print base_url();?>playlists/<?php print $list->list_id;?>"><span class="glyphicon glyphicon-tag"></span>&nbsp;<?php print $list->name; ?></a></li>
                <?php endforeach; ?>
              </ul>
            <hr />
          <?php endif; ?>
        </div>