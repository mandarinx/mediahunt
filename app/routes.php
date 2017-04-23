<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
Route::resource('install', 'InstallController');

// Patterns
Route::pattern('id', '[0-9]+');

// Browsing Routes
Route::get('/', ['as' => 'home', 'uses' => 'PostsController@getTrending']);
Route::get('trending', ['as' => 'trending', 'uses' => 'PostsController@getTrending']);
Route::get('latest', ['as' => 'latest', 'uses' => 'PostsController@getLatest']);
Route::get('featured', ['as' => 'featured', 'uses' => 'PostsController@getFeatured']);

Route::get('rss', ['as' => 'rss', 'uses' => 'RssController@getRss']);
/**
 * Guest only visit this section
 */
Route::group(['before' => 'guest'], function ()
{
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
    // Facebook
    Route::get('get/facebook', 'LoginController@loginWithFacebook');
    Route::get('registration/facebook', 'RegistrationController@getFacebook');
    // Google
    Route::get("get/google", 'LoginController@loginWithGoogle');
    Route::get("registration/google", 'RegistrationController@getGoogle');

    Route::controller('password', 'RemindersController');
    Route::get('registration', ['as' => 'registration', 'uses' => 'RegistrationController@getIndex']);
    Route::get('registration/activate/{username}/{code}', 'RegistrationController@validateUser');
});
/**
 * Guest routes require csrf protection
 */
Route::group(['before' => 'guest|csrf'], function ()
{
    Route::post('login', 'LoginController@postLogin');
    // Facebook
    Route::post('registration/facebook', 'RegistrationController@postFacebook');
    // Google
    Route::post('registration/google', 'RegistrationController@postGoogle');
    // Normal Registration
    Route::post('registration', 'RegistrationController@postIndex');
    Route::post('password/remind', 'PasswordresetController@postIndex');
    Route::post('password/reset/{token}', 'PasswordresetController@resetPassword');
});

// Group routes ( Require Login )
Route::group(['before' => 'auth'], function ()
{
    Route::get('post/submit', ['as' => 'post-submit', 'uses' => 'PostsController@index'])->before('ban');
    Route::get('post/submit/stepTow', ['as' => 'post-steptow', 'uses' => 'PostsController@stepTow'])->before('ban');
    Route::post('post/submit', 'PostsController@postInitial')->before('csrf|ban');
    Route::post('post/submit/stepTow', 'PostsController@create')->before('csrf|ban');
    Route::get('image/submit', ['as' => 'image-submit', 'uses' => 'ImageController@index'])->before('ban');
    Route::post('image/submit', ['as' => 'image-submit', 'uses' => 'ImageController@create'])->before('ban');
    Route::post('vote', 'PostsController@vote');
    Route::get('feeds', ['as' => 'users-feeds', 'uses' => 'UsersController@getFeeds']);


    Route::post('comment/{id}-{slug?}', ['as' => 'post-comment', 'uses' => 'CommentsController@create'])->before('csrf|ban');
    Route::post('reply', 'ReplyController@create');
    //Settings
    Route::get('settings', ['as' => 'settings', 'uses' => 'UsersController@getSettings']);
    Route::post('settings/profile', 'UsersController@updateProfile')->before('csrf');
    Route::post('settings/email', 'UsersController@updateProfile')->before('csrf');
    Route::post('settings/mailsettings', 'UsersController@mailSettings')->before('csrf');
    Route::post('settings/changepassword', 'UsersController@changePassword')->before('csrf');
    Route::post('settings/avatar', 'UsersController@updateAvatar')->before('csrf');

    // Logout
    Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@destroy']);

    // Flags Route
    Route::get('flag/{id}', ['as' => 'flag', 'uses' => 'FlagsController@getIndex']);
    Route::post('flag/{id}', 'FlagsController@postReport')->before('csrf|ban');
    Route::get('flag/user/{username}', ['as' => 'flag-user', 'uses' => 'FlagsController@getUserIndex']);
    Route::post('flag/user/{username}', 'FlagsController@postUserReport')->before('csrf|ban');

    // Notification
    Route::get('notifications', ['as' => 'notifications', 'uses' => 'UsersController@getNotifications']);
});

// News
Route::get('post', 'PostsController@getLatest'); // Alias for post latest
Route::get('post/{id}-{slug?}', ['as' => 'post', 'uses' => 'PostsController@show']);
Route::get('post/{id}-{slug?}/edit', ['as' => 'post-edit', 'uses' => 'PostsController@edit'])->before('auth');
Route::post('post/{id}-{slug?}/edit', ['as' => 'post-edit', 'uses' => 'PostsController@postEdit'])->before('auth|csrf');

// User
Route::get('user/{username}', ['as' => 'user', 'uses' => 'UsersController@getUser']);
Route::get('user/{username}/followers', ['as' => 'users-followers', 'uses' => 'UsersController@getFollowers']);
Route::get('user/{username}/following', ['as' => 'users-following', 'uses' => 'UsersController@getFollowing']);

