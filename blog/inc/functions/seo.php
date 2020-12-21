<?php if ( is_home() ) { ?><title><?php bloginfo('name'); ?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('description'); ?><?php if (get_query_var('paged')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('paged'); echo '页';}?></title><?php } ?>
<?php if ( is_search() ) { ?><title>搜索结果<?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php if ( is_category() ) { 
$cat_ID = get_query_var('cat'); 
if ( get_option( 'cat-title-'.$cat_ID  )) : ?>
<title><?php echo get_option( 'cat-title-'.$cat_ID ); ?><?php if (get_query_var('paged')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('paged'); echo '页';}?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<?php else: ?>
<title><?php single_cat_title(); ?><?php if (get_query_var('paged')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('paged'); echo '页';}?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<?php endif; }?>
<?php if ( is_tag() ) { 
$term_id = get_query_var('tag_id');
if ( get_option( 'tag-title-'.$term_id )) : ?>
<title><?php echo get_option( 'tag-title-'.$term_id ); ?><?php if (get_query_var('paged')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('paged'); echo '页';}?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<?php else: ?>
<title><?php  single_tag_title("", true); ?><?php if (get_query_var('paged')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('paged'); echo '页';}?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<?php endif; }?>
<?php if ( is_year() ) { ?><title><?php the_time('Y年'); ?>所有文章<?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php if ( is_month() ) { ?><title><?php the_time('F'); ?>份所有文章<?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php if ( is_day() ) { ?><title><?php the_time('Y年n月j日'); ?>所有文章<?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php if ( is_404() ) { ?><title>亲，你迷路了！<?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php if ( is_tax('notice') ) { ?><title><?php setTitle(); ?> <?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title><?php } ?>
<?php
if (!function_exists('utf8Substr')) {
 function utf8Substr($str, $from, $len)
 {
     return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
          '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
          '$1',$str);
 }
}
if ( is_single() ){
    if ($post->post_excerpt) {
        $description  = $post->post_excerpt;
    } else {
   if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
    $post_content = $result['1'];
   } else {
    $post_content_r = explode("\n",trim(strip_tags($post->post_content)));
    $post_content = $post_content_r['0'];
   }
         $description = utf8Substr($post_content,0,220);
  } 
    $keywords = "";
    $tags = wp_get_post_tags($post->ID);
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ",";
    }
 date_default_timezone_set('PRC');
if(get_post_meta($post->ID, 'wzzz', true)){$copy = get_post_meta($post->ID, 'wzzz', true);}else{ $copy = get_the_author_meta( 'display_name',$post->post_author);}?>
<title><?php echo trim(wp_title('',0)); ?><?php if (get_query_var('page')) { echo stripslashes(get_option('ygj_lianjiefu'));echo '第'; echo get_query_var('page'); echo '页';}?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<?php if ( get_post_meta($post->ID, 'description', true) ) : ?>
<meta name="description" content="<?php $description = get_post_meta($post->ID, 'description', true);{echo $description;}?>" />
<?php else: ?>
<meta name="description" content="<?php echo trim($description); ?>" />
<?php endif; ?>
<?php if ( get_post_meta($post->ID, 'keywords', true) ) : ?>
<meta name="keywords" content="<?php $keywords = get_post_meta($post->ID, 'keywords', true);{echo $keywords;}?>" />
<?php else: ?>
<meta name="keywords" content="<?php echo trim($keywords,','); ?>,<?php foreach((get_the_category()) as $category){echo $category->cat_name;}?>" />
<?php endif; ?>
<meta itemprop="dateUpdate" content="<?php the_modified_time('Y-m-d G:i:s');?>" />
<meta itemprop="datePublished" content="<?php the_time( 'Y-m-d H:i:s' );?>" />
<meta name="image" content="<?php echo ygj_thumbnaillink(); ?>">
<meta property="og:title" content="<?php echo trim(wp_title('',0)); ?>" />
<meta property="og:site_name" content="<?php bloginfo('name');?>"/>
<meta property="og:url" content="<?php the_permalink() ?>" />
<meta property="og:type" content="article" />
<?php if ( get_post_meta($post->ID, 'description', true) ) : ?>
<meta property="og:description" content="<?php $description = get_post_meta($post->ID, 'description', true);{echo $description;}?>" />
<?php else: ?>
<meta property="og:description" content="<?php echo trim($description); ?>" />
<?php endif; ?>
<meta property="og:image" content="<?php echo ygj_thumbnaillink(); ?>" />
<meta property="og:release_date" content="<?php the_time( 'Y-m-d H:i:s' );?>"/>
<meta property="article:published_time" content="<?php echo get_the_date('c');?>" />
<meta property="article:published_first" content="<?php bloginfo('name');?><?php echo ',';the_permalink();?>" />
<meta property="article:author" content="<?php echo $copy; ?>" />
<?php } ?>
<?php if ( is_page() ) { date_default_timezone_set('PRC');?>
<title><?php echo trim(wp_title('',0)); ?><?php echo stripslashes(get_option('ygj_lianjiefu')); ?><?php bloginfo('name'); ?></title>
<meta name="description" content="<?php $description = get_post_meta($post->ID, 'description', true);{echo $description;}?>" />
<meta name="keywords" content="<?php $keywords = get_post_meta($post->ID, 'keywords', true);{echo $keywords;}?>" />
<meta property="og:type" content="article"/>
<meta itemprop="dateUpdate" content="<?php the_modified_time('Y-m-d G:i:s');?>" />
<meta property="article:published_time" content="<?php echo get_the_date('c');?>"/>
<meta property="article:author" content="<?php echo get_the_author_meta( 'display_name',$post->post_author); ?>" />
<meta property="og:site_name" content="<?php bloginfo('name');?>"/>
<meta property="article:published_first" content="<?php bloginfo('name');?><?php echo ',';the_permalink();?>" />
<meta property="og:image" content="<?php echo ygj_thumbnaillink(); ?>" />
<meta property="og:release_date" content="<?php echo get_the_date('c');?>"/>
<meta property="og:title" content="<?php echo trim(wp_title('',0)); ?>" />
<meta property="og:description" content="<?php $description = get_post_meta($post->ID, 'description', true);{echo $description;}?>" />
<?php } ?>
<?php if ( is_category() ) { $cat_ID = get_query_var('cat');?>
<meta name="description" content="<?php echo category_description($cat_ID); ?>" />
<?php if ( get_option( 'cat-words-'.$cat_ID )) : ?>
<meta name="keywords" content="<?php echo get_option( 'cat-words-'.$cat_ID ); ?>" />
<?php else: ?>
<meta name="keywords" content="<?php single_cat_title(); ?>" />
<?php endif; ?>
<?php } ?>
<?php if ( is_tag() ) { $tag_description=tag_description();?>
<?php if ( empty($tag_description)) : ?>
<meta name="description" content="『<?php echo single_tag_title(); ?>』标签的相关文章" />
<?php else: ?>
<meta name="description" content="<?php echo trim(strip_tags(tag_description())); ?>" />
<?php endif; ?>
<?php if ( get_option( 'tag-words-'.$term_id )) : ?>
<meta name="keywords" content="<?php echo get_option( 'tag-words-'.$term_id ); ?>" />
<?php else: ?>
<meta name="keywords" content="<?php echo single_tag_title(); ?>" />
<?php endif; ?>
<?php } ?>
<?php if ( is_home() ) { ?>
<meta name="description" content="<?php echo get_option('ygj_description'); ?>" />
<meta name="keywords" content="<?php echo get_option('ygj_keywords'); ?>" />
<?php } ?>