 <nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOMEADMIN'); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="members.php"><?php echo lang('USERS'); ?> </a></li>
        <li><a href="subscribers.php"><?php echo lang('SUBSCRIBES'); ?></a></li>
        <li><a href="projects.php"><?php echo lang('PROJECTS'); ?> </a></li>
        <li><a href="messages.php"><?php echo lang('MSG'); ?> </a></li>
        <li><a href="articles.php"><?php echo lang('ARTICLES'); ?> </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Username <span class="caret"></span></a>
          <ul class="dropdown-menu">
           <li><a href="../index.php">Visit Site</a></li>
            <li><a href="about.php"><?php echo lang('ABOUT'); ?></a></li>
            <li><a href="logout.php"><?php echo lang('LogOut'); ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>