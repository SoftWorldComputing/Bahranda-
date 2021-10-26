<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Admin\Sessioncontroller@LoginView');
// Route::get('/admin/login', 'Admin\Sessioncontroller@LoginView')->name('admin.login.view');
Route::get('/admin/login', 'Admin\Sessioncontroller@LoginView')->name('login');
Route::post('/admin/login', 'Admin\Sessioncontroller@Login')->name('admin.login');
Route::get('/admin/{token}/{email}/verification', 'Admin\Sessioncontroller@AdminVerificationView')->name('admin.verification.view');

Route::get('/admin/password-reset', 'Admin\Sessioncontroller@ForgetPassword')->name('admin.login.forget-password');
Route::post('/admin/password-reset', 'Admin\Sessioncontroller@SendPasswordReset')->name('admin.login.send-password-reset');
Route::get('/admin/{email}/{token}/password-reset', 'Admin\Sessioncontroller@PasswordResetView')->name('admin.password.reset');
Route::post('/admin/{email}/password-reset', 'Admin\Sessioncontroller@PasswordReset')->name('admin.password.reset.store');

//dashboard
Route::get('/admin/dashboard', 'Admin\DashboardController@Index')->name('admin.dashboard.index');
Route::get('/admin/permission-denied', 'Admin\DashboardController@Deny')->name('admin.dashboard.deny');

//role management
Route::get('/admin/role-management/list-role', 'Admin\RoleManagementController@ListRoles')->name('admin.rolemgt.list');
Route::get('/admin/role-management/create-role', 'Admin\RoleManagementController@CreateNewRoleView')->name('admin.rolemgt.create-role.view');
Route::post('/admin/role-management/create-role', 'Admin\RoleManagementController@RemoveRole')->name('admin.rolemgt.remove-role');

Route::post('/admin/role-management/create-role', 'Admin\RoleManagementController@CreateNewRole')->name('admin.rolemgt.store');

Route::get('/admin/role-management/{role}/view-role', 'Admin\RoleManagementController@UpdateRoleView')->name('admin.rolemgt.view');
Route::post('/admin/role-management/delete-role', 'Admin\RoleManagementController@RemoveRole')->name('admin.rolemgt.remove-role');
Route::post('/admin/role-management/{role}/update-role', 'Admin\RoleManagementController@UpdateRole')->name('admin.rolemgt.update');

//admin mgt
Route::get('/admin/admin-mgt/list-admin', 'Admin\AdminMgtController@AdminList')->name('admin.adminmgt.list');
Route::get('/admin/admin-mgt/{admin}/view', 'Admin\AdminMgtController@ShowAdmin')->name('admin.adminmgt.show');
Route::post('/admin/admin-mgt/{admin}/update', 'Admin\AdminMgtController@UpdateAdmin')->name('admin.admin_mgt.update');
Route::get('/admin/admin-mgt/create', 'Admin\AdminMgtController@CreateAdminView')->name('admin.admin_mgt.store.view');
Route::post('/admin/admin-mgt/create', 'Admin\AdminMgtController@CreateAdmin')->name('admin.admin_mgt.store');
Route::post('/admin/admin-mgt/{admin}/update-profile-image', 'Admin\AdminMgtController@UpdateAdminProfileImage')->name('admin.admin_mgt.profile_image.update');
Route::get('/admin/admin-mgt/{admin}/remove', 'Admin\AdminMgtController@DeleteAdmin')->name('admin.adminmgt.remove');

