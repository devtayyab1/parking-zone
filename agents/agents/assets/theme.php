<?php

use App\partners;

header("Content-type: text/css; charset: UTF-8");
session_start();
$agent_id = $_SESSION["agent"];
$patners = partners::where("id", $agent_id)->first();
if ($patners) {
    $home_search_bar_color = $patners->home_search_bar_color;
    $result_search_bar_color = $patners->result_search_bar_color;
    $recept_headingbg_color = $patners->recept_headingbg_color;
    $book_now_color = $patners->book_now_color;
    $search_btn_color = $patners->search_btn_color;
    $parking_type_color = $patners->parking_type_color;
    $header_menu_color = $patners->header_menu_color;
    $footer_bg_color = $patners->footer_bg_color;
}


?>
.search-box-wrapper.style1 .search-tab-content .title-container {
background: <?php echo $result_search_bar_color; ?> !important;
background-color: <?php echo $result_search_bar_color; ?> !important;
}

#searchbar-nav {
background:  <?php echo $sec_iconz_color; ?> !important;
background-color:  <?php echo $sec_iconz_color; ?> !important;
}

#search_button {
background:  <?php echo $book_now_color; ?> !important;
background-color:  <?php echo $book_now_color; ?> !important;
}
#detailbooking .heading {
background:  <?php echo $recept_headingbg_color; ?> !important;
background-color:  <?php echo $recept_headingbg_color; ?> !important;
}
.box1 h3 {
background:  <?php echo $parking_type_color; ?> !important;
background-color:  <?php echo $parking_type_color; ?> !important;
}
.search-box-wrapper.style1 .search-tab-content .title-container {
background:  <?php echo $home_search_bar_color; ?> !important;
background-color:  <?php echo $home_search_bar_color; ?> !important;
}
.vc_custom_1523526087711 {
background: <?php echo $header_menu_color; ?> !important;
background-color: <?php echo $header_menu_color; ?> !important;
}

.footer_wrap .scheme_dark.vc_row, .scheme_dark.footer_wrap {

background: <?php echo $footer_bg_color; ?> !important;
background-color: <?php echo $footer_bg_color; ?> !important;
}