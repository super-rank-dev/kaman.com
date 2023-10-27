<?php
/**
 * Betheme Child Theme
 *
 * @package Betheme Child Theme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Child Theme constants
 * You can change below constants
 */

// white label

define('WHITE_LABEL', false);

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
  // enqueue the parent stylesheet
  // however we do not need this if it is empty
  // wp_enqueue_style('parent-style', get_template_directory_uri() .'/style.css');

  // enqueue the parent RTL stylesheet

  if (is_rtl()) {
    wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
  }

  // enqueue the child stylesheet

  wp_dequeue_style('style');
  wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
}
add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 101);

/**
 * Load Textdomain
 */

function mfnch_textdomain()
{
  load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
  load_child_theme_textdomain('mfn-opts', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mfnch_textdomain');


add_filter( 'body_class', 'kaman_page_body_custom_class' );
function kaman_page_body_custom_class( $classes ) {
    $getClassName = get_post_meta( get_the_id(), 'kaman_page_body_class', true );
    if( !empty( $getClassName ) ) {
        $classes[] = $getClassName;
    }
    return $classes;
}


// Create new widget area
function kaman_wp_widgets_init() {
    register_sidebar( array(
        'name'          => 'KAMAN Stock Amount',
        'id'            => 'kaman-stock-amount',
        'before_widget' => '<div class="kaman-custom-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="kaman-custom-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'kaman_wp_widgets_init' );


/********************************************
 * Theme Custom Social Media
*********************************************/

class Kaman_Stock_Amount_Widget extends WP_Widget {

  public function __construct() {
      $widget_ops = array('classname' => 'Kaman_Stock_Amount_Widget', 'description' => 'Displays KAMAN Stock Amount!' );
      parent::__construct('Kaman_Stock_Amount_Widget', 'KAMAN Stock Amount', $widget_ops);
  }

  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);
    $kaman_amount_heading     = empty($instance['kaman_amount_heading']) ? ' ' : apply_filters('widget_title', $instance['kaman_amount_heading']);
    $kaman_amount_num    = empty($instance['kaman_amount_num']) ? '' : $instance['kaman_amount_num'];

    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');

    // Stock ticker API
    $tickerRequest = wp_remote_get('https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/Quotes');

    if( is_wp_error( $tickerRequest ) ) {
      return false;
    }

    $requestBody = wp_remote_retrieve_body($tickerRequest);
    $tickerData = json_decode($requestBody, true);

    if($tickerData['data'][0]['changeNumber'] > 0) {
      $tickerClass = 'positive';
    } else {
      $tickerClass = 'negative';
    }

   ?>
    <div class="kaman-stock-amount top-header">
      <?php echo $kaman_amount_heading; ?>
      <span class="<?php echo $tickerClass ?>">$<?php echo $tickerData['data'][0]['lastTrade'] ?></span>
    </div>
   <?php
    // After widget code, if any
    echo (isset($after_widget)?$after_widget:'');
  }

  public function form( $instance ) {

     // PART 1: Extract the data from the instance variable
     $instance       = wp_parse_args( (array) $instance, array( 'kaman_amount_heading' => '' ) );

     $kaman_amount_heading     = $instance['kaman_amount_heading'];
     $kaman_amount_num      = $instance['kaman_amount_num'];
     $googlepluslink   = $instance['googlepluslink'];
     $twitterlink      = $instance['twitterlink'];
     $linkedinlink     = $instance['linkedinlink'];
     $instagramlink    = $instance['instagramlink'];
     ?>
     <p>
      <label for="<?php echo $this->get_field_id('kaman_amount_heading'); ?>">KAMAN Amount Heading:
        <input class="widefat" id="<?php echo $this->get_field_id('kaman_amount_heading'); ?>"
               name="<?php echo $this->get_field_name('kaman_amount_heading'); ?>" type="text"
               value="<?php echo $kaman_amount_heading; ?>" />
      </label>
      </p>
     <p>
      <label for="<?php echo $this->get_field_id('kaman_amount_num'); ?>">KAMAN Amount:
        <input class="widefat" id="<?php echo $this->get_field_id('kaman_amount_num'); ?>"
               name="<?php echo $this->get_field_name('kaman_amount_num'); ?>" type="text"
               value="<?php echo $kaman_amount_num; ?>" />
      </label>
      </p>

      <!-- Widget Title field END -->

     <?php

  }

  function update($new_instance, $old_instance) {
    $instance             = $old_instance;
    $instance['kaman_amount_heading']     = $new_instance['kaman_amount_heading'];
    $instance['kaman_amount_num']    = $new_instance['kaman_amount_num'];
    return $instance;
  }

}

add_action( 'widgets_init', 'Woo_Widget_init_AdSpace' );

function Woo_Widget_init_AdSpace() {
  return register_widget('Kaman_Stock_Amount_Widget');
}

add_action('intrado_fetch_news', 'intrado_fetch_news_function');
function intrado_fetch_news_function() {

  $newsUrl = 'https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/News';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $newsUrl);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
  curl_setopt($ch, CURLOPT_TIMEOUT, 300);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $curlContent = curl_exec( $ch );
  curl_close( $ch );

  $getCurl = json_decode($curlContent, true);

  foreach ($getCurl['data'] as $data) {
    // echo '<br />';
    // echo $data['title'];
    // echo '<br />';
    // echo $data['teaser'];
    // echo '<br /><br />';
    // echo "Does the post exist already? ";
    if (post_exists(wp_strip_all_tags($data['title'])) == 0) {
      // echo "Create a new post";

      $ch = curl_init();

      $postUrl = $data['link']['url'];

      curl_setopt($ch, CURLOPT_URL, $postUrl);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
      curl_setopt($ch, CURLOPT_TIMEOUT, 300);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $curlPostContent = curl_exec( $ch );
      curl_close( $ch );

      $getPostCurl = json_decode($curlPostContent, true);

      //echo "<br /><br />";


      //print_r($getPostCurl['data']['body'][0]['value']);

      //echo "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";

      $time = strtotime($data['releaseDate']['dateUTC']);
      $dateInLocal = date("Y-m-d H:i:s", $time);

      $new_post = array(
        'post_title'    => wp_strip_all_tags($data['title']),
        'post_content'  => $getPostCurl['data']['body'][0]['value'],
        'post_excerpt'  => $data['teaser'],
        'post_status'   => 'publish',
        'post_author'   => 14,
        'post_category' => array(27),
        'post_date'     => $dateInLocal,
      );

      wp_insert_post($new_post);

    }
    //echo '<br /><br />';
  }

}

add_action('intrado_fetch_events', 'intrado_fetch_events_function');
function intrado_fetch_events_function() {

  $eventsUrl = 'https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/Events';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $eventsUrl);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
  curl_setopt($ch, CURLOPT_TIMEOUT, 300);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $curlContent = curl_exec( $ch );
  curl_close( $ch );

  $getCurl = json_decode($curlContent, true);

  foreach ($getCurl['data'] as $data) {
    if (post_exists($data['title']) == 0) {

      $time = strtotime($data['startDate']['dateUTC']);
      $dateInLocal = date("Y-m-d H:i:s", $time);

      $new_post = array(
        'post_title'    => wp_strip_all_tags($data['title']),
        'post_content'  => '<a href="'.$data['webCast']['url'].'" target="_blank"><img src="https://kamanproduction.sfa-us.com/wp-content/uploads/2021/10/webcast.png" /><p style="display: inline-block;padding-left: 12px;margin-bottom: 0;position: relative;top: -12px;margin-top: 15px;">Click here for webcast</p></a>',
        'post_excerpt'  => $data['type']['title'],
        'post_status'   => 'publish',
        'post_author'   => 14,
        'post_category' => array(27),
        'post_date'     => $dateInLocal,
      );

      wp_insert_post($new_post);

    }
  }

}

function getContents($string, $startDelimiter, $endDelimiter) {
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($string, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($string, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }
    $contents[] = substr($string, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }

  return $contents;
}

add_action('intrado_fetch_presentations', 'intrado_fetch_presentations_function');
function intrado_fetch_presentations_function() {

  $presentationsUrl = 'https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/assets?type=presentations';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $presentationsUrl);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
  curl_setopt($ch, CURLOPT_TIMEOUT, 300);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $curlContent = curl_exec( $ch );
  curl_close( $ch );

  $getCurl = json_decode($curlContent, true);

  global $wpdb;
  $currentPresentations = $wpdb->get_row("SELECT `post_content` FROM `wp_posts` WHERE `ID` = 3824");

  $presentationArray = json_decode(json_encode($currentPresentations), true);

  $postContent = $presentationArray['post_content'];

  // Open up page content
  $newPostContent = '<p>[vc_row css=".vc_custom_1622562289329{padding-top: 70px !important;}"][vc_column][vc_custom_heading text="Investor Presentation Documents" use_theme_fonts="yes"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1621949019742{background-color: #ffffff !important;}" el_class="mt0 pt0"][vc_column][vc_tta_accordion c_position="right" active_section="1" collapsible_all="true"]';

  // Get existing dates
  $years = getContents($postContent, '[vc_tta_section title="', '" tab_id="');

  // Get existing content under each date section
  $currentPresentations = getContents($postContent, '[vc_row_inner][vc_column_inner]', '[/vc_column_inner][/vc_row_inner]');

  // print_r($years);
  // print_r($currentPresentations);

  $index = 0;
  foreach($years as $year) {

    $newContent = '';

    foreach ($getCurl['data'] as $data) {

      // If there is a presentation URL
      if (isset($data['documents'][0]['url'])) {

        // If file is not on page already
        if (!str_contains($postContent, $data['documents'][0]['url'])) {

          // Get the date of the new presentation
          $postYear = date('Y', strtotime($data['date']));

          if ($postYear == $year) {
            $newContent .= '[icon_box icon_position="left" border="0" target="_blank" image="1479" title="'. $data['documents'][0]['title'] .'" link="'. $data['documents'][0]['url'] .'" class="accordian-left"]'. date('l, F j, Y' , strtotime($data['date'])) .'[/icon_box]';
          }
        }
      }
    }

    ////////////////////////
    // Fill in tab content

    if (($currentPresentations[$index] == '') && ($newContent == '')) {
      $hideTab = 'el_class="d-none"';
    } else {
      $hideTab = '';
    }

    // ADD  el_class="d-none"  to vc_tta_section
    $newPostContent .= '[vc_tta_section title="' . $year . '" tab_id="tab-' . $year . '" '. $hideTab .'][vc_row_inner][vc_column_inner]';

    // Fill in the new presentations
    $newPostContent .= $newContent;

    // Fill in the existing content
    $newPostContent .= $currentPresentations[$index];

    // Close out the tab content
    $newPostContent .= '[/vc_column_inner][/vc_row_inner][/vc_tta_section]';

    $index++;
  }

  // Close out page content
  $newPostContent .= '[/vc_tta_accordion][/vc_column][/vc_row][vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1621949135783{padding-top: 35px !important;background-color: #ffffff !important;}"][vc_column css=".vc_custom_1621368099651{padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_separator color="custom" accent_color="#dddddd"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1607882211990{background: #ffffff url(http://kamanwpstaging.sfadev.com/wp-content/uploads/2020/12/kaman-trans.png?id=189) !important;}" el_class="contact-section contact-form-section"][vc_column width="2/3"][vc_column_text]</p><h2><strong><span style="color: #414042;">Contact KAMAN</span></strong></h2><p>[/vc_column_text][vc_column_text][contact-form-7 id="76" title="Corporate Contact"][/vc_column_text][/vc_column][vc_column width="1/3" el_class="contact-us-page-address"][vc_empty_space height="65px" el_class="contact-form-empty-space"][vc_column_text]<strong>Headquarters:</strong><br />1332 Blue Hills Avenue<br />Bloomfield, CT 06002</p><p><strong>Mailing Address:</strong><br />Kaman Corporation<br />PO Box 1<br />Bloomfield, CT 06002</p><p><strong>Phone:</strong><br /><a href="tel:+1 860.243.7100">+1 860.243.7100</a>[/vc_column_text][/vc_column][/vc_row]</p>';

  $newPostContent = addslashes($newPostContent);

  $table = $wpdb->prefix . 'posts';

  $wpdb->query($updateQuery);
}

add_shortcode( 'kaman_news_list', 'kaman_news_list_callback' );
function kaman_news_list_callback( $atts ) {

  /////////////////////////////////////////////
  // DEBUG
  /* Fetch events
  $eventsUrl = 'https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/Events';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $eventsUrl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $curlContent = curl_exec( $ch );
  curl_close( $ch );

  $getCurl = json_decode($curlContent, true);

  foreach ($getCurl['data'] as $data) {
    // echo '<br /><br />';
    // echo "Does the post exist already? ";
    if (post_exists($data['title']) == 0) {
      // echo "Create a new post";

      // echo "<br /><br />";

      // echo $data['title']; //Title
      // echo "<br />";
      // echo '<a href="'.$data['webCast']['url'].'" target="_blank"><img src="https://kamanproduction.sfa-us.com/wp-content/uploads/2021/10/webcast.png" /><p style="display: inline-block;padding-left: 12px;margin-bottom: 0;position: relative;top: -12px;margin-top: 15px;">Click here for webcast</p></a>'; //Content
      // echo "<br />";
      // echo $data['type']['title']; //Excerpt
      // echo "<br />";
      // echo $data['startDate']['dateUTC']; //Date

      // echo "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";

      $time = strtotime($data['startDate']['dateUTC']);
      $dateInLocal = date("Y-m-d H:i:s", $time);

      $new_post = array(
        'post_title'    => wp_strip_all_tags($data['title']),
        'post_content'  => '<a href="'.$data['webCast']['url'].'" target="_blank"><img src="https://kamanproduction.sfa-us.com/wp-content/uploads/2021/10/webcast.png" /><p style="display: inline-block;padding-left: 12px;margin-bottom: 0;position: relative;top: -12px;margin-top: 15px;">Click here for webcast</p></a>',
        'post_excerpt'  => $data['type']['title'],
        'post_status'   => 'publish',
        'post_author'   => 14,
        'post_category' => array(27),
        'post_date'     => $dateInLocal,
      );

      wp_insert_post($new_post);

    }
    // echo '<br /><br />';
  }  */

  /////////////////////////////////////////////
  /* Fetch news
  $newsUrl = 'https://clientapi.gcs-web.com/data/96a60874-9adc-43d3-a891-8241c1db2d0b/News';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $newsUrl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $curlContent = curl_exec( $ch );
  curl_close( $ch );

  $getCurl = json_decode($curlContent, true);

  foreach ($getCurl['data'] as $data) {
    // echo '<br />';
    // echo $data['title'];
    // echo '<br />';
    // echo $data['teaser'];
    // echo '<br /><br />';
    // echo "Does the post exist already? ";
    if (post_exists($data['title']) == 0) {
      // echo "Create a new post";

      $ch = curl_init();

      $postUrl = $data['link']['url'];

      curl_setopt($ch, CURLOPT_URL, $postUrl);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $curlPostContent = curl_exec( $ch );
      curl_close( $ch );

      $getPostCurl = json_decode($curlPostContent, true);

      //echo "<br /><br />";


      //print_r($getPostCurl['data']['body'][0]['value']);

      //echo "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";

      $time = strtotime($data['releaseDate']['dateUTC']);
      $dateInLocal = date("Y-m-d H:i:s", $time);

      // $new_post = array(
      //   'post_title'    => wp_strip_all_tags($data['title']),
      //   'post_content'  => $getPostCurl['data']['body'][0]['value'],
      //   'post_excerpt'  => $data['teaser'],
      //   'post_status'   => 'publish',
      //   'post_author'   => 14,
      //   'post_category' => array(27),
      //   'post_date'     => $dateInLocal,
      // );
      //
      // wp_insert_post($new_post);

    }
    //echo '<br /><br />';
  }
   */
  //////////////////////////////////////////////////////////////////////////////////////



  $atts = shortcode_atts( array(
    'category' => '',
  ), $atts);
  ob_start();
  ?>
  <div class="kaman-news-listing-page single-related-news">
    <div class="news-search">
      <h2 class="vc_custom_heading">Search News</h2>
      <div class="search-field">
        <a href="#"><span class="visually-hidden">Search</span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search.svg"></a>
        <input type="search" id="news_search_news" name="search_news">
      </div>
       <div class="news-search-result-section"></div>
    </div>
    <div class="news-filters">
      <div class="filter-block">
        <ul class="filter-menu">
          <li class="filter-item">
            <a class="filter-link" href="#filter1">
              <span>Brand</span>
            </a>
            <div class="filter-option brand-filter-list" id="filter1">
              <?php
                $category_slug = $atts['category'];

                $categories = get_categories( array(
                    'orderby' => 'name',
                    'order'   => 'ASC'
                ) );
                if( !empty( $categories ) ) {
                  foreach( $categories as $categorie ) {
                    ?>
                    <div class="option-item">
                      <input type="checkbox" <?php echo ( ( $category_slug == $categorie->slug ) ? 'checked' : '' ); ?> id="category_<?php echo $categorie->term_id; ?>" value="<?php echo $categorie->term_id; ?>" name="news_filter_category">
                      <label for="category_<?php echo $categorie->term_id; ?>"><?php echo $categorie->name; ?></label>
                    </div>
                    <?php
                  }
                }
              ?>
            </div>
          </li>
          <li class="filter-item hide" style="display: none;">
            <a class="filter-link" href="#filter2">
              <span>Type</span>
            </a>
            <div class="filter-option" id="filter2">
              <div class="option-item">
                <input type="checkbox" id="grw5" name="GRW">
                <label for="grw5">GRW</label>
              </div>
              <div class="option-item">
                <input type="checkbox" id="grw6" name="GRW">
                <label for="grw6">GRW</label>
              </div>
              <div class="option-item">
                <input type="checkbox" id="grw7" name="GRW">
                <label for="grw7">GRW</label>
              </div>
            </div>
          </li>
          <li class="clear-filter hide"><a href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i> Clear Filters</a></li>
        </ul>
      </div>
      <div class="sort-flter">
        <label for="sort-by">Sort by :</label>
        <select name="sort-by" id="news_sort_by">
          <option value="latest">Latest</option>
          <option value="atoz">Title A to Z</option>
          <option value="ztoa">Title Z to A</option>
        </select>
      </div>
    </div>
    <div id="kaman-news-listing-container">
      <div class="row">
        <?php
        $newsArgs =  [
              'post_type' => 'post',
              'post_status' => 'publish',
              'orderby' => 'date',
              'order' => 'DESC',
              'posts_per_page' => '12',
              'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            ];
        if( isset( $category_slug ) && !empty( $category_slug ) ) {
            $newsArgs['tax_query'] = [
              [
                'taxonomy'  => 'category',
                'field'     => 'slug',
                'terms'     => $category_slug,
              ]
            ];
          }

          $loop = new WP_Query(
            $newsArgs
          );
          if( $loop->have_posts() ) {
            while( $loop->have_posts() ) { $loop->the_post();
                    $image_src = get_the_post_thumbnail_url();
                    $categories = get_the_category();
              ?>
              <div class="col-sm-3">
                <div class="news-box <?php echo ( ( !empty( $image_src ) )? 'with-img' : '' ); ?>">
                          <?php
                            if( !empty( $image_src ) ) {
                              echo '<div class="news-img"><a href="'.get_the_permalink().'"><img src="'.$image_src.'"></a></div>';
                            }
                          ?>
                          <div class="news-desc">
                      <span><?php echo get_the_date( 'd F Y' ); ?></span>
                              <span class="category"><?php echo ( ( isset( $categories[0]->name ) )? $categories[0]->name : '-' ); ?></span>
                      <a href="<?php echo get_the_permalink(); ?>"><h3><?php echo wp_trim_words( get_the_title(), 8 ); ?></h3></a>
                      <p><?php echo get_the_excerpt(); ?></p>
                      <a href="<?php echo get_the_permalink(); ?>"> > </a>
                        </div>
                </div>
              </div>
              <?php
            }
          }
          wp_reset_postdata();
        ?>

      </div>
      <div class="news-pagination">
        <?php
          $big = 999999999; // need an unlikely integer
          echo paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $loop->max_num_pages
          ) );
        ?>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery(".filter-link").click(function(event){
        event.preventDefault();
        jQuery(this).toggleClass( 'currebt-active' );
        jQuery( jQuery(this).attr('href') ).slideToggle(500);
      });
    });
    jQuery.fn.kamandonetyping = function (callback) {
        var _this = jQuery(this);
        var x_timer;

        function clear_timer() {
            clearTimeout(x_timer);
            callback.call(_this);
        }

        _this.keyup(function () {
            clearTimeout(x_timer);
            x_timer = setTimeout(clear_timer, 500);
        });
    };
     jQuery('input#news_search_news').kamandonetyping(function(){
    var sVal = jQuery(this).val();

      jQuery('input#news_search_news').parent().addClass('latest-new-search-processing');
       var categories = [];
          jQuery('.brand-filter-list input').each(function() {
              if( jQuery(this).prop("checked") == true ) {
                  categories.push(jQuery(this).val());
              }
          });
      jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          data: {
              'action': 'kaman_news_listing_page_search',
              'categories': categories,
              'seacrh': sVal,
          },
          success: function (response) {
              jQuery('input#news_search_news').parent().removeClass('latest-new-search-processing');
              if (response.status === 'success') {
                  jQuery(".news-search-result-section").html(response.html);
              }

          }
      });
     });
      // News Pagination
     (function($){
        $(document).on('change','.brand-filter-list input, #news_sort_by', function(){
          var thisHref = 1;
          $("li.clear-filter").removeClass( 'hide' );
          var sortBy = $('#news_sort_by :selected').val();
          $("a.filter-link.currebt-active").trigger('click');
          var categories = [];
          $('.brand-filter-list input').each(function() {
              if( $(this).prop("checked") == true ) {
                  categories.push($(this).val());
              }
          });

          $("#kaman-news-listing-container").addClass( 'kaman-blog-ajax-loader' );

          $('html, body').animate({
            scrollTop: $('.kaman-news-listing-page').offset().top
          }, 500);

          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              data: {
                  'action'    : 'kaman_news_listing_page_pagination',
                  'page_url'  : thisHref,
                  'categories': categories,
                  'sort_by'    : sortBy,
              },
              success: function (response) {
                  if( response.status === 'success' ) {
                    $("#kaman-news-listing-container").removeClass( 'kaman-blog-ajax-loader' );
                    $("#kaman-news-listing-container").html( response.html );
                  }
              }
          });
        });
        $(document).on('click','.news-pagination a', function(event) {
          event.preventDefault();
          var thisHref = $(this).attr( 'href' );
          var sortBy = $('#news_sort_by :selected').val();

          var categories = [];
          $('.brand-filter-list input').each(function() {
              if( $(this).prop("checked") == true ) {
                  categories.push($(this).val());
              }
          });


          $("#kaman-news-listing-container").addClass( 'kaman-blog-ajax-loader' );

          $('html, body').animate({
            scrollTop: $('.kaman-news-listing-page').offset().top
          }, 500);

          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              data: {
                  'action'    : 'kaman_news_listing_page_pagination',
                  'page_url'  : thisHref,
                  'categories': categories,
                  'sort_by'    : sortBy,
              },
              success: function (response) {
                  if( response.status === 'success' ) {
                    $("#kaman-news-listing-container").removeClass( 'kaman-blog-ajax-loader' );
                    $("#kaman-news-listing-container").html( response.html );
                  }
              }
          });
        });
        $(document).on('click','li.clear-filter a', function() {
          $('.brand-filter-list input:checkbox').removeAttr('checked');
          $("#news_sort_by").val($("#news_sort_by option:first").val()).trigger('change');
          $('li.clear-filter').addClass( 'hide' );
        });
     })(jQuery);
  </script>
  <?php
  $output = ob_get_contents();
  ob_get_clean();
  return $output;
}

