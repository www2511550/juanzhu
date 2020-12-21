<figure class="thumbnail">
	<?php ygj_thumbnail(270,180);?>					
</figure>
<header class="entry-header">
	<h2 class="entry-title"><?php if ( is_sticky()&& is_home() ) {?><span class="sticky-icon">置顶</span><?php } ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>	
</header>
<div class="entry-content">
	<div class="archive-content">			 				
		<?php if (has_excerpt()){ echo wp_trim_words( get_the_excerpt(), 80, '...' );} elseif (post_password_required()){echo wp_trim_words( get_the_content(), 80, '...' ); }else {echo wp_trim_words( get_the_content(), 80, '...' );}?>
	</div>
<div class="entry-meta">
	<?php the_category( '/' ) ?>&nbsp;·&nbsp;<?php the_time( 'Y-m-d' ); ?>&nbsp;·&nbsp;<?php if( function_exists( 'the_views' ) ) { the_views(); print '阅读'; } ;?>		
</div>
<div class="readMore"><a href="<?php the_permalink(); ?>" target="_blank" rel="nofollow">阅读全文</a></div>
<div class="clear"></div>
</div>