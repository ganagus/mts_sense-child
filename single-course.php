<?php
/**
 * The template for displaying all single posts.
 */
?>
<?php get_header(); ?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<div id="page" class="<?php mts_single_page_class(); ?>">
	
	<?php $header_animation = mts_get_post_header_effect(); ?>
	<?php if ( 'parallax' === $header_animation ) {?>
		<?php if (mts_get_thumbnail_url()) : ?>
			<div id="parallax" <?php echo 'style="background-image: url('.mts_get_thumbnail_url().');"'; ?>></div>
		<?php endif; ?>
	<?php } else if ( 'zoomout' === $header_animation ) {?>
		 <?php if (mts_get_thumbnail_url()) : ?>
			<div id="zoom-out-effect"><div id="zoom-out-bg" <?php echo 'style="background-image: url('.mts_get_thumbnail_url().');"'; ?>></div></div>
		<?php endif; ?>
	<?php } ?>

	<article class="<?php mts_article_class(); ?>">
		<div id="content_box" >
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
					<?php
					// Single post parts ordering
					if ( isset( $mts_options['mts_single_post_layout'] ) && is_array( $mts_options['mts_single_post_layout'] ) && array_key_exists( 'enabled', $mts_options['mts_single_post_layout'] ) ) {
						$single_post_parts = $mts_options['mts_single_post_layout']['enabled'];
					} else {
						$single_post_parts = array( 'content' => 'content', 'related' => 'related', 'author' => 'author' );
					}
					foreach( $single_post_parts as $part => $label ) { 
						switch ($part) {
							case 'content':
								?>
								<div class="single_post">
									<header>
										<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
									</header><!--.headline_area-->

									<?php if (isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] == 'top') mts_social_buttons(); ?>
									
									<div class="post-single-content box mark-links entry-content">

										<?php if($mts_options['mts_detect_adblocker'] && $mts_options['mts_detect_adblocker_type'] == 'hide-content') {
											echo detect_adblocker_notice();
										} ?>

										<div class="<?php if($mts_options['mts_detect_adblocker'] && $mts_options['mts_detect_adblocker_type'] == 'hide-content') echo 'thecontent'; ?> clear">
											<?php if ($mts_options['mts_posttop'] && $mts_options['mts_posttop_adcode']) { ?>
												<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
													<div class="topad <?php echo $mts_options['mts_posttop_ad_position']; ?>">
														<?php echo do_shortcode($mts_options['mts_posttop_adcode']); ?>
													</div>
												<?php } ?>
											<?php } ?>
											<?php the_content(); ?>
											<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="currenttext">', 'link_after' => '</span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => '<i class="fa fa-angle-right"></i>', 'previouspagelink' => '<i class="fa fa-angle-left"></i>', 'pagelink' => '%','echo' => 1 )); ?>
										</div>

										<?php if ($mts_options['mts_postend'] && $mts_options['mts_postend_adcode']) { ?>
											<?php $endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
												<div class="bottomad <?php echo $mts_options['mts_postend_ad_position']; ?>">
													<?php echo do_shortcode($mts_options['mts_postend_adcode']); ?>
												</div>
											<?php } ?>
										<?php } ?>

										<?php if (isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] !== 'top') mts_social_buttons(); ?>

										<div class="pagination">
											<div class="nav-previous"><?php previous_post_link('%link', '<i class="fa fa-angle-left"></i> '. __( 'Prev Article', 'ad-sense' ), TRUE); ?></div>
											<div class="nav-next"><?php next_post_link('%link', __( 'Next Article', 'ad-sense' ).' <i class="fa fa-angle-right"></i>', TRUE); ?></div>
										</div>
									</div><!--.post-single-content-->
								</div><!--.single_post-->
								<?php
							break;

							case 'tags':
								?>
								<?php mts_the_tags('<div class="tags"><span class="tagtext">'.__('Tags', 'ad-sense' ).':</span>') ?>
								<?php
							break;

							case 'related':
								mts_related_posts();
							break;
						}
					}
					?>
				</div><!--.g post-->
				<?php comments_template( '', true ); ?>
			<?php endwhile; /* end loop */ ?>
		</div>
	</article>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