//user mgt
Route::get('/admin/user-mgt/user-list', 'User\UserController@list')->name('admin.user_mgt.list');
Route::get('/admin/user-mgt/{user}/show', 'User\UserController@show')->name('admin.user_mgt.show');
//commodity management
Route::get('/admin/commodity-mgt/list-commodities', 'Admin\CommodityMgtController@CommodityList')->name('admin.productmgt.list');
Route::get('/admin/commodity-mgt/add-commodity', 'Admin\CommodityMgtController@StoreCommodityView')->name('admin.productmgt.store.view');
Route::post('/admin/commodity-mgt/add-commodity', 'Admin\CommodityMgtController@StoreCommodity')->name('admin.productmgt.store');
Route::get('/admin/commodity-mgt/{product}/view-commodity', 'Admin\CommodityMgtController@CommodityShow')->name('admin.productmgt.show');
Route::get('/admin/commodity-mgt/{product}/edit-commodity', 'Admin\CommodityMgtController@CommodityEditView')->name('admin.productmgt.edit.view');
Route::post('/admin/commodity-mgt/{product}/edit-commodity', 'Admin\CommodityMgtController@CommodityEdit')->name('admin.productmgt.edit');
Route::get('/admin/commodity-mgt/commodity-price-list', 'Admin\CommodityMgtController@CommodityPriceList')->name('admin.commodity_price.list');
Route::get('/admin/commodity-mgt/update-commodity-price-list', 'Admin\CommodityMgtController@CommodityPriceUpdateView')->name('admin.commodity_price.list.update.view');
Route::get('/admin/commodity-mgt/update-commodity-price-list-format', 'Admin\CommodityMgtController@CommodityTemplate')->name('admin.commodity_price.list.update.format');
Route::post('/admin/commodity-mgt/update-commodity-price-list', 'Admin\CommodityMgtController@CommodityPriceUpdate')->name('admin.commodity_price.list.update');
Route::post('/admin/commodity-mgt/{batch_no}/update-commodity-price-authorize', 'Admin\CommodityMgtController@AuthorizePriceUpload')->name('admin.commodity_price.list.update.authorize');
Route::get('/admin/commodity-mgt/{commodity}/delete', 'Admin\CommodityMgtController@deleteCommodity')->name('admin.productmgt.delete');

Route::post('/admin/user-mgt/{user}/fund-user', 'User\UserController@fundUser')->name('admin.user_mgt.fund_user');

//add new batch
Route::post('/admin/commodity-mgt/{commodity}/add-new-batch', 'Admin\CommodityMgtController@StoreNewBatch')->name('admin.commodity.add_new_batch');
Route::post('/admin/commodity-mgt/{commodity}/change-batch', 'Admin\CommodityMgtController@ChangeBatch')->name('admin.commodity.change_batch');
Route::get('/admin/commodity-mgt/{commodity}/{batch}/batch-history', 'Admin\CommodityMgtController@BatchHistory')->name('admin.commodity.batch_history');
Route::get('/admin/commodity-mgt/price_upload_batch', 'Admin\CommodityMgtController@PriceUploadBatchView')->name('admin.commodity_price.price_upload.batch');
Route::get('/admin/commodity-mgt/{batch_no}/price_upload_batch_data', 'Admin\CommodityMgtController@PriceUploadBatchDataView')->name('admin.commodity_price.price_upload.batch.data');

Route::get('/admin/commodity-mgt/{commodity}/purchase-for-user', 'Admin\CommodityMgtController@PurchaseCommodityView')->name('admin.commodity_price.purchase_for_user');

Route::get('/admin/commodity-mgt/purchase-for-user/{user}/fetch_user_balance', 'Admin\CommodityMgtController@FetchUserBalance')->name('admin.commodity_price.purchase_for_user.fetch_user_balance');

Route::get('/admin/commodity-mgt/purchase-for-user/{commodity}/{quantity}/fetch-commodity-price', 'Admin\CommodityMgtController@FetchCommodityPrice')->name('admin.commodity_price.purchase_for_user.commodity_price');

Route::post('/admin/commodity-mgt/{commodity}/purchase-for-user', 'Admin\CommodityMgtController@PurchaseCommodity')->name('admin.commodity_price.purchase_for_user.store');

//warehouse mgt
Route::get('/admin/warehouse-mgt/list-warehouses', 'Admin\WareHouseController@ListWarehouses')->name('admin.warehousemgt.list');
Route::get('/admin/warehouse-mgt/add-warehouse', 'Admin\WareHouseController@AddWarehouseView')->name('admin.warehousemgt.add_warehouse.view');
Route::post('/admin/warehouse-mgt/add-warehouse', 'Admin\WareHouseController@StoreWarehouse')->name('admin.warehousemgt.add_warehouse');
Route::get('/admin/warehouse-mgt/{warehouse}/show-warehouse', 'Admin\WareHouseController@ShowWarehouse')->name('admin.warehousemgt.show_warehouse');
Route::get('/admin/warehouse-mgt/{warehouse}/checkout-from-warehouse', 'Admin\WareHouseController@CheckoutRequestView')->name('admin.warehousemgt.checkout.view');
Route::get('/admin/warehouse-mgt/warehouse-checkout-request', 'Admin\WareHouseController@WarehouseCheckoutRequest')->name('admin.warehousemgt.checkout.requests.all');
Route::get('/admin/warehouse-mgt/{batch_no}/warehouse-checkout-request-data', 'Admin\WareHouseController@WarehouseCheckoutRequestData')->name('admin.warehousemgt.checkout.requests.all.data');
//chckoutwarehouse
Route::post('/admin/warehouse-mgt/{warehouse}/checkout-from-warehouse', 'Admin\WareHouseController@WareHouseCheckoutRequestSubmit')->name('admin.warehousemgt.checkout.requests.submit');

