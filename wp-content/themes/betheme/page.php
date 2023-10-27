<?php

/**

 * The template for displaying all pages.

 *

 * @package Betheme

 * @author Muffin group

 * @link https://muffingroup.com

 */



get_header();

?>

<?php if(!get_field('hide_banner')): ?>

<?php

// Gets the depth of the current page
global $wp_query;
$object = $wp_query->get_queried_object();
$parent_id  = $object->post_parent;
$depth = 0;
while ($parent_id > 0) {
       $page = get_page($parent_id);
       $parent_id = $page->post_parent;
       $depth++;
}

// Gets the top-level parent
if ( 0 == $post->post_parent ) {
  // the_title();
} else {
  $parents = get_post_ancestors( $post->ID );
  $topParent = apply_filters( "the_title", get_the_title( end ( $parents ) ) );
}

?>

	<?php if(get_field('enable_video_background')): ?>
		<div class="banner-arrows">
	<?php else: ?>
		<div class="banner-arrows" style="background-image: url('<?php echo get_field('background_image') ?>')">
	<?php endif; ?>

		<?php if(get_field('enable_video_background')): ?>
			<div class="banner-video">
				<video data-autoplay loop muted autoplay poster="<?php echo get_field('video_poster') ?>">
			    <source src="<?php echo get_field('background_video') ?>" type="video/mp4">
				</video>
			</div>
		<?php endif; ?>

		<div class="banner-padding">

			<div class="banner-content" <?php echo get_field('container_max_width') ? 'style="max-width: '.get_field('container_max_width').'px;"' : '' ?>>
				<div class="page-info">
					<?php if(isset($topParent)): ?>
						<?php if($topParent == 'Brands'): ?>
							<?php if($depth == 2): ?>
								<?php if(get_field('title_image', $post->post_parent)): ?>
									<img alt="<?php echo get_the_title() ?>" src="<?php echo get_field('title_image', $post->post_parent) ?>" style="max-height: 50px; margin-bottom: 10px; width: unset; max-width: <?= get_field('max_width', $post->post_parent) ?>px;" />
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>

					<?php if(get_field('title_image')): ?>
						<img alt="<?php echo get_the_title() ?>" <?php echo get_field('max_width') ? 'style="max-height: 86px; margin-bottom: 10px; max-width: '.get_field('max_width').'px;"' : '' ?> src="<?php echo get_field('title_image') ?>" />
					<?php endif; ?>

					<?php if(get_field('title')): ?>
						<h1 class="white"><?php echo get_field('title') ?></h1>
					<?php endif; ?>

					<?php if(get_field('subhead')): ?>
						<p><?php echo get_field('subhead') ?></p>
					<?php endif; ?>
				</div>

				<div class="arrows">
					<img class="corner-top" alt="" src="/wp-content/uploads/2022/01/corner-top-1.png" />
					<img class="corner-bottom" alt="" src="/wp-content/uploads/2022/01/corner-bottom-1.png" />
				</div>

			</div>

		</div>

	</div>

<?php endif; ?>


<div id="Content">

	<div class="content_wrapper clearfix">

		<div class="sections_group">



			<div class="entry-content" itemprop="mainContentOfPage">

<?php if(get_field('show_breadcrumbs')): ?>
<?php
	// Breadcrumbs
	$ancestors =  implode( ',' , get_post_ancestors( $post->ID));
	$ancestorsArray = explode(',', $ancestors);
	$ancestorsArray = array_reverse($ancestorsArray);
?>
<div class="section the_content has_content breadcrumbs-section">
	<div class="section_wrapper">
		<div class="the_content_wrapper">
			<div class="vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-flex">
				<div class="wpb_column vc_column_container vc_col-sm-12">
					<div class="vc_column-inner">
						<div class="wpb_wrapper">
							<div class="wpb_raw_code wpb_content_element wpb_raw_html">
								<div class="wpb_wrapper">
									<div class="breadcrumbs">
										<ul>
											<li>
												<a href="/">Home</a>
											</li>
											<?php if(!empty(get_post_ancestors($post->ID))): ?>
												<?php foreach($ancestorsArray as $parentPage): ?>
													<li>
														<?php $relativeUrl = str_replace(home_url(), "", get_page_link($parentPage)) ?>
														<a href="<?php echo $relativeUrl == '/brands/' || $relativeUrl == '/products/' || $relativeUrl == '/industries/' || $relativeUrl == '/about/' ? 'javascript:void(0)' : get_page_link($parentPage) ?>" <?php echo $relativeUrl == '/brands/' || $relativeUrl == '/products/' || $relativeUrl == '/industries/' || $relativeUrl == '/about/' ? 'class="inactive-link"' : '' ?>><?php echo get_the_title($parentPage) ?></a>
													</li>
												<?php endforeach ?>
											<?php endif; ?>
											<li>
												<span><?php echo get_the_title($post) ?></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

				<?php

					while (have_posts()) {



						the_post();



						$mfn_builder = new Mfn_Builder_Front(get_the_ID());

						$mfn_builder->show();



					}

				?>



				<div class="section section-page-footer">

					<div class="section_wrapper clearfix">



						<div class="column one page-pager">

							<?php

								wp_link_pages(array(

									'before' => '<div class="pager-single">',

									'after' => '</div>',

									'link_before' => '<span>',

									'link_after' => '</span>',

									'next_or_number' => 'number'

								));

							?>

						</div>



					</div>

				</div>



			</div>



			<?php if (mfn_opts_get('page-comments')): ?>

				<div class="section section-page-comments">

					<div class="section_wrapper clearfix">



						<div class="column one comments">

							<?php comments_template('', true); ?>

						</div>



					</div>

				</div>

			<?php endif; ?>



		</div>



		<?php get_sidebar(); ?>



	</div>

</div>

<?php get_footer();

