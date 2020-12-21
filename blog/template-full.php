<?php
/*
Template Name: 全屏页面模板
*/
?>
<?php get_header();?>
<style type="text/css">.page-template-template-full #primary{width: 100%}</style>
<div id="content" class="site-content">	
<div class="clear"></div>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php while ( have_posts() ) : the_post(); ?>
			
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>	
						<div class="single_info"><?php the_time( 'Y/m/d H:i' ); ?>&nbsp;·&nbsp;<?php if( function_exists( 'the_views' ) ) { the_views(); print '阅读'; } ;?>&nbsp;·&nbsp;<?php comments_popup_link( '0评论', '1评论', '%评论' ); ?><?php edit_post_link('&nbsp;·&nbsp;编辑', '  ', '  '); ?>
						</div>			
	</header><!-- .entry-header -->

	<div class="entry-content">
					<div class="single-content">									
	<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span><i class="dashicons dashicons-arrow-left-alt2"></i></span>', 'nextpagelink' => "")); ?>
		<?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
		<?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => '<span><i class="dashicons dashicons-arrow-right-alt2"></i></span>')); ?>		
	</div>
<div class="clear"></div>
						<?php get_template_part('inc/file'); ?>
				<div class="clear"></div>
	</div><!-- .entry-content -->

	</article><!-- #post -->	
	<?php comments_template( '', true ); ?>			
			<?php endwhile; ?>
		</main><!-- .site-main -->
	</div><!-- .content-area -->
<div class="clear"></div>
</div><!-- .site-content -->
<?php get_footer();?>