<?php
namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
require SYSTEMPATH . 'Config/Routes.php';
}
/*
* --------------------------------------------------------------------
* Router Setup
* --------------------------------------------------------------------
*/
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/*
* --------------------------------------------------------------------
* Route Definitions
* --------------------------------------------------------------------
*/
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('item-details/(:any)/(:any)', 'Home::itemDetails/$1/$2');
$routes->post('marketPlaceSubmitInquiry/', 'Home::marketPlaceSubmitInquiry');
$routes->get('login/', 'Home::login');
$routes->get('register', 'UserController::register');
$routes->get('forgotPassword', 'UserController::forgotPassword');
$routes->match(['get', 'post'],'forgotPasswordMobileStep', 'UserController::forgotPasswordMobileStep');
$routes->match(['get', 'post'],'forgotPasswordMobileStepVerify', 'UserController::forgotPasswordMobileStepVerify');
$routes->match(['get', 'post'],'forgotPasswordOTP', 'UserController::forgotPasswordOTP');
$routes->post('forgotPasswordOTPVerify', 'UserController::forgotPasswordOTPVerify');
$routes->match(['get', 'post'],'forgotPasswordMobileWrongOTP', 'UserController::forgotPasswordMobileWrongOTP');
$routes->get('resetPassword', 'UserController::resetPassword');
$routes->post('resetPasswordData', 'UserController::resetPasswordData');
$routes->post('storeCompany', 'UserController::storeCompany');
$routes->get('company_details/(:any)', 'UserController::company_details/$1');
$routes->post('storeCompanyDetails', 'UserController::storeCompanyDetails');
$routes->get('otp_validation/(:any)', 'UserController::otp_validation/$1');
$routes->post('otpVerification/(:any)', 'UserController::otpVerification/$1');
$routes->get('skipMobileOTP/(:any)', 'UserController::skipMobileOTP/$1');
$routes->get('otpEmailValidation/(:any)', 'UserController::otpEmailValidation/$1');
$routes->get('emailVerify/(:any)', 'UserController::emailVerify/$1');
$routes->get('emailVerifySuccess', 'UserController::emailVerifySuccess');
$routes->get('resendOTP/(:any)', 'UserController::resendOTP/$1');
$routes->get('resendEmail/(:any)', 'UserController::resendEmail/$1');
$routes->get('companyRegistration/(:any)', 'CompanyController::companyRegistration/$1');
$routes->post("storeLogin/", "CompanyController::storeLogin");
$routes->post("companyRegistrationStepOneData/", "CompanyController::companyRegistrationStepOneData");
$routes->post("companyRegistrationStepTwoData/", "CompanyController::companyRegistrationStepTwoData");
$routes->post("companyRegistrationStepThreeData/", "CompanyController::companyRegistrationStepThreeData");
$routes->post("companyRegistrationStepFourData/", "CompanyController::companyRegistrationStepFourData");
$routes->post('checkEmail', 'UserController::checkEmail');
$routes->post('checkMobile', 'UserController::checkMobile');
$routes->post('sendOTP', 'UserController::sendOTP');
$routes->post('verifyOTP', 'UserController::verifyOTP');
$routes->get('page/(:any)', 'UserController::page/$1');

$routes->match(['get', 'post'],'getFilterData', 'Home::getFilterData');
$routes->get('testMail', 'Home::testMail');

