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

Route::get('/aphinfo', 'front\HomeController@getAphInfo')->name("aphinfo");

Route::get('/resultfortravelez', 'front\HomeController@getSearchResultForTravelez')->name("resultfortravelez"); //return json response

Route::get('/result', 'front\HomeController@getSearchResult')->name("searchresult");

Route::post('/booking', 'front\HomeController@addBookingForm')->name("addBookingForm");

Route::post('/loadinfo', 'front\HomeController@loadinfo')->name("loadinfo");

Route::get('/booking/incomplete/{id}', 'front\HomeController@addBookingFormincomplete')->name("addBookingForm2");

Route::post('/checkBooking', 'front\BookingController@checkBooking')->name("checkBooking");

Route::post('/booking/checkout', 'front\BookingController@checkout')->name("checkout");

Route::post('/booking/incomplete/booking/checkout', 'front\BookingController@checkout')->name("checkout1");

Route::post('/booking/payout', 'front\BookingController@paymentwithstripe')->name("paymentwithstripe");

Route::post('/booking/payout_failed', 'front\BookingController@payout_failed')->name("payout_failed");

Route::get('/booking/thankyou/{id}', 'front\BookingController@thanyou')->name("thankyou");

Route::post('/booking/paymentwithPayzone', 'front\BookingController@paymentwithPayzone')->name("paymentwithPayzone");


Route::get('/searchresult_lounge', 'front\HomeController@getSearchResultLounge')->name("searchresult_lounge");

Route::post('/searchresult_lounge', 'front\HomeController@getSearchResultLounge')->name("searchresult_lounge");

Route::post('/booking_lounge', 'front\LoungeController@addBookingFormLounge')->name("addBookingFormLounge");

Route::post('/lounge_checkout', 'front\LoungeController@lounge_checkout')->name("lounge_checkout");

Route::post('/checkBookingLounge', 'front\LoungeController@checkBookingLounge')->name("checkBookingLounge");

Route::post('booking/payout_lounge', 'front\LoungeController@payout_lounge')->name("payout_lounge");

Route::post('booking/payout_failed_lounge', 'front\LoungeController@payout_failed_lounge')->name("payout_failed_lounge");

Route::get('/booking_lounge/thankyou/{id}', 'front\LoungeController@thankyou')->name("thankyou_lounge");


Route::post('/searchresult_transfer', 'front\HomeController@getSearchResultTransfer')->name("searchresult_transfer");

Route::post('/get_location_suggestion', 'front\TransferController@get_location_suggestion')->name("get_location_suggestion");

Route::post('/get_location_suggestion_drop', 'front\TransferController@get_location_suggestion_drop')->name("get_location_suggestion_drop");

Route::post('/booking_transfer', 'front\TransferController@addBookingFormTransfer')->name("addBookingFormTransfer");

Route::post('/transfer_checkout', 'front\TransferController@transfer_checkout')->name("transfer_checkout");

Route::post('/checkBookingTransfer', 'front\TransferController@checkBookingTransfer')->name("checkBookingTransfer");
Route::post('booking/payout_failed_transfer', 'front\TransferController@payout_failed_transfer')->name("payout_failed_transfer");

Route::post('booking/payout_transfer', 'front\TransferController@payout_transfer')->name("payout_transfer");

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

Route::post('/reSendEmailBooking', 'front\BookingController@reSendEmailBooking')->name("reSendEmailBooking");



Route::get('/admin/export_subscriber_excel', 'SubscribersController@export_subscriber_excel')->name("export_subscriber_excel");

Route::get('/admin/export_customer_excel', 'CustomerController@export_customer_excel')->name("export_customer_excel");



Route::get('faqs', 'front\HomeController@faqs')->name("faqs");

Route::get('faqs_pages', 'front\HomeController@faqs_pages')->name("faqs_pages");

Route::get('parkingzone-reviews', 'front\HomeController@reviews')->name("reviews");

Route::get('parkingzone-reviews2', 'front\HomeController@reviews2')->name("reviews2"); 

Route::get('airport-guide', 'front\HomeController@airport_guide')->name("airport_guide");

Route::get('airport-types', 'front\HomeController@airport_types')->name("airport_types");

Route::post('/subscribe_user', 'front\HomeController@subscribe_user')->name("subscribe_user");


Route::get('/sitemap', 'front\HomeController@sitemap')->name("sitemap");

Route::get('/airport-parking', 'front\HomeController@airportsparking')->name("airportsparking");

Route::get('/airport-transfer', 'front\HomeController@airporttransfer')->name("airporttransfer");

Route::get('/lounges', 'front\HomeController@lounges')->name("lounges");



Route::get('/feedback', 'front\HomeController@feedback')->name("feedback");

