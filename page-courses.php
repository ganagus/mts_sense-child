<?php
/**
 * The template for displaying all pages.
 *
 * Other pages can use a different template by creating a file following any of these format:
 * - page-$slug.php
 * - page-$id.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page" class="page-featured-default post-type-index">
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
					<div class="single_page">
						<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
							<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
						<?php } ?>
						<header>
							<h1 class="title entry-title"><?php the_title(); ?></h1>
						</header>
						<div class="post-single-content box mark-links entry-content">

							<?php if($mts_options['mts_detect_adblocker'] && $mts_options['mts_detect_adblocker_type'] == 'hide-content') {
								echo detect_adblocker_notice();
							} ?>

							<?php if (!empty($mts_options['mts_social_buttons_on_pages']) && isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] == 'top') mts_social_buttons(); ?>

							<div class="<?php if($mts_options['mts_detect_adblocker'] && $mts_options['mts_detect_adblocker_type'] == 'hide-content') echo 'thecontent'; ?>">
								<?php the_content(); ?>
                                <div class="content_wrap">
                                    <?php 
                                    $args = array( 'post_type' => 'course', 'posts_per_page' => 10 );
                                    $the_query = new WP_Query( $args ); ?>
                                    <?php if ( $the_query->have_posts() ) : ?>
                                        <?php $j = 0; while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                            <article class="latestPost excerpt <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>">
                                                <?php mts_archive_post(); ?>
                                            </article>
                                        <?php endwhile; ?>
                                        <?php wp_reset_postdata(); ?>
                                    <?php endif; ?>
                                </div>
								<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next', 'ad-sense' ), 'previouspagelink' => __('Previous', 'ad-sense' ), 'pagelink' => '%','echo' => 1 )); ?>
							</div>
							<?php if (!empty($mts_options['mts_social_buttons_on_pages']) && isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] !== 'top') mts_social_buttons(); ?>
						</div><!--.post-content box mark-links-->
					</div>
				</div>
				<?php comments_template( '', true ); ?>
			<?php endwhile; ?>
		</div>
	</article>
<?php get_footer(); ?>