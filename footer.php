<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php $footer_heading = themes_option('footer_heading'); ?><?php if ($footer_heading !== '') { ?>
					<div class="col-sm-2">
						<div class="companyinfo">
							<?php echo themes_option('footer_heading'); ?>
						</div>
					</div>
					<?php } ?>
					<div class="col-sm-7">
						<?php global $themes_option; foreach($themes_option['footer_slide'] as $footer_slide) {
					
						 echo '<div class="col-sm-3">';
							echo '<div class="video-gallery text-center">';
								echo '<a href="' . $footer_slide['url'] . '">';
									echo '<div class="iframe-img">';
										echo '<img src="' . $footer_slide['image'] . '" alt="" />';
									echo '</div>';
									echo '<div class="overlay-icon">';
										echo '<i class="fa fa-play-circle-o"></i>';
									echo '</div>';
								echo '</a>';
								echo '<p>' . $footer_slide['title'] . '</p>';
								echo '<h2>' . $footer_slide['description'] . '</h2>';
							echo '</div>';
						echo '</div>'; 
						 } ?>
						
					</div>
					<?php $footer_map = themes_option('footer_map'); ?><?php if ($footer_map !== '') { ?>
					<div class="col-sm-3">
						<div class="address">
							<img src="<?php bloginfo('template_directory'); ?>/images/home/map.png" alt="" />
							<p><?php echo themes_option('footer_map'); ?></p>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
						<?php endif; ?>
					</div>
					<div class="col-sm-3">
						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<?php dynamic_sidebar( 'footer-2' ); ?>
						<?php endif; ?>
					</div>
					<div class="col-sm-3">
						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<?php dynamic_sidebar( 'footer-3' ); ?>
						<?php endif; ?>
					</div>
					<div class="col-sm-3">
						<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<?php dynamic_sidebar( 'footer-4' ); ?>
						<?php endif; ?>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left"><?php $custom_copyright = themes_option('custom_copyright'); ?><?php if ($custom_copyright !== '') { ?><?php echo themes_option('custom_copyright'); ?><?php } else { ?>Copyright © 2013 E-SHOPPER Inc. All rights reserved.<?php } ?></p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
<?php global $woocommerce; ?>
<?php
$my_cart_count = $woocommerce->cart->cart_contents_count;
if ($my_cart_count > 0) :
?>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/favico.min.js?ver=0.3.7" type="text/javascript"></script>
	<script type="text/javascript">
		var favicon=new Favico({
		animation:'pop'
		});
		favicon.badge(<?php echo $my_cart_count; ?>);
	</script>
<?php
endif;
?>
<script type="text/javascript">
jQuery( document ).ready(function() {
    jQuery('.widget_meta > ul').addClass('nav nav-pills nav-stacked');
    jQuery('.widget_recent_entries > ul').addClass('nav nav-pills nav-stacked');
    jQuery('.widget_archive > ul').addClass('nav nav-pills nav-stacked');
    jQuery('.widget_categories > ul').addClass('nav nav-pills nav-stacked');
    jQuery('.textwidget > ul').addClass('nav nav-pills nav-stacked');
});
</script>
<?php wp_footer(); ?>

</body>
</html>
