<div id="sidebar" class="widget-area">			
	<?php wp_reset_query();if (is_single() || is_page() ) { dynamic_sidebar( 'sidebar-2' ); }else { dynamic_sidebar( 'sidebar-1' ); } ?>
</div>