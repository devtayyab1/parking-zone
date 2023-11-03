
<head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title> Dashboard</title>

        <meta name="description" content="overview &amp; stats" />
     
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="title" content="Airport Parking, Airport Hotels and Airport Lounges">
        <meta name="keywords" content="airport parking, airport car parking, parking airport, cheap airport parking, airport, parking, car, park">
        <meta content="The UK most popular choice for Airport Parking, parkingzone give you the best deals at Gatwick, Heathrow, Stansted, Manchester and all major UK airports."  name="description">
        <meta name="author" content="">
        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ secure_asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />


@section('stylesheets')

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/fonts.googleapis.com.css') }}" />

        <!-- ace styles -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-skins.min.css') }}" />
        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-rtl.min.css') }}" />

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-ie.min.css') }}" />
        <![endif]-->
@show

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="{{ secure_asset('assets/js/ace-extra.min.js') }}"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="{{ secure_asset('assets/js/html5shiv.min.js') }}"></script>
        <script src="{{ secure_asset('assets/js/respond.min.js') }}"></script>

        <![endif]-->
        <!--[if !IE]> -->
        <script src="{{ secure_asset("assets/js/jquery-2.1.4.min.js") }}"></script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script src="{{ secure_asset("assets/js/jquery-1.11.3.min.js") }}"></script>
        <![endif]-->
        <style type="text/css">
                /* Absolute Center Spinner */
                .loading {
                        position: fixed;
                        z-index: 999;
                        height: 2em;
                        width: 2em;
                        overflow: show;
                        margin: auto;
                        top: 0;
                        left: 0;
                        bottom: 0;
                        right: 0;
                }

                /* Transparent Overlay *//* Absolute Center Spinner */
                .loading {
                        position: fixed;
                        z-index: 999;
                        height: 2em;
                        width: 2em;
                        overflow: show;
                        margin: auto;
                        top: 0;
                        left: 0;
                        bottom: 0;
                        right: 0;
                }

                /* Transparent Overlay */
                .loading:before {
                        content: "";
                        display: block;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: radial-gradient(rgba(20, 20, 20, 0.8), rgba(0, 0, 0, 0.8));

                        background: -webkit-radial-gradient(
                                rgba(20, 20, 20, 0.8),
                                rgba(0, 0, 0, 0.8)
                        );
                }

                /* :not(:required) hides these rules from IE9 and below */
                .loading:not(:required) {
                        /* hide "loading..." text */
                        font: 0/0 a;
                        color: transparent;
                        text-shadow: none;
                        background-color: transparent;
                        border: 0;
                }

                .loading:not(:required):after {
                        content: "";
                        display: block;
                        font-size: 10px;
                        width: 1em;
                        height: 1em;
                        margin-top: -0.5em;
                        -webkit-animation: spinner 1500ms infinite linear;
                        -moz-animation: spinner 1500ms infinite linear;
                        -ms-animation: spinner 1500ms infinite linear;
                        -o-animation: spinner 1500ms infinite linear;
                        animation: spinner 1500ms infinite linear;
                        border-radius: 0.5em;
                        -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0,
                        rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0,
                        rgba(255, 255, 255, 0.75) 0 1.5em 0 0,
                        rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0,
                        rgba(255, 255, 255, 0.75) -1.5em 0 0 0,
                        rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0,
                        rgba(255, 255, 255, 0.75) 0 -1.5em 0 0,
                        rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
                        box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0,
                        rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0,
                        rgba(255, 255, 255, 0.75) 0 1.5em 0 0,
                        rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0,
                        rgba(255, 255, 255, 0.75) -1.5em 0 0 0,
                        rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0,
                        rgba(255, 255, 255, 0.75) 0 -1.5em 0 0,
                        rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
                }

                /* Animation */

                @-webkit-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @-moz-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @-o-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }

                .loading:before {
                        content: '';
                        display: block;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

                        background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
                }

                /* :not(:required) hides these rules from IE9 and below */
                .loading:not(:required) {
                        /* hide "loading..." text */
                        font: 0/0 a;
                        color: transparent;
                        text-shadow: none;
                        background-color: transparent;
                        border: 0;
                }

                .loading:not(:required):after {
                        content: '';
                        display: block;
                        font-size: 10px;
                        width: 1em;
                        height: 1em;
                        margin-top: -0.5em;
                        -webkit-animation: spinner 1500ms infinite linear;
                        -moz-animation: spinner 1500ms infinite linear;
                        -ms-animation: spinner 1500ms infinite linear;
                        -o-animation: spinner 1500ms infinite linear;
                        animation: spinner 1500ms infinite linear;
                        border-radius: 0.5em;
                        -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
                        box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
                }

                /* Animation */

                @-webkit-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @-moz-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @-o-keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
                @keyframes spinner {
                        0% {
                                -webkit-transform: rotate(0deg);
                                -moz-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                -o-transform: rotate(0deg);
                                transform: rotate(0deg);
                        }
                        100% {
                                -webkit-transform: rotate(360deg);
                                -moz-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                -o-transform: rotate(360deg);
                                transform: rotate(360deg);
                        }
                }
        </style>

    </head>
<div class="loading" id="loader_ajax" style="display: none;">Loading&#8230;</div>