$routes->group("admin", ["namespace" => "App\Controllers\Admin"], function($routes){
	$routes->get("/", "AdminController::dashboard");
	$routes->get("login/", "AdminController::login");
	$routes->get("logout/", "AdminController::logout");
	$routes->get("dashboard/", "AdminController::dashboard");
	$routes->get("category/", "AdminController::category");	
	/* member type */
		$routes->get("memberCategory/", "AdminController::memberCategory");
		$routes->match(['get', 'post'], "addMemberType/", "AdminController::addMemberType");
		$routes->match(['get', 'post'], "updateMemberType/(:any)", "AdminController::updateMemberType/$1");
		$routes->get("deleteMemberType/(:any)", "AdminController::deleteMemberType/$1");		
	/* member type */
	$routes->get("addBusinessCategory/", "AdminController::addBusinessCategory");
	$routes->get("addMemberCategory/", "AdminController::addMemberCategory");
	$routes->post("addBusinessCategoryData/", "AdminController::addBusinessCategoryData");
	
	$routes->get("deleteBusinessCategory/(:any)", "AdminController::deleteBusinessCategory/$1");
	$routes->post("loginCheck/", "AdminController::loginCheck");
	$routes->get("memberList/", "AdminController::memberList");
	$routes->get("memberTypeWiseList/(:any)", "AdminController::memberTypeWiseList/$1");
	$routes->get("approvalRequest/", "AdminController::approvalRequest");
	$routes->get("setting/", "AdminController::setting");
	$routes->post("adminSettingData/", "AdminController::adminSettingData");
	$routes->post("profileSettingData/", "AdminController::profileSettingData");
	$routes->post("emailSettingData/", "AdminController::emailSettingData");
	$routes->post("paymentSettingData/", "AdminController::paymentSettingData");
	$routes->post("smsSettingData/", "AdminController::smsSettingData");
	$routes->post("bankSettingData/", "AdminController::bankSettingData");
	$routes->get("memberDetail/(:any)", "AdminController::memberDetail/$1");
	$routes->get("memberDelete/(:any)", "AdminController::memberDelete/$1");
	$routes->get("approveCompanyData/(:any)", "AdminController::approveCompanyData/$1");
	$routes->post("companyComment/", "AdminController::companyComment");
	$routes->get("emailSetting/", "AdminController::emailSetting/");
	$routes->get("editEmailTemplate/(:any)", "AdminController::editEmailTemplate/$1");
	$routes->post("adminEmailData/", "AdminController::adminEmailData");
	$routes->get("manageEnquiry/", "AdminController::manageEnquiry");
	$routes->get("editCompany/(:any)", "AdminController::editCompany/$1");
	$routes->post("editMemberDetailsData/", "AdminController::editMemberDetailsData");
	$routes->get("editCompanyUnit/(:any)/(:any)", "AdminController::editCompanyUnit/$1/$2");
	$routes->post("editCompanyUnitData/", "AdminController::editCompanyUnitData");
	$routes->get("editBusinessCategory/(:any)", "AdminController::editBusinessCategory/$1");
	$routes->post("editBusinessCategoryData/", "AdminController::editBusinessCategoryData");
	$routes->get("emailLogs/", "AdminController::emailLogs");
	$routes->get("enquiryApp/", "AdminController::enquiryApp");
	/* member module */
		$routes->get("memberAdd/", "MemberController::memberAdd");
		$routes->post("memberAdd/", "MemberController::memberAdd");
		$routes->get("memberCompanyProfile/(:any)", "MemberController::memberCompanyProfile/$1");
		$routes->post("memberCompanyProfileStore", "MemberController::memberCompanyProfileStore");
		$routes->get("memberAddressProfile/(:any)", "MemberController::memberAddressProfile/$1");
		$routes->post("memberAddressProfileStore", "MemberController::memberAddressProfileStore");
		$routes->get("memberBankProfile/(:any)", "MemberController::memberBankProfile/$1");
		$routes->post("memberBankProfileStore", "MemberController::memberBankProfileStore");
		$routes->post("checkCompanyName/", "MemberController::checkCompanyName");
		$routes->post("checkMemberEmail/", "MemberController::checkMemberEmail");
		$routes->post("checkMemberPhone/", "MemberController::checkMemberPhone");
	/* member module */
	/* document list */
		$routes->get("documentList/", "AdminController::documentList");
		$routes->match(['get', 'post'], "addDocumentList/", "AdminController::addDocumentList");
		$routes->match(['get', 'post'], "updateDocumentList/(:any)", "AdminController::updateDocumentList/$1");
		$routes->get("deleteDocumentList/(:any)", "AdminController::deleteDocumentList/$1");
	/* document list */
	/* state list */
		$routes->get("stateList/", "AdminController::stateList");
		$routes->match(['get', 'post'], "addStateList/", "AdminController::addStateList");
		$routes->match(['get', 'post'], "updateStateList/(:any)", "AdminController::updateStateList/$1");
		$routes->get("deleteStateList/(:any)", "AdminController::deleteStateList/$1");
	/* state list */
	/* district list */
		$routes->get("districtList/", "AdminController::districtList");
		$routes->match(['get', 'post'], "addDistrictList/", "AdminController::addDistrictList");
		$routes->match(['get', 'post'], "updateDistrictList/(:any)", "AdminController::updateDistrictList/$1");
	/* district list */
	/* city list */
		$routes->get("cityList/", "AdminController::cityList");
		$routes->match(['get', 'post'], "addCityList/", "AdminController::addCityList");
		$routes->match(['get', 'post'], "updateCityList/(:any)", "AdminController::updateCityList/$1");
	/* city list */
	/* upload attribute list */
		$routes->get("uploadAttributeList/", "AdminController::uploadAttributeList");
		$routes->match(['get', 'post'], "addUploadAttribute/", "AdminController::addUploadAttribute");
		$routes->match(['get', 'post'], "updateUploadAttribute/(:any)", "AdminController::updateUploadAttribute/$1");
		$routes->get("deleteUploadAttribute/(:any)", "AdminController::deleteUploadAttribute/$1");
	/* upload attribute list */
	/* static content list */
		$routes->get("staticContentList/", "AdminController::staticContentList");
		$routes->match(['get', 'post'], "addStaticContent/", "AdminController::addStaticContent");
		$routes->match(['get', 'post'], "updateStaticContent/(:any)", "AdminController::updateStaticContent/$1");
		$routes->get("deleteStaticContent/(:any)", "AdminController::deleteStaticContent/$1");
	/* static content list */
	/* manage listing page */
		$routes->get("manageListingPage/", "AdminController::manageListingPage");
		$routes->get("editManageListingpage/(:any)", "AdminController::editManageListingpage/$1");
		$routes->post("editManageListingpage/(:any)", "AdminController::editManageListingpage/$1");
	/* manage listing page */
	/* manage inventory inquiry */
		$routes->get("inquiryList/", "AdminController::inquiryList");
		$routes->match(['get', 'post'], "inquiryDetails/(:any)", "AdminController::inquiryDetails/$1");
		$routes->match(['get', 'post'], "inquiryApprove/(:any)", "AdminController::inquiryApprove/$1");
		$routes->match(['get', 'post'], "sharePO/(:any)", "AdminController::sharePO/$1");
		$routes->match(['get', 'post'], "uploadInvoices/(:any)", "AdminController::uploadInvoices/$1");
		$routes->match(['get', 'post'], "acceptPayment/(:any)", "AdminController::acceptPayment/$1");
	/* manage inventory inquiry */
	/* manage posts */
		$routes->get("unapprovedPost/", "PostController::unapprovedPost");
		$routes->get("currentPost/", "PostController::currentPost");
		$routes->get("expiredPost/", "PostController::expiredPost");
		$routes->get("postExpire/(:any)/(:any)", "PostController::postExpire/$1/$2");
		$routes->get("postApprove/(:any)/(:any)", "PostController::postApprove/$1/$2");
		$routes->get("postDetails/(:any)/(:any)", "PostController::postDetails/$1/$2");
		$routes->get("postViewDetails/(:any)/(:any)", "PostController::postViewDetails/$1/$2");
	/* manage posts */
	/* manage reports */
		$routes->get("memberTypeWiseReport/", "ReportController::memberTypeWiseReport");
		$routes->get("memberTypeWiseReportView/(:any)/(:any)/(:any)", "ReportController::memberTypeWiseReportView/$1/$2/$3");
		$routes->get("transactionReport/", "ReportController::transactionReport");
		$routes->get("transactionReportView/(:any)/(:any)", "ReportController::transactionReportView/$1/$2");
	/* manage reports */
});
$routes->group("recycler", ["namespace" => "App\Controllers\Recycler"], function($routes){
	$routes->get("/", "DashboardController::myDashboard");
	$routes->get("logout/", "DashboardController::logout");
	$routes->get("inventory/", "DashboardController::inventory");
	$routes->post("addInventoryData/", "DashboardController::addInventoryData");
	$routes->get("addInventoryByState/", "DashboardController::addInventoryByState");
	$routes->post("addInventoryByStateData/", "DashboardController::addInventoryByStateData");
	$routes->get("inventoryList/", "DashboardController::inventoryList");
	$routes->get("setInventoryId/(:any)", "DashboardController::setInventoryId/$1");
	$routes->get("setStateInventoryId/(:any)", "DashboardController::setStateInventoryId/$1");
	$routes->get("editInventory/", "DashboardController::editInventory");
	$routes->post("editInventoryData/", "DashboardController::editInventoryData");
	$routes->get("profile-settings/", "DashboardController::profileSettings");
	$routes->post("profile-settings-post/", "DashboardController::updateProfileSettings");
	$routes->get("change-password/", "DashboardController::changePassword");
	$routes->post("change-password-post/", "DashboardController::updateChangePassword");
	$routes->post("changeVisibility/", "DashboardController::changeVisibility");
	$routes->get("getMainCategory/", "DashboardController::getMainCategory");
});
$routes->group("brand", ["namespace" => "App\Controllers\Brand"], function($routes){
	$routes->get("/", "DashboardController::myDashboard");
	$routes->post("sendVerificationLink/", "DashboardController::sendVerificationLink");
	$routes->get("target/", "DashboardController::target");
	$routes->get("targetList/", "DashboardController::targetList");
	$routes->post("targetList/", "DashboardController::targetList");
	$routes->post("addTargetData/", "DashboardController::addTargetData");
	$routes->get("addTargetByState/", "DashboardController::addTargetByState");
	$routes->post("addTargetByStateData/", "DashboardController::addTargetByStateData");
	$routes->match(['get', 'post'],"addTargetByDistrict/", "DashboardController::addTargetByDistrict");
	$routes->match(['get', 'post'],"addTargetByCity/", "DashboardController::addTargetByCity");
	$routes->post("addTargetByDistrictData/", "DashboardController::addTargetByDistrictData");
	$routes->post("addTargetByCityData/", "DashboardController::addTargetByCityData");
	$routes->get("editTarget/", "DashboardController::editTarget");
	$routes->post("editTargetData/", "DashboardController::editTargetData");
	$routes->get("setTargetId/(:any)", "DashboardController::setTargetId/$1");
	$routes->get("setStateTargetId/(:any)", "DashboardController::setStateTargetId/$1");
	$routes->get("logout/", "DashboardController::logout");
	$routes->get("manageQuotes/", "DashboardController::manageQuotes");
	$routes->get("manageQuotesInquiry/(:any)", "DashboardController::manageQuotesInquiry/$1");
	$routes->get("manageQuotesBid/(:any)", "DashboardController::manageQuotesBid/$1");
	$routes->get("marketplace/", "DashboardController::marketplace");
	$routes->get("manageInquiries/", "DashboardController::manageInquiries");
	$routes->get("manageInquiriesDetails/(:any)", "DashboardController::manageInquiriesDetails/$1");
	$routes->get("closeInquiry/(:any)", "DashboardController::closeInquiry/$1");
	$routes->get("manageOrders/", "DashboardController::manageOrders");
	$routes->get("manageInventory/", "DashboardController::manageInventory");
	$routes->get("manageTeam/", "DashboardController::manageTeam");
	$routes->get("companyDetails/", "DashboardController::companyDetails");
	$routes->get("setting/", "DashboardController::setting");
	$routes->get("targetToInquiry/(:any)", "DashboardController::targetToInquiry/$1");
	$routes->post("targetToInquiryData/", "DashboardController::targetToInquiryData");
	$routes->get("profile-settings/", "DashboardController::profileSettings");
	$routes->post("profile-settings-post/", "DashboardController::updateProfileSettings");
	$routes->get("change-password/", "DashboardController::changePassword");
	$routes->post("change-password-post/", "DashboardController::updateChangePassword");
	$routes->post("changeVisibility/", "DashboardController::changeVisibility");
	$routes->get("getMainCategory/", "DashboardController::getMainCategory");
	$routes->get("inquiryList/", "DashboardController::inquiryList");
	$routes->match(['get', 'post'], "uploadInquiryDocument/(:any)", "DashboardController::uploadInquiryDocument/$1");
	$routes->match(['get', 'post'], "inquiryAcceptDocument/(:any)", "DashboardController::inquiryAcceptDocument/$1");
	$routes->match(['get', 'post'], "uploadPO/(:any)", "DashboardController::uploadPO/$1");
});
$routes->group("collector", ["namespace" => "App\Controllers\Collector"], function($routes){
	$routes->get("/", "DashboardController::myDashboard");
	$routes->get("logout/", "DashboardController::logout");
	$routes->get("inventory/", "DashboardController::inventory");
	$routes->post("addInventoryData/", "DashboardController::addInventoryData");
	$routes->get("addInventoryByState/", "DashboardController::addInventoryByState");
	$routes->post("addInventoryByStateData/", "DashboardController::addInventoryByStateData");
	$routes->get("inventoryList/", "DashboardController::inventoryList");
	$routes->get("setInventoryId/(:any)", "DashboardController::setInventoryId/$1");
	$routes->get("setStateInventoryId/(:any)", "DashboardController::setStateInventoryId/$1");
	$routes->get("editInventory/", "DashboardController::editInventory");
	$routes->post("editInventoryData/", "DashboardController::editInventoryData");
	$routes->get("profile-settings/", "DashboardController::profileSettings");
	$routes->post("profile-settings-post/", "DashboardController::updateProfileSettings");
	$routes->get("change-password/", "DashboardController::changePassword");
	$routes->post("change-password-post/", "DashboardController::updateChangePassword");
	$routes->post("changeVisibility/", "DashboardController::changeVisibility");
	$routes->get("getMainCategory/", "DashboardController::getMainCategory");
});
$routes->group("user", ["namespace" => "App\Controllers\User"], function($routes){
	$routes->get("/", "DashboardController::myDashboard");
	$routes->get("logout/", "DashboardController::logout");
	$routes->post("sendVerificationLink/", "DashboardController::sendVerificationLink");
	$routes->get("inventory/", "DashboardController::inventory");
	$routes->post("addInventoryData/", "DashboardController::addInventoryData");
	$routes->get("addInventoryByState/", "DashboardController::addInventoryByState");
	$routes->post("addInventoryByStateData/", "DashboardController::addInventoryByStateData");
	$routes->get("inventoryList/", "DashboardController::inventoryList");
	$routes->get("setInventoryId/(:any)", "DashboardController::setInventoryId/$1");
	$routes->get("setStateInventoryId/(:any)", "DashboardController::setStateInventoryId/$1");
	$routes->get("editInventory/", "DashboardController::editInventory");
	$routes->post("editInventoryData/", "DashboardController::editInventoryData");
	$routes->get("profile-settings/", "DashboardController::profileSettings");
	$routes->post("profile-settings-post/", "DashboardController::updateProfileSettings");
	$routes->get("change-password/", "DashboardController::changePassword");
	$routes->post("change-password-post/", "DashboardController::updateChangePassword");
	$routes->post("changeVisibility/", "DashboardController::changeVisibility");
	$routes->get("getMainCategory/", "DashboardController::getMainCategory");
	$routes->get("inquiryList/", "DashboardController::inquiryList");
	$routes->match(['get', 'post'], "uploadInquiryDocument/(:any)", "DashboardController::uploadInquiryDocument/$1");
	$routes->match(['get', 'post'], "delete-uploaded-data/(:any)", "DashboardController::deleteUploadedData/$1");
	$routes->match(['get', 'post'], "notify-admin-approval/(:any)", "DashboardController::notifyAdminApproval/$1");
	$routes->match(['get', 'post'], "inquiryAcceptDocument/(:any)", "DashboardController::inquiryAcceptDocument/$1");
	$routes->match(['get', 'post'], "uploadPO/(:any)", "DashboardController::uploadPO/$1");
	$routes->match(['get', 'post'], "uploadInvoice/(:any)", "DashboardController::uploadInvoice/$1");
	$routes->match(['get', 'post'], "uploadPayment/(:any)", "DashboardController::uploadPayment/$1");
});
$routes->group("api", ["namespace" => "App\Controllers"], function($routes){
	$routes->post("signin/", "Api::signin");
	$routes->post("inventory-listing/", "Api::inventoryListing");
	$routes->post("inventory-details/", "Api::inventoryDetails");
	$routes->post("document-upload/", "Api::documentUpload");
});

//$routes->match(['get', 'post'],'api/signin', 'Api::signin');

/*
* --------------------------------------------------------------------
* Additional Routing
* --------------------------------------------------------------------
*
* There will often be times that you need additional routing and you
* need it to be able to override any defaults in this file. Environment
* based routes is one such time. require() additional route files here
* to make that happen.
*
* You will have access to the $routes object within that file without
* needing to reload it.
*/
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

