<footer> 
<?php wp_reset_query();if ( is_home()&&!is_paged()){ ?>	
		<div id="links">
			<ul class="linkcat">
				<li><strong>友情链接：</strong></li>
				<?php
				wp_list_bookmarks('title_li=&categorize=0&orderby=rand&show_images=&limit=30&category='.get_option('ygj_link_id'));	
				?>
			</ul>
<div class="clear"></div>
</div>
<?php } ?>
<div class="footerbox"> <p>Copyright ©&nbsp; <?php bloginfo('name');?>&nbsp;·&nbsp;Powered by <a href="http://wordpress.org/" title="优雅的个人发布平台" target="_blank" rel="nofollow noopener">WordPress</a>&nbsp;·&nbsp; Theme by <a title="免费响应式博客主题JianYue V1.2版本" href="http://yigujin.wang/post/102.html" target="_blank">JianYue</a><?php if(get_option('ygj_icp')){?>&nbsp;·&nbsp;<a href="http://www.beian.miit.gov.cn" target="_blank" rel="nofollow noopener"><?php echo stripslashes(get_option('ygj_icp')); ?></a><?php }if(get_option('ygj_ggicp')){?>&nbsp;·&nbsp;<a target="_blank" href="https://boke112.com/goto/beian" rel="nofollow noopener"><img src="https://boke.yigujin.cn/wp-content/themes/Three/images/160421_hui.png" style="margin-bottom:-4px;"><span style="height:20px;line-height:20px;">&nbsp;<?php echo stripslashes(get_option('ygj_icp')); ?></span></a><?php }?></p></div> 
</footer>
<a title="返回顶部" id="BackToTop" href="" style="display: none;"><span>^ 回到顶部</span></a>
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/prettify.js"></script>
<?php wp_footer(); ?>
</body></html>