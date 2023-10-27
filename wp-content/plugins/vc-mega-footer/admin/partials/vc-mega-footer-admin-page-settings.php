<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    VC Mega Footer
 * @subpackage VC Mega Footer/admin/partials
 */

?><h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
<form method="post" action="options.php"><?php

settings_fields( $this->plugin_name . '-options' );

do_settings_sections( $this->plugin_name );

submit_button( 'Save Settings' );

?></form>


<style>

.mgft_settings_heading {
      background-color:transparent !important;
      padding:5px 0 !important;
 }
.mgft_settings_heading h3 {
      margin-bottom:0;
      padding-bottom:5px;
      padding-left:2px;
      color:#444;
      margin-top:40px;
      max-width:700px;
}
.mgft_settings_heading h5 {
      margin-top:0;
      margin-bottom:5px;
}
.form-table td,
.form-table th {
      color:#444;
      background-color: #FFF;
}
.form-table th {
      padding-left:10px;
}
.form-table {
      max-width:900px;
}

.wp-core-ui .button-primary {
      background: #00AEF0;
      border: none;
      padding: 10px 35px;
      height: auto;
      width: auto;
      text-shadow: none;
      -webkit-box-shadow: none;
      box-shadow: none;
      border-radius: 4px;
      margin-top:10px;
      margin-bottom:40px;
}
.wp-core-ui .button-primary:hover {
      opacity:0.8;
}
</style>

<script>







      // lets do some re-arranging of the headings and layout for the settings
      jQuery( "h2:contains('VC Mega Footer Settings')" ).css( "font-size", "30px" );

      // Tag footer placement
      mgft_row = jQuery("<tr><th class='mgft_settings_heading' colspan='2'><h3>Activate and Place Footer</h3><h5>Activate and place the footer using the 'wp_footer' hook or another hook that you specify </th></tr>");
      mgft_row.insertBefore( jQuery( "th:contains('Append via hook')" ).parent('tr') );

      // Footer Internal Column Width
      mgft_row = jQuery("<tr><th class='mgft_settings_heading' colspan='2'><h3>Internal Column Width</h3></th></tr>");
      mgft_row.insertBefore( jQuery( "th:contains('Footer Internal Column Width')" ).parent('tr') );

      // VC_ROW css fixes
      mgft_row = jQuery("<tr><th class='mgft_settings_heading' colspan='2'><h3>VC Row css fixes</h3></th></tr>");
      mgft_row.insertBefore( jQuery( "th:contains('Padding Fix')" ).parent('tr') );

      // Footer tag css fixes
      mgft_row = jQuery("<tr><th class='mgft_settings_heading' colspan='2'><h3>Footer Tag css fixes</h3></th></tr>");
      mgft_row.insertBefore( jQuery( "th:contains('Zero padding/margin on Footer tag')" ).parent('tr') );

</script>
