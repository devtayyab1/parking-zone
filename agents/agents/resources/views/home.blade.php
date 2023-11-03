@extends('layouts.main')
@section("stylesheets")
<link property="stylesheet" rel='stylesheet'
      href='{{ secure_asset("assets/page.css") }}' type='text/css'
      media='all'/>
@endsection
@section('content')

    @php
        $site_settings_main=[];
            $settingsAll = App\settings::all();
                    foreach ($settingsAll as $setting) {
                        $site_settings_main[$setting->field_name] = $setting->field_value;
                    }
    @endphp

    <div class="page_wrap">
        @include("frontend.header")

        <div class="page_content_wrap">

            <div class="content_wrap">


                <div class="content">


                    <article class="post_item_single post_type_page post-293 page type-page status-publish hentry">


                       @include("frontend.search_new_bar")

                        <div class="vc_row-full-width vc_clearfix"></div>
                        <div data-vc-full-width="true" data-vc-full-width-init="true"
                             class="vc_row wpb_row vc_row-fluid vc_custom_1514381320126 vc_row-has-fill shape_divider_top-none shape_divider_bottom-none"
                             >
                            <div class="wpb_column vc_column_container vc_col-sm-12 sc_layouts_column_icons_position_left">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">
                                        <div class="vc_empty_space  vc_custom_1523531867392 sc_height_medium"
                                        ><span
                                                    class="vc_empty_space_inner"></span>
                                            <h3 class="sc_item_title sc_price_title sc_align_center "
                                                style="padding:20px;font-size:30px">How it works?</h3>
                                            <br/>
                                            <br/>
                                        </div>
                                        <div style="margin-top: 32px;"
                                             class="sc_services color_style_default sc_services_list sc_services_featured_left">
                                            <div class="sc_services_columns_wrap sc_item_columns sc_item_posts_container sc_item_columns_4 trx_addons_columns_wrap"
                                                 id="howitsworkdiv">
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-298 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_8_1"
                                                           class="sc_services_item_icon icon-search"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title"> {!! $site_settings_main["homepage_howitwork_grid1_heading"] !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p> {!! $site_settings_main["homepage_howitwork_grid1_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-297 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_10_2"
                                                           class="sc_services_item_icon fa fa-hand-pointer-o"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_howitwork_grid2_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_howitwork_grid2_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-296 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_9_3"
                                                           class="sc_services_item_icon fa fa-money"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_howitwork_grid3_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_howitwork_grid3_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-295 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_11_4"
                                                           class="sc_services_item_icon fa fa-thumbs-o-up"
                                                           target="_blank"></a>

                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_howitwork_grid4_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_howitwork_grid4_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.sc_services -->
                                        <div class="vc_empty_space  vc_custom_1523533145384 sc_height_medium"
                                             style="height: 32px"><span class="vc_empty_space_inner"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vc_row-full-width vc_clearfix"></div>
                        <div class="vc_row wpb_row vc_row-fluid vc_custom_1537019012176 vc_row-has-fill vc_row-o-equal-height vc_row-o-content-middle vc_row-flex shape_divider_top-none shape_divider_bottom-none scheme_dark"
                             style="
    border-radius: 13px;
    background: #1e2d3b;
