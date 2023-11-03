
@php
        use App\partners;

    $site_settings_main=[];
        $settingsAll = App\settings::all();
                foreach ($settingsAll as $setting) {
                    $site_settings_main[$setting->field_name] = $setting->field_value;
                }
				
	if(isset($_SESSION["agent"])){
    $agent_id = $_SESSION["agent"];
    $patners = partners::where("id", $agent_id)->first();
    if ($patners) {
		$logo = $patners->logo;
	}
	else {
		$logo = secure_asset("assets/images/logo_new.png");
	}
	}
	else {
		$logo = secure_asset("assets/images/logo_new.png");
	}
   


   
				
				
@endphp

<header class="top_panel top_panel_custom top_panel_custom_9 top_panel_custom_header-short-2-rows without_bg_image">
    <div class="vc_row wpb_row vc_row-fluid vc_custom_1523526087711 vc_row-has-fill shape_divider_top-none shape_divider_bottom-none sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_fixed sc_layouts_row_fixed_always scheme_dark"
         style="top: auto;">
        <div class="wpb_column vc_column_container vc_col-sm-12 sc_layouts_column_icons_position_left">
            <div class="vc_column-inner">
                <div class="wpb_wrapper">
                    <div id="sc_content_1827287802"
                         class="sc_content color_style_default sc_content_default sc_content_width_1_1 sc_float_center">
                        <div class="sc_content_container">
                            <div class="vc_row wpb_row vc_inner vc_row-fluid vc_row-o-equal-height vc_row-o-content-middle vc_row-flex shape_divider_top-none shape_divider_bottom-none">
                                <div class="wpb_column vc_column_container vc_col-sm-2 vc_col-xs-6 sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left">
                                    <div class="vc_column-inner">
                                        <div class="wpb_wrapper">
                                            <div class="sc_layouts_item"><a
                                                        href="{{ route("main") }}"
                                                        id="sc_layouts_logo_1458827052"
                                                        class="sc_layouts_logo sc_layouts_logo_default"
                                                        ><img class="logo_image"
                                                                             src="{{ $logo }}"
                                                                             alt="Parkingzone" width="120"
                                                                             height="33"></a>
                                                <!-- /.sc_layouts_logo --></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpb_column vc_column_container vc_col-sm-10 vc_col-xs-6 sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left">
                                    <div class="vc_column-inner">
                                        <div class="wpb_wrapper">
                                            <div class="sc_layouts_item">
                                                <nav class="sc_layouts_menu sc_layouts_menu_default sc_layouts_menu_dir_horizontal menu_hover_fade hide_on_mobile inited"
                                                     id="sc_layouts_menu_994828205"
                                                     data-animation-in="fadeInUpSmall"
                                                     data-animation-out="fadeOutDownSmall">
                                                    <ul id="sc_layouts_menu_1416730604"
                                                        class="sf-menu sc_layouts_menu_nav "
                                                        style="touch-action: pan-y;">
                                                        <li id="menu-item-155"
                                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-155 expanded">
                                                            <a href="{{ route("main") }}" class="sf-with-ul"><span>Home</span></a>

                                                        </li>

                                                        {{--<li id="menu-item-155"--}}
                                                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-155 expanded">--}}
                                                            {{--<a href="" class="sf-with-ul"><span>Services</span></a>--}}

                                                            {{--<ul class="sub-menu" style="display: none;">--}}
                                                               {{----}}

                                                            {{--</ul>--}}

                                                        {{--</li>--}}


                                                         <li class="menu-item"><a href="{{ route("airports") }}">Airports Parking</a>
                                                                    <ul class="sub-menu" style="display: none;">
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton Airport Parking</a></li>
                                                                        <li class="menu-item"><a href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester Airport Parking</a></li>
                                                                        @if(count($airports) > 9)
                                                                            <li class="menu-item"><a style="background: #1d9cbc; text-align:center" href="{{ route("airports") }}"> {{ count($airports)-9 }} More Choices </a></li>
                                                                        @endif
                                                                    </ul>
                                                                </li>

                                                        {{--<li id="menu-item-156"--}}
                                                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-156">--}}
                                                            {{--<a href="{{ route("airports") }}"--}}
                                                               {{--class="sf-with-ul"><span>Airports Parking</span></a>--}}

                                                            {{--<ul class="sub-menu" style="display: none;">--}}
                                                                {{--<li id="menu-item-819"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home page_item page-item-326 menu-item-819">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/"--}}
                                                                       {{--target="_blank"><span>Home 1</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-331"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-331">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/home-2/"--}}
                                                                       {{--target="_blank"><span>Home 2</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-790"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-790">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/home-3/"--}}
                                                                       {{--target="_blank"><span>Home 3</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-823"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-823">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/home-4/"--}}
                                                                       {{--target="_blank"><span>Home 4</span></a>--}}
                                                                {{--</li>--}}
                                                            {{--</ul>--}}


                                                            {{--<ul class="sub-menu" style="display: none;">--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton Airport Parking</a></li>--}}
                                                                {{--<li class="menu-item"><a href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester Airport Parking</a></li>--}}
                                                                {{--@if(count($airports) > 9)--}}
                                                                    {{--<li class="menu-item"><a style="background: #1d9cbc; text-align:center" href="{{ route("airports") }}"> {{ count($airports)-9 }} More Choices </a></li>--}}
                                                                {{--@endif--}}
                                                            {{--</ul>--}}




                                                            {{--<ul class="sub-menu animated fast fadeOutDownSmall layouts_inited"--}}
                                                                {{--style="display: none;">--}}
                                                                {{--<li id="menu-item-162"--}}
                                                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-162">--}}
                                                                    {{--<a href="#"--}}
                                                                       {{--class="sf-with-ul"><span>Pages</span></a>--}}
                                                                    {{--<ul class="sub-menu animated fast fadeOutDownSmall layouts_inited"--}}
                                                                        {{--style="display: none;">--}}
                                                                        {{--<li id="menu-item-160"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-160">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/typography/"--}}
                                                                               {{--target="_blank"><span>Typography</span></a>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-159"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-159">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/shortcodes/"--}}
                                                                               {{--target="_blank"><span>Shortcodes</span></a>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-353"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-353">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/service-plus/"--}}
                                                                               {{--target="_blank"><span>Service Plus</span></a>--}}
                                                                        {{--</li>--}}
                                                                    {{--</ul>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-161"--}}
                                                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-161">--}}
                                                                    {{--<a href="#"--}}
                                                                       {{--class="sf-with-ul"><span>Gallery</span></a>--}}
                                                                    {{--<ul class="sub-menu fadeOutDownSmall animated fast"--}}
                                                                        {{--style="display: none;">--}}
                                                                        {{--<li id="menu-item-164"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-164">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/gallery-grid/"--}}
                                                                               {{--target="_blank"><span>Grid</span></a>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-165"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-165">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/gallery-masonry/"--}}
                                                                               {{--target="_blank"><span>Masonry</span></a>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-163"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-163">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/gallery-cobbles/"--}}
                                                                               {{--target="_blank"><span>Cobbles</span></a>--}}
                                                                        {{--</li>--}}
                                                                    {{--</ul>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-166"--}}
                                                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-166">--}}
                                                                    {{--<a href="#"--}}
                                                                       {{--class="sf-with-ul"><span>Blog</span></a>--}}
                                                                    {{--<ul class="sub-menu fadeOutDownSmall animated fast"--}}
                                                                        {{--style="display: none;">--}}
                                                                        {{--<li id="menu-item-167"--}}
                                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-167">--}}
                                                                            {{--<a href="http://parkingzone.co.uk/all-posts/"--}}
                                                                               {{--target="_blank"><span>All Posts</span></a>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-168"--}}
                                                                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-168">--}}
                                                                            {{--<a href="#"--}}
                                                                               {{--class="sf-with-ul"><span>Classic Style</span></a>--}}
                                                                            {{--<ul class="sub-menu animated fast fadeOutDownSmall"--}}
                                                                                {{--style="display: none;">--}}
                                                                                {{--<li id="menu-item-169"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-169">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-classic-2-columns/"--}}
                                                                                       {{--target="_blank"><span>2 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                                {{--<li id="menu-item-170"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-170">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-classic-3-columns/"--}}
                                                                                       {{--target="_blank"><span>3 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                            {{--</ul>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-171"--}}
                                                                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-171">--}}
                                                                            {{--<a href="#"--}}
                                                                               {{--class="sf-with-ul"><span>Portfolio</span></a>--}}
                                                                            {{--<ul class="sub-menu animated fast fadeOutDownSmall"--}}
                                                                                {{--style="display: none;">--}}
                                                                                {{--<li id="menu-item-172"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-172">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-portfolio-2-columns/"--}}
                                                                                       {{--target="_blank"><span>2 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                                {{--<li id="menu-item-173"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-173">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-portfolio-3-columns/"--}}
                                                                                       {{--target="_blank"><span>3 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                                {{--<li id="menu-item-174"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-174">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-portfolio-4-columns/"--}}
                                                                                       {{--target="_blank"><span>4 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                            {{--</ul>--}}
                                                                        {{--</li>--}}
                                                                        {{--<li id="menu-item-175"--}}
                                                                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-175">--}}
                                                                            {{--<a href="#"--}}
                                                                               {{--class="sf-with-ul"><span>Chess Style</span></a>--}}
                                                                            {{--<ul class="sub-menu animated fast fadeOutDownSmall"--}}
                                                                                {{--style="display: none;">--}}
                                                                                {{--<li id="menu-item-176"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-176">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-chess-2-columns/"--}}
                                                                                       {{--target="_blank"><span>2 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                                {{--<li id="menu-item-177"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-177">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-chess-4-columns/"--}}
                                                                                       {{--target="_blank"><span>4 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                                {{--<li id="menu-item-178"--}}
                                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-178">--}}
                                                                                    {{--<a href="http://parkingzone.co.uk/blog-chess-6-columns/"--}}
                                                                                       {{--target="_blank"><span>6 Columns</span></a>--}}
                                                                                {{--</li>--}}
                                                                            {{--</ul>--}}
                                                                        {{--</li>--}}
                                                                    {{--</ul>--}}
                                                                {{--</li>--}}
                                                            {{--</ul>--}}
                                                        {{--</li>--}}
                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-290"><a href="{{ route("airport_types") }}">Parking Types</a></li>

                                                        <li id="menu-item-290"
                                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-290">
                                                            <a href="{{ route("faqs") }}"
                                                               class="sf-with-ul"><span>FAQs</span></a>
                                                            {{--<ul class="sub-menu layouts_inited animated fast fadeOutDownSmall"--}}
                                                                {{--style="display: none;">--}}
                                                                {{--<li id="menu-item-291"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-291">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/our-features/"--}}
                                                                       {{--target="_blank"><span>Our Features</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-292"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-292">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/our-benefits/"--}}
                                                                       {{--target="_blank"><span>Our Benefits</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-203"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-203">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/price-guide/"--}}
                                                                       {{--target="_blank"><span>Price Guide</span></a>--}}
                                                                {{--</li>--}}
                                                                {{--<li id="menu-item-256"--}}
                                                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-256">--}}
                                                                    {{--<a href="http://parkingzone.co.uk/reservations/"--}}
                                                                       {{--target="_blank"><span>Reservations</span></a>--}}
                                                                {{--</li>--}}
                                                            {{--</ul>--}}
                                                        </li>
                                                        <li id="menu-item-245"
                                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-245">
                                                            <a href="{{ route("support") }}"><span>Customer Supports</span></a>
                                                        </li>
                                                        <li id="menu-item-190"
                                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-190">
                                                            <a href="{{ route("manage_booking") }}"><span>Manage Booking</span></a>
                                                        </li>
                                                        
                                                         {{--<li id="menu_mobile-item-179"--}}
                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179"><a--}}
                            {{--href="{{ route("airport_types") }}"--}}
                            {{--><span>Airport Types</span></a></li>--}}
                                                        {{--<li id="menu-item-179"--}}
                                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179">--}}
                                                            {{--<a href="{{ route("reviews") }}"><span>Review</span></a>--}}
                                                        {{--</li>--}}
                                                        {{--<li class="menu-item menu-collapse"--}}
                                                            {{--style="display: none;"><a href="#"--}}
                                                                                      {{--class="sf-with-ul trx_addons_icon-ellipsis-vert"></a>--}}
                                                            {{--<ul class="submenu fadeOutDownSmall animated fast"></ul>--}}
                                                        </li>

                                                    </ul>
                                                </nav><!-- /.sc_layouts_menu -->
                                                <div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
                                                    <a class="sc_layouts_item_link sc_layouts_iconed_text_link"
                                                       href="#">
                                                        <span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="sc_layouts_item sc_layouts_hide_on_mobile sc_layouts_hide_on_tablet">
                                                <div id="sc_layouts_iconed_text_69092654"
                                                     class="sc_layouts_iconed_text hide_on_tablet hide_on_mobile">
                                                    <span
                                                                class="sc_layouts_item_icon sc_layouts_iconed_text_icon icon-icon_2"></span><span
                                                                class="sc_layouts_item_details sc_layouts_iconed_text_details"><span
                                                                    class="sc_layouts_item_details_line2 sc_layouts_iconed_text_line2">02070580500
</span></span>
                                                        <!-- /.sc_layouts_iconed_text_details --></div>
                                                <!-- /.sc_layouts_iconed_text --></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.sc_content --></div>
            </div>
        </div>
    </div>
    <div class="sc_layouts_row_fixed_placeholder"
         style="background-color: rgb(21, 32, 42); height: 69px;"></div>
</header>
<div class="menu_mobile_overlay" style="display: none;"></div>
<div class="menu_mobile menu_mobile_fullscreen scheme_dark">
    <div class="menu_mobile_inner">
        <a class="menu_mobile_close icon-cancel"></a><a class="sc_layouts_logo"
                                                        href="http://www.parkingzone.co.uk/"><img
                    src="{{ secure_asset("assets/images/logo_new.png") }}" alt="" width="120"
                    height="33"></a>
        <nav class="menu_mobile_nav_area">
            <ul id="menu_mobile_116092394" class="prepared">
                <li id="menu_mobile-item-155"
                    class="">
                    <a href="{{ route("main") }}"><span>Home</span><span class=""></span></a>
                   
                </li>
                <li id="menu_mobile-item-156"
                    class="">
                    <a href="{{ route("manage_booking") }}"><span>Manage booking</span><span class=""></span></a>
                   
                        {{--</li>--}}
                        {{--<li id="menu_mobile-item-161"--}}
                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-161">--}}
                            {{--<a href="{{ route("support") }}"><span>Support</span><span class="open_child_menu"></span></a>--}}
                            {{--<ul class="sub-menu">--}}
                                {{--<li id="menu_mobile-item-164"--}}
                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-164">--}}
                                    {{--<a href="http://parkingzone.co.uk/gallery-grid/"--}}
                                       {{--target="_blank"><span>Grid</span></a></li>--}}
                                {{--<li id="menu_mobile-item-165"--}}
                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-165">--}}
                                    {{--<a href="http://parkingzone.co.uk/gallery-masonry/"--}}
                                       {{--target="_blank"><span>Masonry</span></a>--}}
                                {{--</li>--}}
                                {{--<li id="menu_mobile-item-163"--}}
                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-163">--}}
                                    {{--<a href="http://parkingzone.co.uk/gallery-cobbles/"--}}
                                       {{--target="_blank"><span>Cobbles</span></a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li id="menu_mobile-item-166"--}}
                            {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-166">--}}
                            {{--<a href="#"><span>Blog</span><span class="open_child_menu"></span></a>--}}
                            {{--<ul class="sub-menu">--}}
                                {{--<li id="menu_mobile-item-167"--}}
                                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-167">--}}
                                    {{--<a href="http://parkingzone.co.uk/all-posts/" target="_blank"><span>All Posts</span></a>--}}
                                {{--</li>--}}
                                {{--<li id="menu_mobile-item-168"--}}
                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-168">--}}
                                    {{--<a href="#"><span>Classic Style</span><span--}}
                                                {{--class="open_child_menu"></span></a>--}}
                                    {{--<ul class="sub-menu">--}}
                                        {{--<li id="menu_mobile-item-169"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-169">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-classic-2-columns/"--}}
                                               {{--target="_blank"><span>2 Columns</span></a></li>--}}
                                        {{--<li id="menu_mobile-item-170"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-170">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-classic-3-columns/"--}}
                                               {{--target="_blank"><span>3 Columns</span></a></li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li id="menu_mobile-item-171"--}}
                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-171">--}}
                                    {{--<a href="#"><span>Portfolio</span><span class="open_child_menu"></span></a>--}}
                                    {{--<ul class="sub-menu">--}}
                                        {{--<li id="menu_mobile-item-172"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-172">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-portfolio-2-columns/"--}}
                                               {{--target="_blank"><span>2 Columns</span></a></li>--}}
                                        {{--<li id="menu_mobile-item-173"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-173">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-portfolio-3-columns/"--}}
                                               {{--target="_blank"><span>3 Columns</span></a></li>--}}
                                        {{--<li id="menu_mobile-item-174"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-174">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-portfolio-4-columns/"--}}
                                               {{--target="_blank"><span>4 Columns</span></a></li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li id="menu_mobile-item-175"--}}
                                    {{--class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-175">--}}
                                    {{--<a href="#"><span>Chess Style</span><span--}}
                                                {{--class="open_child_menu"></span></a>--}}
                                    {{--<ul class="sub-menu">--}}
                                        {{--<li id="menu_mobile-item-176"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-176">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-chess-2-columns/"--}}
                                               {{--target="_blank"><span>2 Columns</span></a></li>--}}
                                        {{--<li id="menu_mobile-item-177"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-177">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-chess-4-columns/"--}}
                                               {{--target="_blank"><span>4 Columns</span></a></li>--}}
                                        {{--<li id="menu_mobile-item-178"--}}
                                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-178">--}}
                                            {{--<a href="http://parkingzone.co.uk/blog-chess-6-columns/"--}}
                                               {{--target="_blank"><span>6 Columns</span></a></li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </li>
                <li id="menu_mobile-item-290"
                    class="">
                    <a href="{{ route("faqs") }}"><span>FAQS</span><span class=""></span></a>
                    {{--<ul class="sub-menu">--}}
                        {{--<li id="menu_mobile-item-291"--}}
                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-291">--}}
                            {{--<a href="{{ route("faqs") }}" ><span>FAQS</span></a>--}}
                        {{--</li>--}}
                        {{--<li id="menu_mobile-item-292"--}}
                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-292">--}}
                            {{--<a--}}
                                    {{--href="http://parkingzone.co.uk/our-benefits/" target="_blank"><span>Our Benefits</span></a>--}}
                        {{--</li>--}}
                        {{--<li id="menu_mobile-item-203"--}}
                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-203">--}}
                            {{--<a--}}
                                    {{--href="http://parkingzone.co.uk/price-guide/" target="_blank"><span>Price Guide</span></a>--}}
                        {{--</li>--}}
                        {{--<li id="menu_mobile-item-256"--}}
                            {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-256">--}}
                            {{--<a--}}
                                    {{--href="http://parkingzone.co.uk/reservations/" target="_blank"><span>Reservations</span></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </li>
                
                <li id="menu_mobile-item-245"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-245"><a
                            href="{{ route("support") }}" ><span>Supports</span></a>
                </li>
                {{--<li id="menu_mobile-item-190"--}}
                    {{--class="menu-item menu-item-type-post_type menu-item-object-page menu-item-190"><a--}}
                            {{--href="{{ route("reviews") }}"--}}
                            {{--><span>Reviews</span></a></li>--}}
                             <li id="menu_mobile-item-179"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179"><a
                            href="{{ route("airport_types") }}"
                            ><span>Parking Types</span></a></li>
                <li id="menu_mobile-item-179"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179"><a
                            href="{{ route("airports") }}"
                            ><span>Airports</span></a></li>
            </ul>
        </nav>
        {{--<div class="search_wrap search_style_normal search_mobile inited">--}}
        {{--<div class="search_form_wrap">--}}
        {{--<form role="search" method="get" class="search_form" action="http://parkingzone.co.uk/">--}}
        {{--<input type="text" class="search_field fill_inited" placeholder="Search" value=""--}}
        {{--name="s">--}}
        {{--<button type="submit" class="search_submit trx_addons_icon-search"></button>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
           @if(array_key_exists("twitter",$site_settings_main) && $site_settings_main["twitter"] !="")
        <div class="socials_mobile"><a href="{{ $site_settings_main["twitter"] }}"
                                       class="social_item social_item_style_icons social_item_type_icons"><span
                        class="social_icon social_icon_twitter"><span
                            class="icon-twitter"></span></span></a><a
                    target="_blank" href="{{ $site_settings_main["google_plus"] }}"
                    class="social_item social_item_style_icons social_item_type_icons"><span
                        class="social_icon social_icon_gplus"><span class="icon-gplus"></span></span></a><a
                    target="_blank" href="{{ $site_settings_main["facebook"] }}"
                    class="social_item social_item_style_icons social_item_type_icons"><span
                        class="social_icon social_icon_facebook"><span class="icon-facebook"></span></span></a>
        </div>
        @endif
    </div>
</div>