<?php 
// 最新文章
class newt_post_Widget extends WP_Widget {
	function __construct(){
		parent::__construct( 'newt_post_Widget', '主题&nbsp;&nbsp;最新文章', array('description' => '主题自带的最新文章小工具') );
	}
     function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
?>
<div class="new_cat" id="new_cat">
	<ul>
		<?php query_posts( array ( 'showposts' => $number, 'ignore_sticky_posts' => 1 ) );$i = 1; while ( have_posts() ) : the_post(); ?>
			<li class="clr">
			<a href="<?php the_permalink(); ?>"  title="<?php the_title(); ?>" target="_blank">
			<div class="time">
                <span class="r"><?php the_time('d') ?></span>/
                <span class="y"><?php the_time('m月') ?></span> 
            </div>
			 <div class="title"><?php the_title(); ?></div>
	</a>	</li>
		<?php endwhile;?>	
	</ul>
</div>	
<script>
        $(function () {
            $(".clr").mouseover(function () {
                $(this).addClass('hov');
            }).mouseleave(function () {
                $(this).removeClass('hov');
            });

        })
    </script>
<div class="clear"></div>
<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '最新文章';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '5'));
		$number = strip_tags($instance['number']);
?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}

// 近期评论
class recent_comments_Widget extends WP_Widget {
	function __construct(){
		parent::__construct('recent_comments_Widget', '主题&nbsp;&nbsp;近期评论',array('description' => '主题自带的近期评论小工具'));
	}
     function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
?>
<div id="related-medias">
<ul class="media-list"> 
<?php
		$show_comments = $number;
		$my_email = get_bloginfo ('admin_email');
		$i = 1;
		$comments = get_comments('number=200&status=approve&type=comment');
		foreach ($comments as $my_comment) {
			if ($my_comment->comment_author_email != $my_email) {
				?>
<li class="item"><a class="y-left img-wrap" rel="nofollow" target="_blank" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo my_avatar( $my_comment->comment_author_email,56,$default='',$my_comment->comment_author); ?></a> <div class="media-info"> <div class="media-inner"> <a rel="nofollow" target="_blank" class="media-name" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo $my_comment->comment_author; ?></a><p class="media-des"><a rel="nofollow" target="_blank" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo convert_smilies($my_comment->comment_content); ?></a></p> </div> </div> </li>
<?php
				if ($i == $show_comments) break;
				$i++;
			}
		}
		?>
</ul>
</div>
<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '近期评论';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '5'));
		$number = strip_tags($instance['number']);
?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
if (!function_exists('JianYue_blog_load_widgets')) :
    function JianYue_blog_load_widgets()
    {
        register_widget('newt_post_Widget');
        register_widget('recent_comments_Widget');
    }
endif;
add_action('widgets_init', 'JianYue_blog_load_widgets');
