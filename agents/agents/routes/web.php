<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//front routes
Route::get('/', 'front\HomeController@index')->name("main");
Route::get('/search', 'front\HomeController@search')->name("search");
Route::post('/result', 'front\HomeController@getSearchResult')->name("searchresult");
Route::post('/booking', 'front\HomeController@addBookingForm')->name("addBookingForm");
Route::post('/checkBooking', 'front\BookingController@checkBooking')->name("checkBooking");
Route::post('/booking/checkout', 'front\BookingController@checkout')->name("checkout");
Route::post('/booking/payout', 'front\BookingController@paymentwithstripe')->name("paymentwithstripe");
Route::get('/booking/thankyou/{id}', 'front\BookingController@thanyou')->name("thankyou");
Route::post('/booking/paymentwithPayzone', 'front\BookingController@paymentwithPayzone')->name("paymentwithPayzone");

Route::get('/airport/{slug}', 'front\HomeController@page')->name("page");
Route::get('/airports', 'front\HomeController@airports')->name("airports");
Route::get('/support', 'TicketsController@index')->name("support");
Route::post('/store', 'TicketsController@store')->name("submit-ticket");
Route::post('/submit-reply', 'TicketsController@submit_reply')->name("submit-reply");
Route::post('/addNote', 'BackendticketController@addNote')->name("addNote");
Route::post('/search-ticket', 'TicketsController@search_ticket')->name("search_ticket");
//Route::post('/booking-ticket', 'front\BookingController@booking_search')->name("booking_search");
Route::get('/ticket/view/{id}', 'TicketsController@view')->name("view-ticket");
Route::get('/manage-booking', 'front\BookingController@manage_booking')->name("manage_booking");
Route::post('/booking-search', 'front\BookingController@booking_search')->name("booking_search");


Route::get('faqs', 'front\HomeController@faqs')->name("faqs");
Route::get('parkingzone-reviews', 'front\HomeController@reviews')->name("reviews");
Route::get('airport-guide', 'front\HomeController@airport_guide')->name("airport_guide");
Route::get('airport-types', 'front\HomeController@airport_types')->name("airport_types");
Route::post('/subscribe_user', 'front\HomeController@subscribe_user')->name("subscribe_user");
Route::get('/sitemap', 'front\HomeController@sitemap')->name("sitemap");
Route::get('/airportsparking', 'front\HomeController@airportsparking')->name("airportsparking");
Route::get('/airporttransfer', 'front\HomeController@airporttransfer')->name("airporttransfer");
Route::get('/lounges', 'front\HomeController@lounges')->name("lounges");

Route::get('/feedback', 'front\HomeController@feedback')->name("feedback");
Route::post('/feedback', 'front\HomeController@store')->name("submit-feedback");
Route::get('/contact-us', 'front\HomeController@contact')->name("contact-us");

//Route::get('/send', 'EmailController@send'); //for email test






//admin routes
Route::get('/admin', 'dashboard@index');
Route::get('/admin/company/setPlan', 'CompaniesProductPriceController@setPlan')->name("setPlan");

Route::get('/admin/company/getTerminals/{id}', 'CompanyController@getTerminalsByAirportId')->name("getterminals");
Route::get('/admin/company/getPlanView/{id}', 'CompaniesProductPriceController@getProductPricePlanView')->name("getplanview");
Route::get('/admin/company/getCompanySetPlanView/{id}/{year}/{month}', 'CompaniesProductPriceController@getCompanySetPlanView')->name("getCompanySetPlanView");
Route::get('/admin/booking/add', 'BookingController@create')->name("add-booking");
Route::post('/admin/booking/get-quote', 'BookingController@getQuote')->name("getQuote");
Route::get('/admin/booking/incomplete', 'BookingController@incomplete_Booking')->name("incomplete_Booking");
Route::get('/admin/booking/bookinghistroy', 'BookingController@bookinghistroy')->name("bookinghistroy");
Route::get('/admin/banner/banner_list', 'SettingsController@bannerlist')->name("banner_list");
Route::get('/admin/tickets/getNewMessages', 'BackendticketController@getNewMessages')->name("getNewMessages");


Route::get('/admin/reports/airport_commission_report', 'InvoicesController@ParkingzoneDeailCommissionReport')->name("airport_commission_report");

Route::get('/admin/reports/CompanyCommissionReport', 'InvoicesController@CompanyCommissionReport')->name("company_report");
Route::get('/admin/reports/CompanyReportExcelPZ', 'InvoicesController@CompanyReportExcelPZ')->name("companypz_report_excel");
Route::get('/admin/reports/CompanyReportExcel', 'InvoicesController@CompanyReportExcel')->name("company_report_excel");
Route::get('/admin/reports/invoiceOperationExcel', 'InvoicesController@invoiceOperationExcel')->name("invoice_operation_report_excel");
Route::get('/admin/reports/invoiceOperation', 'InvoicesController@invoiceOperation')->name("invoice_commission_report");
//Route::post('/admin/reports/CompanyCommissionReport', 'InvoicesController@CompanyCommissionReport')->name("company_report");

//Route::get('/admin/invoices/invoice_commission_report', 'BookingController@invoice_commission_report')->name("invoice_commission_report");
Route::get('/admin/dsp/dsp', 'BookingController@dsp')->name("dsp");
Route::get('/admin/dsp/dspview', 'BookingController@dspview')->name("dspview");

