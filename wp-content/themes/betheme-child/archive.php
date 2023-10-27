<?php

/**

 * The template for displaying archive pages

 */



get_header(); 

$queried_category = get_term( get_query_var('cat'), 'category' ); 



$cat_banner = get_field( 'archive_banner_image', $queried_category );

$banner_heading = get_field( 'category_page_banner_heading', $queried_category );

if( !empty( $cat_banner ) ) {

    $banner_src = $cat_banner;

} else {

    $banner_src = get_stylesheet_directory_uri().'/images/composites-page-banner.jpg';

}



?>

<div class="banner-arrows animate-in" style="background-image: url('<?php echo $banner_src; ?>')">

   <div class="banner-padding">

      <div class="banner-content">

         <div class="page-info">

            <h2 class="white"><?php echo ( ( !empty( $banner_heading ) ) ? $banner_heading : $queried_category->name ); ?></h2>

            <p><?php echo $queried_category->description; ?></p>

         </div>

         <div class="arrows">

            <img class="corner-top" src="/wp-content/uploads/2022/01/corner-top-1.png">

            <img class="corner-bottom" src="/wp-content/uploads/2022/01/corner-bottom-1.png">

         </div>

      </div>

   </div>

</div>

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

                                                <a href="<?php echo site_url(); ?>">Home</a>

                                            </li>

                                            <li>

                                                <a href="<?php echo site_url(); ?>/news-events/">News</a>

                                            </li>

                                            <li>

                                                <span><?php echo $queried_category->name; ?></span>

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

<div class="container">

<?php

    echo do_shortcode('[kaman_news_list category="'.$queried_category->slug.'"]');

?>

</div>

<?php get_footer();