Route::post('/feedback', 'front\HomeController@store')->name("submit-feedback");

Route::get('/contact-us', 'front\HomeController@contact')->name("contact-us");
Route::post('/contact-us-submit', 'front\HomeController@contactUsSubmit')->name("contact-us-submit");

Route::get('/blogs', 'front\HomeController@blogs')->name("blogs");

Route::get('blog/{slug}', 'front\HomeController@blog_detail')->name("blog_detail");

//Route::get('/send', 'EmailController@send'); //for email test













//admin routes

Route::get('/admin', 'dashboard@index');

Route::get('/admin/company/setPlan', 'CompaniesProductPriceController@setPlan')->name("setPlan");

Route::get('/admin/company/delPlan/{id}', 'CompaniesProductPriceController@delPlan')->name("delPlan");

Route::get('/admin/company/viewEditPlan', 'CompaniesProductPriceController@viewEditPlan')->name("viewEditPlan");

Route::get('/admin/company/getPlanPrices/{id}', 'CompaniesProductPriceController@getPlanPrices')->name("getPlanPrices");





Route::get('/admin/company/getTerminals/{id}', 'CompanyController@getTerminalsByAirportId')->name("getterminals");

Route::get('/admin/company/create_lounge', 'CompanyController@create_lounge')->name("create_lounge");

Route::post('/admin/company/store_lounge', 'CompanyController@store_lounge')->name("store_lounge");

Route::get('/admin/company/getPlanView/{id}', 'CompaniesProductPriceController@getProductPricePlanView')->name("getplanview");

Route::get('/admin/company/getCompanySetPlanView/{id}/{year}/{month}', 'CompaniesProductPriceController@getCompanySetPlanView')->name("getCompanySetPlanView");

Route::get('/admin/booking/add', 'BookingController@create')->name("add-booking");

Route::post('/admin/booking/get-quote', 'BookingController@getQuote')->name("getQuote");

Route::get('/admin/booking/incomplete', 'BookingController@incomplete_Booking')->name("incomplete_Booking");

Route::get('/admin/booking/bookinghistroy', 'BookingController@bookinghistroy')->name("bookinghistroy");


Route::get('/admin/daywisereport', 'BookingController@daywisereport')->name("day_wise_Booking");
Route::get('/admin/overnightreport', 'BookingController@overnightreport')->name("Overnight_Booking");

Route::get('/admin/banner/banner_list', 'SettingsController@bannerlist')->name("banner_list");

Route::post('/admin/banner/banner_list', 'SettingsController@UploadBannerList')->name("upload_banner_list");


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
 
Route::get('/admin/agent_bookings', 'BookingController@agent_bookings')->name("agent_bookings");

Route::post('/admin/booking/incomplete', 'BookingController@search')->name("Incomplete");

Route::get('/admin/ticket/updateTicketStatus/{id}', 'BackendticketController@updateTicketStatus')->name("updateTicketStatus");

Route::post('/admin/ticket/assignTicket', 'BackendticketController@assignTicket')->name("assignTicket");



Route::get('/admin/reports/company_departure_commission_report', 'InvoicesController@CompanyDepartureCommissionReport')->name("company_departure_report"); 

Route::get('/admin/reports/CompanyDepartureReportExcel', 'InvoicesController@CompanyDepartureReportExcel')->name("company_departure_report_excel");
 
Route::get('/admin/reports/CompanyDepartureDetailReportExcel', 'InvoicesController@CompanyDepartureReportExcelPZ')->name("company_departure_detail_report_excel");





Route::get('/admin/invoices', 'InvoicesController@searchForm')->name("searchForm");

Route::post('/admin/invoices', 'InvoicesController@searchForm')->name("searchFormSubmit");

Route::get('/admin/invoicesDetailInvoice', 'InvoicesController@invoicesDetailInvoice')->name("invoicesDetailInvoice");

Route::get('/admin/invoicesummery', 'InvoicesController@invoiceSummery')->name("invoiceSummery");







Route::post('/admin/booking/admin_add_booking', 'BookingController@store')->name("admin_add_booking");

Route::post('/admin/booking/cancelFormAction', 'BookingController@cancelFormAction')->name("cancelFormAction");