// Ajax search
add_action('wp_ajax_kaman_news_listing_page_search', 'kaman_news_listing_page_search_callback');
add_action('wp_ajax_nopriv_kaman_news_listing_page_search', 'kaman_news_listing_page_search_callback');
function kaman_news_listing_page_search_callback() {
  if( isset( $_POST['seacrh'] ) && !empty( $_POST['seacrh'] ) ) {

    $newsArgs = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => '20',
        's' => $_POST['seacrh']
      ];

    // Category Filter
    if( isset( $_POST['categories'] ) && !empty( $_POST['categories'] ) ) {
      $newsArgs['tax_query'] = [
        [
          'taxonomy'  => 'category',
          'field'     => 'term_id',
          'terms'     => $_POST['categories'],
        ]
      ];
    }

    $loop = new WP_Query(
      $newsArgs
    );
    ob_start();
    if( $loop->have_posts() ) {
      echo '<ul>';
      while( $loop->have_posts() ) { $loop->the_post();
        echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
      }
      echo '</ul>';
      wp_reset_postdata();
    } else {
      echo '<ul>';
      echo '<li><a href="javascript:void(0);">There are no results that match your search</a></li>';
      echo '</ul>';
    }
    $html = ob_get_contents();
    ob_get_clean();

    wp_send_json( [ 'status' => 'success', 'html' => $html ] );
    die;
  } else {
    wp_send_json( [ 'status' => 'success', 'html' => '' ] );
    die;
  }
}

