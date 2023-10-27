<?php
/**
 * The search template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

get_header();

$translate['search-title'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-title','Ooops...') : __('Ooops...','betheme');
$translate['search-subtitle'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-subtitle','No results found for:') : __('No results found for:','betheme');

$translate['published']	= mfn_opts_get('translate') ? mfn_opts_get('translate-published','Published by') : __('Published by','betheme');
$translate['at'] = mfn_opts_get('translate') ? mfn_opts_get('translate-at','at') : __('at','betheme');
$translate['readmore'] = mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');
?>

<div class="banner-arrows" style="background-image: url('/wp-content/uploads/2021/05/about-banner.jpg')">
	<div class="banner-padding">
		<div class="banner-content" style="max-width: 370px;">
			<div class="page-info">
				<h2 class="white">Search</h2>
				<p>Find what you're looking for at Kaman</p>
			</div>
			<div class="arrows">
				<img data-src="/wp-content/uploads/2022/01/corner-top-1.png" class="corner-top lazyloaded" src="/wp-content/uploads/2022/01/corner-top-1.png"><noscript><img class="corner-top" src="/wp-content/uploads/2022/01/corner-top-1.png" /></noscript>
				<img data-src="/wp-content/uploads/2022/01/corner-bottom-1.png" class="corner-bottom lazyloaded" src="/wp-content/uploads/2022/01/corner-bottom-1.png"><noscript><img class="corner-bottom" src="/wp-content/uploads/2022/01/corner-bottom-1.png" /></noscript>
			</div>
		</div>
	</div>
</div>

<div id="Content">
	<div class="content_wrapper clearfix">

		<div class="sections_group">

			<div class="section">
				<div class="section_wrapper clearfix">

					<?php if( have_posts() && trim( $_GET['s'] ) ): ?>

						<div class="column one column_blog">
							<div class="blog_wrapper isotope_wrapper">

								<div class="posts_group classic">
									<?php
										while ( have_posts() ):
											the_post();
									?>
										<div id="post-<?php the_ID(); ?>" <?php post_class( array('post-item', 'clearfix', 'no-img') ); ?>>

											<div class="post-desc-wrapper">
												<div class="post-desc">

													<?php if( mfn_opts_get( 'blog-meta' ) ): ?>
														<div class="post-meta clearfix">
															<div class="author-date">
																<? /*<span class="author"><span><?php echo esc_html($translate['published']); ?> </span><i class="icon-user"></i> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author_meta('display_name'); ?></a></span>
																<span class="date"><?php echo esc_html(get_the_date()); ?></span> */ ?>
															</div>
														</div>
													<?php endif; ?>

													<div class="post-title">
														<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													</div>

													<div class="post-excerpt">
														<?php the_excerpt(); ?>
													</div>

													<div class="post-footer">
														<div class="post-links">
															<a href="<?php the_permalink(); ?>" class="post-more"><?php echo esc_html($translate['readmore']); ?></a>
														</div>
													</div>

												</div>
											</div>
										</div>
									<?php
										endwhile;
									?>
								</div>

								<?php
									if(function_exists( 'mfn_pagination' )):
										echo mfn_pagination();
									else:
										?>
											<div class="nav-next"><?php next_posts_link(esc_html__('&larr; Older Entries', 'betheme')) ?></div>
											<div class="nav-previous"><?php previous_posts_link(esc_html__('Newer Entries &rarr;', 'betheme')) ?></div>
										<?php
									endif;
								?>

							</div>
						</div>

					<?php else: ?>

						<div class="column one search-not-found">

							<div class="snf-pic">
								<i class="themecolor <?php echo esc_attr(mfn_opts_get('error404-icon', 'icon-traffic-cone')); ?>"></i>
							</div>

							<div class="snf-desc">
								<h2>Oops</h2>
								<h4><?php echo esc_html($translate['search-subtitle']) .' '. esc_html($_GET['s']); ?></h4>
							</div>

						</div>

					<?php endif; ?>

				</div>
			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php require_once( ABSPATH . 'wp-admin/includes/post.php' ); ?>
<?php intrado_fetch_news_function(); ?>
<?php get_footer();
