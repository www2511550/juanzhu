<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="renderer" content="webkit">
<meta name="applicable-device" content="pc,mobile">
<meta name="HandheldFriendly" content="true"/>
<?php get_template_part( 'inc/functions/seo' ); ?>
<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicon.ico">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicon.png">
<link rel="profile" href="http://gmpg.org/xfn/11">
<!--[if lt IE 9]><script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5-css3.js"></script><![endif]-->
<link rel="stylesheet" id="nfgc-main-style-css" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all">
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-min.js"></script>
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/stickySidebar.js"></script>
<?php if (is_home() ) { ?>
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/slides.js"></script>
<?php } ?>
<?php if (get_option('ygj_bdtjdm')) { ?>
<?php echo stripslashes(get_option('ygj_bdtjdm')); ?>
<?php } ?>
<!--[if IE]>
<div class="tixing"><strong>温馨提示：感谢您访问本站，经检测您使用的浏览器为IE浏览器，为了获得更好的浏览体验，请使用Chrome、Firefox或其他浏览器。</strong>
</div>
<![endif]-->
<link rel="stylesheet" id="dashicons-css" href="<?php echo esc_url( home_url() ); ?>/wp-includes/css/dashicons.css" type='text/css' media='all'/>
<?php wp_head(); ?>
</head>
<body <?php if ( !is_author() ){ body_class();} ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header">
	<nav id="top-header">
		<div class="top-nav">
			<div id="huanying">
				您好，欢迎访问<?php bloginfo('name'); ?>&nbsp;&nbsp;|&nbsp;<a href="<?php echo esc_url( home_url() ); ?>/wp-admin" target="_blank">登录</a>
			</div>	
		<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_class' => 'top-menu', 'fallback_cb' => 'default_menu' ) ); ?>
		</div>
	</nav><!-- #top-header -->
	<div id="menu-box">
		<div id="top-menu">
			<?php get_template_part( 'inc/logo' ); ?>
			<span class="nav-search"><span class="dashicons dashicons-search"></span></span>
			<div id="site-nav-wrap">
				<div id="sidr-close"><a href="<?php echo esc_url( home_url() ); ?>/#sidr-close" class="toggle-sidr-close">X</a>
			</div>
			
			<nav id="site-nav" class="main-nav">
				<a href="#sidr-main" id="navigation-toggle" class="bars"><span class="dashicons dashicons-menu-alt"></span></a>	
				<?php if ( wp_is_mobile() ) { wp_nav_menu( array( 'theme_location' => 'mini-menu','menu_class' => 'down-menu nav-menu', 'fallback_cb' => 'default_menu' ) ); }else { wp_nav_menu( array( 'theme_location' => 'header-menu','menu_class' => 'down-menu nav-menu', 'fallback_cb' => 'default_menu' ) ); } ?>				
			</nav>	
			</div><!-- #site-nav-wrap -->
		</div><!-- #top-menu -->
	</div><!-- #menu-box -->
</header><!-- #masthead -->

<div id="main-search">
	<?php get_search_form(); ?>		
	<div class="clear"></div>
</div>
<?php if (!is_home()) {the_crumbs(); }?>