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
					<?php if( function_exists( 'rank_math' ) && rank_math()->breadcrumbs ) {
					    rank_math_the_breadcrumbs();
					  } else if ($mts_options['mts_breadcrumb'] == '1') { ?>
					    <div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
					  <?php }					
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
										<?php if( $mts_options['mts_cat_button'] == '1' ){ ?>
											<div class="single-button">
												<div class="thecategory">
													<?php $category = get_the_category();
													if ($category) {
	  													echo '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
													} ?>												
												</div>
								   			</div>
								   		<?php } ?>
										<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
										<?php mts_the_postinfo( 'single' ); ?>
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

							case 'author':
								?>
								<div class="postauthor">
									<h4><?php _e('About The Author', 'ad-sense' ); ?></h4>
									<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '120' );  } ?>
									<h5 class="vcard author"><a href="/about" class="fn" target="_blank" rel="noopener"><?php the_author_meta( 'display_name' ); ?></a></h5>
									<p><?php the_author_meta('description') ?></p>
									<?php
										$userID = $post->post_author;
										$facebook = get_the_author_meta( 'facebook', $userID );
										$twitter = get_the_author_meta( 'twitter', $userID );
										$google = get_the_author_meta( 'googleplus', $userID );
										$pinterest = get_the_author_meta( 'pinterest', $userID );
										$stumbleupon = get_the_author_meta( 'stumbleupon', $userID );
										$linkedin = get_the_author_meta( 'linkedin', $userID );

										echo '<div class="author-badge">';
											echo '<a href="https://www.youracclaim.com/badges/fae5549d-02a6-44ca-92d6-e8d7b75dc59d" class="general" target="_blank" rel="noopener"><img src="https://www.agussuhanto.net/img/2019/01/Project-Management-Professional-Agus-Suhanto-50x50px.png" title="Project Management Professional (PMP®)" /></a>';
											echo '<a href="https://www.youracclaim.com/badges/25770246-ed61-416d-b34b-f4507be0ec1f" class="general" target="_blank" rel="noopener"><img src="https://www.agussuhanto.net/img/2019/01/MCT-2019-2020-Agus-Suhanto-50x50px.png" title="Microsoft Certified Trainer (MCT®)" /></a>';
											echo '<a href="https://www.youracclaim.com/badges/27c77be2-cef1-4b03-befd-6c8317180686" class="general" target="_blank" rel="noopener"><img src="https://www.agussuhanto.net/img/2019/01/MCSE-Cloud-Platform-Infrastructure-2018-Agus-Suhanto-50x50px.png" title="MCSE Cloud Platform and Infrastructure" /></a>';
											echo '<a href="https://www.youracclaim.com/badges/6db055f9-1671-47df-9c7c-9ada4fc56110" class="general" target="_blank" rel="noopener"><img src="https://www.agussuhanto.net/img/2019/01/MCSD-App-Builder-2018-Agus-Suhanto-50x50px.png" title="MCSD App Builder" /></a>';
										echo '</div>';

										if(!empty($facebook) || !empty($twitter) || !empty($google) || !empty($pinterest) || !empty($stumbleupon) || !empty($linkedin)){
											echo '<div class="author-social">';
												if(!empty($facebook)){
													echo '<a href="'.$facebook.'" class="facebook"><i class="fa fa-facebook"></i></a>';
												}
												if(!empty($twitter)){
													echo '<a href="'.$twitter.'" class="twitter"><i class="fa fa-twitter"></i></a>';
												}
												if(!empty($google)){
													echo '<a href="'.$google.'" class="google-plus"><i class="fa fa-google-plus"></i></a>';
												}
												if(!empty($pinterest)){
													echo '<a href="'.$pinterest.'" class="pinterest"><i class="fa fa-pinterest"></i></a>';
												}
												if(!empty($stumbleupon)){
													echo '<a href="'.$stumbleupon.'" class="stumble"><i class="fa fa-stumbleupon"></i></a>';
												}
												if(!empty($linkedin)){
													echo '<a href="'.$linkedin.'" class="linkedin"><i class="fa fa-linkedin"></i></a>';
												}
											echo '</div>';
										}
									?>
								</div>
								<?php
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
