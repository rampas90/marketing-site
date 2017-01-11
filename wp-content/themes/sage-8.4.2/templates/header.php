<header class="banner" role="banner">
  <nav class="navbar navbar-default ">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="ui-menu__content">
            <i class="ui-menu__line ui-menu__line_1"></i>
            <i class="ui-menu__line ui-menu__line_2"></i>
            <i class="ui-menu__line ui-menu__line_3"></i>
          </span>
        </button>
        <a class="logo header-logo" href="<?php echo home_url('/'); ?>"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="/solutions" class="hidden-xs hidden-sm">Solutions</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solutions</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_solutions',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="/segments" class="hidden-xs hidden-sm">Segments</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Segments</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_segments',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li><a href="/services">Services</a></li>
          <li class="dropdown hidden-xs hidden-sm">
            <a href="/resources" class="hidden-xs hidden-sm">Resources</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Resources</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_resources',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown hidden-md hidden-lg">
            <a href="/resources" class="hidden-xs hidden-sm">Resources</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Resources</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_resources_mobile',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="/community" class="hidden-xs hidden-sm">Community</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Community</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_community',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="/company-info" class="hidden-xs hidden-sm">About</a>
            <a class="dropdown-toggle hidden-md hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_about',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="hidden-xs hidden-sm"><a href="/blog">Blog</a></li>
          <li class="site-search hidden-sm">            
            <a href="/search" class="hidden-xs hidden-sm hidden-md"><i class="fa fa-search hidden-xs"></i> <span class="hidden-sm hidden-md hidden-lg">Search</span></a>            
            <a href="/search" class="hidden-lg"><i class="fa fa-search hidden-xs"></i> <span class="hidden-sm hidden-md hidden-lg">Search</span></a>
          </li>
          <li class="hidden-xs hidden-sm hidden-md"><a href="/pricing/" class="btn btn-warning">Request a Meeting</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>