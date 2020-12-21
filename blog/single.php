<?php get_header();?>
<div id="content" class="site-content">	
	<div class="clear"></div>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
			<?php if(get_post_meta($post->ID, 'wzurl', true)){$wzurl = get_post_meta($post->ID, 'wzurl', true);}else{$wzurl=get_the_permalink();}?>
			<?php if(get_post_meta($post->ID, 'wzzz', true)){$wzzz = get_post_meta($post->ID, 'wzzz', true);}else{$wzzz=get_the_author();}?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="single_info"><?php the_time( 'Y/m/d H:i' ); ?>&nbsp;·&nbsp;<?php the_category( '/' ) ?>&nbsp;·&nbsp;<?php if (get_option('ygj_post_wzlx') ) { ?>
					<?php if ( get_post_meta($post->ID, 'tgwz', true) ) { ?>投稿文章<?php } elseif ( get_post_meta($post->ID, 'zzwz', true) ) { ?>转载文章<?php }else{?>原创文章<?php } ?>&nbsp;·&nbsp;<?php }if( function_exists( 'the_views' ) ) { the_views(); print '阅读'; } ;?>&nbsp;·&nbsp;<?php comments_popup_link( '0评论', '1评论', '%评论' ); ?><?php edit_post_link('&nbsp;·&nbsp;编辑', '  ', '  '); ?>
						</div>		
					</header><!-- .entry-header -->
					<?php if (get_option('ygj_g_single') == '显示') { get_template_part('/inc/ad/ad_single'); } ?>
					<?php if ( has_excerpt() ) { ?>
						<span class="abstract"><strong>摘要：</strong><?php the_excerpt() ?></span>
					<?php } ?>
					<div class="entry-content">
						<div class="single-content">			
							<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span><i class="dashicons dashicons-arrow-left-alt2"></i></span>', 'nextpagelink' => "")); ?>
		<?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
		<?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => '<span><i class="dashicons dashicons-arrow-right-alt2"></i></span>')); ?>		
						<?php if (get_option('ygj_gxqdwz') ) { include('inc/realted_post.php');}?>
						</div>
						<div class="clear"></div>
							<div class="single_banquan">	
								<strong>本文地址：</strong><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"  target="_blank"><?php the_permalink() ?></a><br/>
								<strong>文章标签：</strong><?php the_tags('','&nbsp;,&nbsp;&nbsp;',''); ?><br/>
								<?php if ( get_post_meta($post->ID, 'tgwz', true) ) : ?>
									<strong>温馨提示：</strong>文章内容系作者个人观点，不代表<?php bloginfo('name'); ?>对观点赞同或支持。<br/>
									<strong>版权声明：</strong>本文为投稿文章，感谢&nbsp;<a href="<?php echo $wzurl; ?>" target="_blank" rel="nofollow"><?php echo $wzzz; ?></a>&nbsp;的投稿，版权归原作者所有，欢迎分享本文，转载请保留出处！
								<?php elseif ( get_post_meta($post->ID, 'zzwz', true) ) : ?>
									<strong>温馨提示：</strong>文章内容系作者个人观点，不代表<?php bloginfo('name'); ?>对观点赞同或支持。<br/>
									<strong>版权声明：</strong>本文为转载文章，来源于&nbsp;<a href="<?php echo $wzurl; ?>" target="_blank" rel="nofollow"><?php echo $wzzz; ?></a>&nbsp;，版权归原作者所有，欢迎分享本文，转载请保留出处！
								<?php else:  ?>
									<strong>版权声明：</strong>本文为原创文章，版权归&nbsp;<a href="<?php echo $wzurl; ?>" target="_blank"><?php echo $wzzz; ?></a>&nbsp;所有，欢迎分享本文，转载请保留出处！
								<?php endif; ?>
							</div>
						<?php get_template_part('inc/file'); ?>
						<div class="clear"></div>
						<?php include('inc/prenext_post.php');?>
					</div><!-- .entry-content -->
				</article><!-- #post -->					
					<?php if (get_option('ygj_g_comment') == '显示') { get_template_part( 'inc/ad/ad_comment' ); } ?>
				<?php comments_template( '', true ); ?>			
			<?php wp_reset_query();endwhile; ?>
		</main><!-- .site-main -->
	</div><!-- .content-area -->
	<?php get_sidebar();?>
	<div class="clear"></div>
</div><!-- .site-content -->
<?php get_footer();?>