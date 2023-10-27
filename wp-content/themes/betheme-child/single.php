<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

get_header();
?>

<style>
.news-single-page i,
.news-single-page em {
	color: #626262 !important;
}
</style>

<div id="Content">
	<div class="content_wrapper clearfix ">

		<div class="sections_group">
			<?php
				if( is_single() && 'post' == get_post_type() ):
					$featured_image = get_the_post_thumbnail_url( get_the_id(), 'full' );
					if( empty( $featured_image ) ) {
						$featured_image = get_stylesheet_directory_uri().'/images/placeholder-image.png';
					}
					$arrow_image = get_stylesheet_directory_uri().'/images/default-news.png';
					
					echo '<div class="news-single-page container"><div class="featured-image-full-width mobile-view"><img alt="'.get_the_title().'" src="'.$featured_image.'"></div><div class="row">';
						echo '<div class="col-sm-12 col-lg-6">';
						echo '<div class="heading"><h2>'.get_the_title().'</h2><span>'.get_the_date('d F Y').'</span></div>';
							the_content();
						echo '</div>';
						echo '<div class="col-sm-12 col-lg-6">';
						echo '<div class="image-right-section"><div class="image-right"><img src="'.$arrow_image.'"></div>';
						echo '<div class="featured-image-wrap desktop-view">';
						echo '<img alt="'.get_the_title().'" src="'.$featured_image.'">';
						echo '</div></div><a class="linked-btn" href="'.site_url().'/news-events">Back to What\'s New</a>';
					echo '</div></div></div>';
					
					?>
					<div class="single-related-news ">
						<div class="row container">
							<div class="col-sm-3">
								<div class="heading">
									<h2>Related News</h2>
								</div>
							</div>
							<?php
							$related_news = get_posts( 
								array( 
									'post_type' => 'post', 
									'category__in' => wp_get_post_categories( get_the_id() ), 
									'posts_per_page' => 3, 
									'post__not_in' => array(get_the_id()) 
								) 
							);
							if( !empty( $related_news ) ) {
								foreach( $related_news as $related ) {
									?>
									<div class="col-sm-3">
										<div class="news-box">
											<a href="<?php echo get_the_permalink( $related->ID ); ?>">
												<span><?php echo get_the_date( 'd F Y', $related->ID ); ?></span>
												<h3><?php echo $related->post_title; ?></h3>
												<p><?php echo wp_trim_words( get_the_excerpt( $related->ID ), 12 ); ?></p>
											</a>
											<a href="<?php echo get_the_permalink( $related->ID ); ?>"> > </a>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
					<?php
				else:
				$is_toolset = get_post_meta( get_the_ID(), '_views_template', true );

				if ( $is_toolset || 'builder' == get_post_meta( get_the_ID(), 'mfn-post-template', true ) ) {

					// template: builder

					$single_post_nav = array(
						'hide-sticky'	=> false,
						'in-same-term' => false,
					);

					$opts_single_post_nav = mfn_opts_get('prev-next-nav');
					if (isset($opts_single_post_nav['hide-sticky'])) {
						$single_post_nav['hide-sticky'] = true;
					}

					// single post navigation | sticky

					if (! $single_post_nav['hide-sticky']) {
						if (isset($opts_single_post_nav['in-same-term'])) {
							$single_post_nav['in-same-term'] = true;
						}

						$post_prev = get_adjacent_post($single_post_nav['in-same-term'], '', true);
						$post_next = get_adjacent_post($single_post_nav['in-same-term'], '', false);

						echo mfn_post_navigation_sticky($post_prev, 'prev', 'icon-left-open-big');
						echo mfn_post_navigation_sticky($post_next, 'next', 'icon-right-open-big');
					}

					while (have_posts()) {

						the_post();

						$mfn_builder = new Mfn_Builder_Front(get_the_ID());
						$mfn_builder->show();

					}

				} else {

					// template: default

					while (have_posts()) {
						the_post();
						get_template_part('includes/content', 'single');
					}
				}
				endif;
			?>
		</div>

		<?php 
			if( is_single() && 'post' != get_post_type() ):
				get_sidebar(); 
			endif;
		?>

	</div>
</div>

<?php get_footer();