">
                            <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-6 vc_col-md-6 vc_hidden-sm vc_hidden-xs vc_col-has-fill sc_layouts_column_icons_position_left">
                                <div class="vc_column-inner vc_custom_1537092073691">
                                    <div class="wpb_wrapper">
                                        <div class="wpb_single_image wpb_content_element vc_align_center">

                                            <figure class="wpb_wrapper vc_figure">
                                                <div class="vc_single_image-wrapper   vc_box_border_grey"><img
                                                            width="658" height="671"
                                                            src="{{ secure_asset("assets/front/parkingzone/images/img-home3-copyright.jpg") }}"
                                                            class="vc_single_image-img attachment-full" alt="" srcset=""
                                                            sizes="(max-width: 658px) 100vw, 658px"></div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wpb_column vc_column_container vc_col-sm-12 vc_hidden-lg vc_hidden-md sc_layouts_column_icons_position_left">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">
                                        <div class="vc_empty_space  sc_height_medium" style="height: 32px"><span
                                                    class="vc_empty_space_inner"></span></div>
                                    </div>
                                </div>
                            </div>


                            <div class="wpb_column vc_column_container vc_col-sm-10 vc_col-lg-offset-1 vc_col-lg-4 vc_col-md-offset-1 vc_col-md-4 vc_col-sm-offset-1 vc_col-xs-offset-1 sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left"
                                 id="chooseparking">
                                <div class="vc_column-inner vc_custom_1537093084771">
                                    <div class="wpb_wrapper">
                                        <div id="sc_title_1893422145"
                                             class="sc_title color_style_default sc_title_default"><h2
                                                    class="sc_item_title sc_title_title sc_align_left sc_item_title_style_default">
                                                {!! $site_settings_main["homepage_service_heading"]  !!}</h2>
                                            <div class="sc_item_descr sc_title_descr sc_align_left">
                                                <p>{!! $site_settings_main["homepage_service_descprition"]  !!}</p>
                                            </div>
                                        </div><!-- /.sc_title -->
                                        <div id="sc_services_1750719450"
                                             class="sc_services color_style_default sc_services_default sc_services_featured_top small-padding  vc_custom_1536927144745">
                                            <div class="sc_services_columns_wrap sc_item_columns sc_item_posts_container sc_item_columns_3 trx_addons_columns_wrap columns_padding_bottom">
                                                <div class="trx_addons_column-1_3">
                                                    <div class="sc_services_item no_links without_content with_number sc_services_item_featured_top post-306 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-saving">
                                                        <span class="sc_services_item_number">1</span>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h4 class="sc_services_item_title"><a href="{{ route("airportsparking") }}">{!! $site_settings_main["homepage_service1"]  !!}</a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_3">
                                                    <div class="sc_services_item no_links without_content with_number sc_services_item_featured_top post-305 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-saving">
                                                        <span class="sc_services_item_number">2</span>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h4 class="sc_services_item_title"><a href="{{ route("lounges") }}">{!! $site_settings_main["homepage_service2"]  !!}</a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_3">
                                                    <div class="sc_services_item no_links without_content with_number sc_services_item_featured_top post-304 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-saving">
                                                        <span class="sc_services_item_number">3</span>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h4 class="sc_services_item_title"><a href="{{ route("airporttransfer") }}">{!! $site_settings_main["homepage_service3"]  !!}</a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.sc_services --></div>
                                </div>
                            </div>
                            <div class="wpb_column vc_column_container vc_col-sm-12 vc_hidden-lg vc_hidden-md sc_layouts_column_icons_position_left">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">
                                        <div class="vc_empty_space  sc_height_medium" style="height: 32px"><span
                                                    class="vc_empty_space_inner"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="vc_row-full-width vc_clearfix"></div>
                        <div data-vc-full-width="true" data-vc-full-width-init="true"
                             class="vc_row wpb_row vc_row-fluid vc_custom_1514381320126 vc_row-has-fill shape_divider_top-none shape_divider_bottom-none"
                            >
                            <div class="wpb_column vc_column_container vc_col-sm-12 sc_layouts_column_icons_position_left">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">
                                        <div class="vc_empty_space  vc_custom_1523531867392 sc_height_medium"
                                        ><span
                                                    class="vc_empty_space_inner"></span>
                                            <h3 class="sc_item_title sc_price_title sc_align_center "
                                                style="padding:20px;font-size:30px">Why Choose Us</h3>
                                            <br/>
                                            <br/>
                                        </div>
                                        <div style="margin-top: 32px;"
                                             class="sc_services color_style_default sc_services_list sc_services_featured_left">
                                            <div class="sc_services_columns_wrap sc_item_columns sc_item_posts_container sc_item_columns_4 trx_addons_columns_wrap"
                                                 id="howitsworkdiv">
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-298 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_8_1"
                                                           class="sc_services_item_icon fa fa-list-ol"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_whychooseus_grid1_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_whychooseus_grid1_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-297 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_10_2"
                                                           class="sc_services_item_icon icon-icon_10"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">

                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_whychooseus_grid2_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_whychooseus_grid2_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-296 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_9_3"
                                                           class="sc_services_item_icon icon-icon_9"
                                                           target="_blank"></a>
                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_whychooseus_grid3_heading"]  !!}</h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_whychooseus_grid3_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trx_addons_column-1_4">
                                                    <div class="sc_services_item without_content no_links with_icon sc_services_item_featured_left post-295 cpt_services type-cpt_services status-publish has-post-thumbnail hentry cpt_services_group-features">
                                                        <a id="sc_services_272342294_icon-icon_11_4"
                                                           class="sc_services_item_icon icon-icon_11"
                                                           target="_blank"></a>

                                                        <div class="sc_services_item_info">
                                                            <div class="sc_services_item_header">
                                                                <h6 class="sc_services_item_title">{!! $site_settings_main["homepage_whychooseus_grid4_heading"]  !!}
                                                                </h6>
                                                            </div>
                                                            <div class="sc_services_item_content">
                                                                <p>{!! $site_settings_main["homepage_whychooseus_grid4_descp"]  !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.sc_services -->
                                        <div class="vc_empty_space  vc_custom_1523533145384 sc_height_medium"
                                             style="height: 32px"><span class="vc_empty_space_inner"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="vc_row-full-width vc_clearfix"></div>
                </div><!-- .entry-content -->


                </article>

            </div><!-- </.content> -->

        </div><!-- </.content_wrap> -->


@endsection
