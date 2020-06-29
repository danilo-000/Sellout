<?php   
    return [
        App\Core\Route::get('|^user/register/?$|', 'Main', 'getRegister'),
        App\Core\Route::post('|^user/register/?$|', 'Main', 'postRegister'),
        App\Core\Route::get('|^user/login/?$|', 'Main', 'getLogin'),
        App\Core\Route::post('|^user/login/?$|', 'Main','postLogin'),
        App\Core\Route::get('|^user/logout/?$|', 'Main', 'getLogout'),

        App\Core\Route::get('|^category/([0-9]+)/?$|', 'Category', 'show'),
        App\Core\Route::get('|^category/([0-9]+)/delete/?$|', 'Category', 'delete'),

        App\Core\Route::get('|^ad/([0-9]+)/?$|', 'Ad', 'show'),
        App\Core\Route::post('|^search/?$|', 'Ad', 'postSearch'),

        # API rute:
        App\Core\Route::get('|^api/ad/([0-9]+)/?$|', 'ApiAd', 'show'),
        App\Core\Route::get('|^api/bookmarks/?$|', 'ApiBookmark', 'getBookmarks'),
        App\Core\Route::get('|^api/bookmarks/add/([0-9]+)/?$|','ApiBookmark', 'addBookmark'),
        App\Core\Route::get('|^api/bookmarks/clear/?$|', 'ApiBookmark',  'clear'),
        
        # User role routes:
        App\Core\Route::get('|^user/profile/?$|', 'UserDashboard', 'index'),

        App\Core\Route::get('|^user/categories/?$|', 'UserCategoryManagment', 'categories'),
        App\Core\Route::get('|^user/categories/edit/([0-9]+)/?$|','UserCategoryManagment', 'getEdit'),
        App\Core\Route::post('|^user/categories/edit/([0-9]+)/?$|','UserCategoryManagment', 'postEdit'),
        App\Core\Route::get('|^user/categories/add/?$|','UserCategoryManagment', 'getAdd'),
        App\Core\Route::post('|^user/categories/add/?$|','UserCategoryManagment', 'postAdd'),

        App\Core\Route::get('|^user/ads/?$|', 'UserAdManagment', 'ads'),
        App\Core\Route::get('|^user/ads/edit/([0-9]+)/?$|',  'UserAdManagment', 'getEdit'),
        App\Core\Route::post('|^user/ads/edit/([0-9]+)/?$|',  'UserAdManagment', 'postEdit'),
        App\Core\Route::get('|^user/ads/add/?$|',        'UserAdManagment', 'getAdd'),
        App\Core\Route::post('|^user/ads/add/?$|',       'UserAdManagment', 'postAdd'),
        App\Core\Route::any('|^.*$|', 'Main', 'home')
    ];