Route::get('/admin/myticket', 'BackendticketController@myticket')->name("myticket");
Route::get('/admin/myticket/view/{id}', 'BackendticketController@myticketview')->name("myticketview");
Route::get('/admin/booking', 'BookingController@index')->name("booking");
Route::post('/admin/booking/incomplete', 'BookingController@search')->name("Incomplete");
Route::get('/admin/ticket/updateTicketStatus/{id}', 'BackendticketController@updateTicketStatus')->name("updateTicketStatus");
Route::post('/admin/ticket/assignTicket', 'BackendticketController@assignTicket')->name("assignTicket");



Route::get('/admin/invoices', 'InvoicesController@searchForm')->name("searchForm");
Route::post('/admin/invoices', 'InvoicesController@searchForm')->name("searchFormSubmit");
Route::get('/admin/exportinvoice', 'InvoicesController@invoicesDetailInvoice')->name("invoicesDetailInvoice");
Route::get('/admin/invoicesummery', 'InvoicesController@invoiceSummery')->name("invoiceSummery");



Route::post('/admin/booking/admin_add_booking', 'BookingController@store')->name("admin_add_booking");
Route::post('/admin/booking/cancelFormAction', 'BookingController@cancelFormAction')->name("cancelFormAction");



Route::post('/admin/company/updateProductPrices/', 'CompaniesProductPriceController@updateProductPrices');
Route::post('/admin/company/setCompanyPlanPrices/', 'CompaniesProductPriceController@setCompanyPlanPrices');
Route::get('/admin/settings/seo-setting', 'SettingsController@seo_setting')->name("seo_setting");
Route::get('/admin/settings/social-setting', 'SettingsController@social_setting')->name("social_setting");
Route::get('/admin/settings/company-setting', 'SettingsController@company_setting')->name("company_setting");
Route::get('/admin/settings/email-setting', 'SettingsController@email_setting')->name("email_setting");

Route::get('/admin/settings/homepage-setting', 'SettingsController@homepage_setting')->name("homepage_setting");
Route::get('/admin/settings/service-page-setting', 'SettingsController@services_page_setting')->name("services_page_setting");


Route::get('/admin/settings/general-setting', 'SettingsController@general_setting')->name("general_setting");
Route::get('/admin/settings/footer-setting', 'SettingsController@footer_setting')->name("footer_setting");
Route::get('/admin/settings/analytics-setting', 'SettingsController@analytics_setting')->name("analytics_setting");
Route::post('/admin/settings/update', 'SettingsController@update')->name("settings.update");
Route::post('/admin/settings/updateModuleSettings', 'SettingsController@updateModuleSettings')->name("settings.updateModuleSettings");
Route::post('/admin/booking/sendEmailBooking', 'BookingController@sendEmailBooking')->name("booking.sendEmailBooking");
Route::post('/admin/booking/showdetail', 'BookingController@showdetail')->name("bookingdetail.show");
Route::post('/admin/booking/cancelForm', 'BookingController@cancelForm')->name("bookingdetail.cancelForm");
Route::post('/admin/booking/refundForm', 'BookingController@refundForm')->name("bookingdetail.refundForm");

Route::post('/admin/booking/transferBooking', 'BookingController@transferBooking')->name("transferBooking");
Route::post('/admin/booking/update/{id}', 'BookingController@update')->name("admin_update_booking");
Route::get('/admin/booking/edit/{id}', 'BookingController@edit')->name("edit_booking_form");

Route::get('/admin/booking/transferBooking/{id}', 'BookingController@transferBookingForm')->name("transferBookingForm");
Route::put('/admin/users/update/{airports}', 'UserController@update_user')->name("update_user");


//register
Route::get('/admin/users/create', 'UserController@register_form')->name("register_form");
Route::get('/admin/users/edit/{id}', 'UserController@edit_register_form')->name("edit_register_form");
Route::post('/admin/users/create','UserController@register')->name("registerstore");
Route::get('/admin/users','UserController@index')->name("user_list");
Route::delete('/admin/users/{id}','UserController@delete')->name("delete_user");
Route::get('/admin/users/getPermissions/{role_name}','UserController@getRolesPermissions')->name("getRolesPermissions");

Route::get('/admin/booking/booking_report_pdf','BookingController@admin_booking_report_pdf')->name("admin_booking_report_pdf");
Route::get('/admin/booking/booking_report_excel', 'BookingController@admin_booking_report_excel')->name("admin_booking_report_excel");


//Route::get('/admin/airport/{name?}', 'AirportController@index')->name("airport.index");
Route::resource('/admin/airport','AirportController');









Route::resource('/admin/company','CompanyController');
Route::resource('/admin/awards','AwardsController');
Route::resource('/admin/company/plan','CompaniesProductPriceController');
Route::resource('/admin/pages','PagesController');
Route::resource('/admin/reviews','ReviewsController');
Route::resource('/admin/faqs','FaqsController');
Route::resource('/admin/subscribers','SubscribersController');
Route::resource('/admin/discounts','DiscountsController');
Route::resource('/admin/emails','EmailTemplatesController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name("adminLogout");




Route::get('{page}', 'front\HomeController@static_page')->name("static_page");