// News Listing Pagination
add_action('wp_ajax_kaman_news_listing_page_pagination', 'kaman_news_listing_page_pagination_callback');
add_action('wp_ajax_nopriv_kaman_news_listing_page_pagination', 'kaman_news_listing_page_pagination_callback');
function kaman_news_listing_page_pagination_callback() {
    $page_url = ( ( isset(  $_POST['page_url'] ) ) ? $_POST['page_url'] : '' );
    $paged = 1;
    if( !empty( $page_url ) ) {
      $explode = explode('/', $page_url);
      $explode = array_filter( $explode );
      $endNum = end($explode);
      if( is_numeric( $endNum ) ) {
        $paged = $endNum;
      } else {
        $explode = explode('?paged=', $page_url);
        $explode = array_filter( $explode );
        $endNum = end($explode);
        if( is_numeric( $endNum ) ) {
          $paged = $endNum;
        }
      }
    }

    ob_start();
    ?>
    <div class="row">
        <?php
          $newsArgs = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => '12',
            'paged' => $paged
          ];

          // Sort By Filter
          if( ( isset( $_POST['sort_by'] ) && $_POST['sort_by'] == 'ztoa' ) || ( isset( $_POST['sort_by'] ) && $_POST['sort_by'] == 'atoz' ) ) {
            $orderby = ( $_POST['sort_by'] == 'atoz' ) ? 'ASC' : 'DESC';
            $newsArgs['orderby'] = 'title';
            $newsArgs['order']   = $orderby;
          }

          // Category Filter
          if( isset( $_POST['categories'] ) && !empty( $_POST['categories'] ) ) {
            $newsArgs['tax_query'] = [
              [
                'taxonomy'  => 'category',
                'field'     => 'term_id',
                'terms'     => $_POST['categories'],
              ]
            ];
          }