// Blogs
Route::get('blog/submit', ['as' => 'blog-submit', 'uses' => 'BlogsController@getSubmit'])->before('auth');
Route::post('blog/submit', 'BlogsController@create')->before('auth|csrf|ban');

//Links
Route::get('link/submit', ['as' => 'link-submit', 'uses' => 'LinksController@getSubmit'])->before('auth');
Route::post('link/submit', 'LinksController@create')->before('auth|csrf|ban');

// Search
Route::get('search', ['as' => 'serach', 'uses' => 'SearchController@search']);

// Policy
Route::get('tos', ['as' => 'tos', 'uses' => 'PolicyController@getTos']);
Route::get('privacy', ['as' => 'privacy', 'uses' => 'PolicyController@getPrivacy']);
Route::get('faq', ['as' => 'faq', 'uses' => 'PolicyController@getFaq']);
Route::get('about', ['as' => 'about', 'uses' => 'PolicyController@getAbout']);

// Language route
Route::get('lang/{lang?}', function ($lang)
{
    if (in_array($lang, languageArray()))
    {
        Session::put('my.locale', $lang);
    }
    else
    {
        Session::put('my.locale', 'en');
    }

    return Redirect::route('home');
});
Route::post('queue/receive', function ()
{
    return Queue::marshal();
});

// Follow Un protection is from controller
Route::group(['before' => 'ajax|ajaxban'], function ()
{
    Route::post('follow', 'FollowController@follow');
    Route::post('deletecomment', 'CommentsController@delete');
    Route::post('votecomment', 'CommentsController@vote');
    Route::post('votereply', 'ReplyController@vote');
    Route::post('deletereply', 'ReplyController@delete');
});

/**
 * Admin section users with admin privileges can access this area
 */
Route::group(['before' => 'admin', 'namespace' => 'Controllers\Admin'], function ()
{
    Route::get('admin', 'IndexController@getIndex');

// Users Manager
    Route::get('admin/users', 'Users\UsersController@getUsersList');
    Route::get('admin/users/featured', 'Users\UsersController@getFeaturedUserList');
    Route::get('admin/users/banned', 'Users\UsersController@getBannedUserList');
    Route::get('admin/user/{username}/edit', 'Users\UsersController@getEditUser');
    Route::get('admin/adduser', 'Users\UsersController@getAddUser');
    Route::post('admin/user/{username}/edit', 'Users\UpdateController@updateUser');
    Route::post('admin/adduser', 'Users\UpdateController@addUser');

// News Manger
    Route::get('admin/posts', 'Posts\PostsController@getAll');
    Route::get('admin/posts/featured', 'Posts\PostsController@getFeatured');
    Route::get('admin/posts/approval', 'Posts\PostsController@getApprovalRequired');
    Route::get('admin/posts/{id}/edit', 'Posts\PostsController@getEdit');
    Route::post('admin/posts/{id}/edit', 'Posts\PostsController@update');
    Route::post('admin/posts/approve', 'Posts\UpdateController@postApprove');
    Route::post('admin/posts/disapprove', 'Posts\UpdateController@postDisapprove');

// Site Settings
    Route::get('admin/sitesettings', 'SiteSettings\SettingsController@getSiteDetails');
    Route::get('admin/sitecategory', 'SiteSettings\SettingsController@getSiteCategory');
    Route::get('admin/limitsettings', 'SiteSettings\SettingsController@getLimitSettings');
    Route::get('admin/removecache', 'SiteSettings\SettingsController@getRemoveCache');
    Route::get('admin/updatesitemap', 'SiteSettings\UpdateController@updateSiteMap');
    Route::post('admin/sitesettings', 'SiteSettings\UpdateController@updateSettings');
    Route::post('admin/limitsettings', 'SiteSettings\UpdateController@postLimitSettings');
    Route::post('admin/sitecategory', 'SiteSettings\UpdateController@createSiteCategory');
    Route::post('admin/sitecategory/reorder', 'SiteSettings\UpdateController@reorderSiteCategory');
    Route::post('admin/sitecategory/update', 'SiteSettings\UpdateController@updateSiteCategory');

// Comments ( done )
    Route::get('admin/comments', 'Comments\CommentsController@getComments');
    Route::get('admin/comment/{id}/edit', 'Comments\CommentsController@getEditComment');
    Route::post('admin/comment/{id}/edit', 'Comments\CommentsController@postEditComment');

// Blogs
    Route::get('admin/blogs', 'Blogs\BlogsController@getBlogs');
    Route::get('admin/blog/create', 'Blogs\BlogsController@getCreate');
    Route::get('admin/blog/{id}/edit', 'Blogs\BlogsController@getEdit');
    Route::post('admin/blog/create', 'Blogs\BlogsController@postCreate');
    Route::post('admin/blog/{id}/edit', 'Blogs\BlogsController@postEdit');

// Reports
    Route::get('admin/reports', 'Reports\ReportsController@getReports');
    Route::get('admin/report/{id}', 'Reports\ReportsController@getReadReport');

});