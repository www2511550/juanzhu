<h2>您可能感兴趣的文章</h2>
<ul>
   <?php
$abctag='';$abctag=get_the_tag_list( '',',','' );
$post_num = get_option('ygj_related_count');
$exclude_id = $post->ID;
$abctag="'$abctag'";
$i = 0;
	$argsa = array(
		'post_status' => 'publish',
		'tag_slug__in' => explode(',', $abctag),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => rand,
		'showposts' => $post_num,
	);
	$my_querywtaga = new WP_Query($argsa);
    if( $my_querywtaga->have_posts() ) {
    while ($my_querywtaga->have_posts()) : $my_querywtaga->the_post();?>
	<li><a href="<?php the_permalink(); ?>" target="_blank" rel="noopener"><?php the_title(); ?></a></li>
	<?php
	$exclude_id .= ',' . $post->ID; $i++;
	endwhile;wp_reset_query();}

if ( $i < $post_num ) {
	$cats = '';$post_num -= $i;
    foreach (get_the_category() as $cat) $cats.= $cat->cat_ID . ',';
	$argsb = array(
		'category__in' => explode(',', $cats),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => rand,
		'showposts' => $post_num
	);	
	$my_querywtagb = new WP_Query($argsb);
    if( $my_querywtagb->have_posts() ) {
        while ($my_querywtagb->have_posts()) : $my_querywtagb->the_post();?>
		<li><a href="<?php the_permalink(); ?>" target="_blank" rel="noopener"><?php the_title(); ?></a></li>
	<?php $i++;endwhile;wp_reset_query();}}?> 
</ul>