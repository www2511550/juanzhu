<div id="post-navigation">
	<?php  
	$categories = get_the_category();  
	$categoryIDS = array();  
	foreach ($categories as $category) {  
		array_push($categoryIDS, $category->term_id);  
	}  
	$categoryIDS = implode(",", $categoryIDS); ?>  
<?php if (get_previous_post($categoryIDS)) { ?>
<div class="post-previous"><strong>上一篇：</strong>
<?php previous_post_link('%link','%title',true,'');?>
</div>
<?php } ?> 
<?php if (get_next_post($categoryIDS)) { ?>
<div class="post-next"><strong>下一篇：</strong>
<?php next_post_link('%link','%title',true,'');?>
</div>
<?php } ?> 
</div>