Route::post('/admin/warehouse-mgt/{batch_no}/warehouse-authorise-checkout', 'Admin\WareHouseController@AuthorizeWarehouseCheckout')->name('admin.warehousemgt.checkout.authorize_checkout');

//deals  mgt  //deals aand partnership arre synonymous
Route::get('/admin/partnership-mgt/all-deals', 'Admin\PartnershipMgtController@AllPartnership')->name('admin.partnership.list');
Route::get('/admin/partnership-mgt/{partnership}/view-deals', 'Admin\PartnershipMgtController@ViewPartnerShip')->name('admin.partnership.view_partnership');
Route::post('/admin/partnership-mgt/{partnership}/assign-warehouse', 'Admin\PartnershipMgtController@AssignWarehouse')->name('admin.partnership.assignwarehouse');
Route::post('/admin/partnership-mgt/{partnership}/change-deals-status', 'Admin\PartnershipMgtController@ChangePartnershipStatus')->name('admin.partnership.change-partnership-status');
Route::get('/admin/partnership-mgt/all-deals-by-batch', 'Admin\PartnershipMgtController@DealByBatch')->name('admin.partnership.by_batch');
Route::get('/admin/partnership-mgt/{batch_no}/deals', 'Admin\PartnershipMgtController@BatchDealsView')->name('admin.partnership.batch_deals');

Route::post('/admin/partnership-mgt/batch-update-deals', 'Admin\PartnershipMgtController@BatchUpdateDeals')->name('admin.partnership.batchupdatedeals');

Route::post('/admin/partnership-mgt/{partnership}/update-real-sold', 'Admin\PartnershipMgtController@UpdatePriceSold')->name('admin.partnership.real_price_sold');

//accounting
Route::get('/admin/accounting/all_accounts', 'Admin\AccountingMgtController@AllAccounts')->name('admin.accounting.all_account');
Route::get('/admin/accounting/withdrwal_request', 'Admin\AccountingMgtController@WithdrawalRequestView')->name('admin.accounting.withdrwal.requests.view');
Route::post('/admin/accounting/withdrwal_request/{withdrawal_request}/change-status', 'Admin\AccountingMgtController@ChangeWithrawalStatus')->name('admin.accounting.withdrwal.requests.change');

//password
Route::get('/admin/settings/change_password', 'Admin\SettingsController@ChangePasswordView')->name('admin.settings.change_password.view');
Route::post('/admin/settings/{admin}/change_password', 'Admin\SettingsController@ChangePassword')->name('admin.settings.change_password');

//site management
Route::get('admin/settings/site-settings', 'Admin\SiteMgtController@siteSettings')->name('admin.settings.site.show');
Route::post('admin/settings/site-settings/team-member', 'Admin\SiteMgtController@storeTeamMemeber')->name('admin.settings.site.team.store');
Route::post('admin/settings/site-settings/team-member/{team_member}/delete', 'Admin\SiteMgtController@deleteTeamMember')->name('admin.settings.site.team.delete');
Route::post('admin/settings/site-settings/faq', 'Admin\SiteMgtController@storeFaq')->name('admin.settings.site.faq.store');
Route::post('admin/settings/site-settings/faq/{faq}/delete', 'Admin\SiteMgtController@deleteFaq')->name('admin.settings.site.faq.delete');
Route::post('admin/settings/site-settings/review', 'Admin\SiteMgtController@storeReview')->name('admin.settings.site.review.store');
Route::post('admin/settings/site-settings/review/{review}/delete', 'Admin\SiteMgtController@deleteReview')->name('admin.settings.site.review.delete');
Route::post('admin/settings/site-settings/privacy', 'Admin\SiteMgtController@storePrivacy')->name('admin.settings.site.privacy.store');
Route::post('admin/settings/site-settings/terms', 'Admin\SiteMgtController@storeTerms')->name('admin.settings.site.terms.store');

//logout
Route::get('/admin/logout', 'Admin\DashboardController@Logout')->name('admin.logout');