Route::get('/admin/booking_lounge', 'LoungeController@index')->name("booking_lounge");
Route::post('/admin/booking_lounge/showdetail', 'LoungeController@showdetail')->name("bookingdetail_lounge");
Route::post('/admin/booking_lounge/sendEmailLounge', 'LoungeController@sendEmailBooking')->name("sendEmailBookingLounge");
Route::post('/admin/booking_lounge/cancelBookingLounge', 'LoungeController@cancelBookingLounge')->name("cancelBookingLounge");
Route::post('/admin/booking_lounge/cancelForm', 'LoungeController@cancelForm')->name("bookingdetail_lounge.cancelForm");
Route::post('/admin/booking_lounge/refundForm', 'LoungeController@refundForm')->name("bookingdetail_lounge.refundForm");
Route::post('/admin/booking_lounge/cancelFormActionLounge', 'LoungeController@cancelFormActionLounge')->name("cancelFormActionLounge");
Route::get('/admin/booking_lounge/incomplete', 'LoungeController@incomplete_Booking')->name("incomplete_Booking_lounge");
Route::get('/admin/booking_lounge/bookinghistory', 'LoungeController@bookinghistory')->name("bookinghistory_lounge");
Route::get('/admin/booking_lounge/edit/{id}', 'LoungeController@edit')->name("edit_booking_form_lounge");
Route::post('/admin/booking_lounge/update', 'LoungeController@update')->name("update_lounge_booking");




Route::post('/admin/company/updateProductPrices/', 'CompaniesProductPriceController@updateProductPrices');

Route::post('/admin/company/setCompanyPlanPrices/', 'CompaniesProductPriceController@setCompanyPlanPrices');

Route::get('/admin/settings/seo-setting', 'SettingsController@seo_setting')->name("seo_setting");

Route::get('/admin/settings/api-setting', 'SettingsController@api_settings')->name("api_settings");

Route::post('/admin/settings/update-api-settings', 'SettingsController@update_api_settings')->name("settings.update-api-settings");

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

Route::post('/admin/booking/showhistory', 'BookingController@showhistory')->name("bookingdetail.showhistory");

Route::post('/admin/booking/transferBooking', 'BookingController@transferBooking')->name("transferBooking");

Route::get('/admin/booking/cancelNotShow/{id}', 'BookingController@cancelNotShow')->name("cancelNotShow");





Route::get('/admin/role/create', 'RoleController@create')->name("roleCreate");

Route::get('/admin/role/getMenusByIdjson/{id}', 'RoleController@getMenusByIdjson')->name("getMenusByIdjson");

Route::get('/admin/role/getRolesDD', 'RoleController@getRolesDD')->name("getRolesDD");

Route::post('/admin/role/updateMenuSortOrder', 'RoleController@updateMenuSortOrder')->name("updateMenuSortOrder");

Route::post('/admin/role/createRole', 'RoleController@createRole')->name("createRole");

Route::post('/admin/role/creat_clone', 'RoleController@creat_clone')->name("creat_clone");

Route::post('/admin/role/insertMenu', 'RoleController@insertMenu')->name("insertMenu");

Route::post('/admin/role/getEdata', 'RoleController@getEdata')->name("getEdata");

Route::post('/admin/role/delMenu', 'RoleController@delMenu')->name("delMenu");









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

Route::get('/admin/users/getSources/{role_name}','UserController@getSources')->name("getSources");

Route::get('/admin/booking/booking_report_pdf','BookingController@admin_booking_report_pdf')->name("admin_booking_report_pdf");

Route::get('/admin/booking/booking_report_pdf_agent','BookingController@admin_booking_report_pdf_agent')->name("admin_booking_report_pdf_agent");

Route::get('/admin/booking/booking_report_excel', 'BookingController@admin_booking_report_excel')->name("admin_booking_report_excel");

Route::get('/admin/booking/agent_booking_report_excel', 'BookingController@admin_booking_report_excel_agent')->name("admin_booking_report_excel_agent");

Route::get('/admin/send_sms/{number}/{ref}', 'SMSController@send_sms')->name("send_sms");




//Route::get('/admin/airport/{name?}', 'AirportController@index')->name("airport.index");

Route::resource('/admin/airport','AirportController');



















Route::resource('/admin/company','CompanyController');

Route::resource('/admin/agent','PartnersController');

Route::resource('/admin/awards','AwardsController');

Route::resource('/admin/company/plan','CompaniesProductPriceController');

Route::resource('/admin/pages','PagesController');

//Route::resource('/admin/reviews','ReviewsController');

Route::resource('/admin/faqs','FaqsController');

Route::resource('/admin/reviews','ReviewsController');

Route::resource('/admin/subscribers','SubscribersController');

Route::resource('/admin/customers','CustomerController');

Route::resource('/admin/discounts','DiscountsController');

Route::resource('/admin/emails','EmailTemplatesController');





Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name("adminLogout");

Route::get('{page}', 'front\HomeController@static_page')->name("static_page");

Route::get('/admin/agentbooking', 'BookingController@agentbooking')->name("agentbooking");

Route::get('/cron/incomplete', 'CronController@index')->name("cron_incomplete");

Route::get('/cron/mailchimp', 'CronController@sendmails_mailchimp')->name("mailchimp");