// print_r($newsArgs); die;
          $loop = new WP_Query( $newsArgs );
          if( $loop->have_posts() ) {
            while( $loop->have_posts() ) { $loop->the_post();
              $image_src = get_the_post_thumbnail_url();
              $categories = get_the_category();
              ?>
              <div class="col-sm-3">
                <div class="news-box <?php echo ( ( !empty( $image_src ) )? 'with-img' : '' ); ?>">
                    <?php
                      if( !empty( $image_src ) ) {
                        echo '<div class="news-img"><a href="'.get_the_permalink().'"><img src="'.$image_src.'"></a></div>';
                      }
                    ?>
                    <div class="news-desc">
                        <span><?php echo get_the_date( 'd F Y' ); ?></span>
                        <span class="category"><?php echo ( ( isset( $categories[0]->name ) )? $categories[0]->name : '-' ); ?></span>
                        <a href="<?php echo get_the_permalink(); ?>">
                          <h3><?php echo wp_trim_words( get_the_title(), 8 ); ?></h3>
                        </a>
                        <p><?php echo get_the_excerpt(); ?></p>
                        <a href="<?php echo get_the_permalink(); ?>"> > </a>
                    </div>
                </div>
              </div>
              <?php
            }
          }
          wp_reset_postdata();
        ?>
      </div>
      <div class="news-pagination">
        <?php
          $big = 999999999; // need an unlikely integer
          echo paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $loop->max_num_pages
          ) );
        ?>
      </div>  
    <?php
    $html = ob_get_contents();
    ob_get_clean();

    wp_send_json( [ 'status' => 'success', 'html' => $html ] );
    die;
}