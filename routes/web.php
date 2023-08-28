<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ValueController;
use App\Http\Controllers\FrontInterfaces\IndexController;
use App\Http\Controllers\FrontInterfaces\NavbarController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('Admin')->group(function(){

    // Admin Login route
    Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->name('admin.login');
    Route::group(['middleware'=>['admin']], function(){

        // Admin dashboard route
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Update admin password
        Route::match(['get', 'post'], '/update-admin-password', [AdminController::class, 'updateAdminPassword'])
        ->name('admin.update-admin-password');

        // Check admin password
        Route::post('check-admin-password', [AdminController::class, 'checkAdminPassword'])
        ->name('admin.check-admin-password');

        // Update admin details
        Route::match(['get', 'post'], '/update-admin-details', [AdminController::class, 'updateAdminDetails'])
        ->name('admin.update-admin-details');

        //Update vendor details
        Route::match(['get', 'post'], '/update-vendor-details/{slug}', [AdminController::class, 'updateVendorDetails'])
        ->name('admin.update-vendor-details/{slug}');

        // View Admins / Subadmins / Vendors
        Route::get('/admins/{type?}',[AdminController::class, 'admins'])->name('admin.admins/{type?}');

        // View vendor Details
        Route::get('/view-vendor-details/{id}', [AdminController::class, 'viewVendorDetails'])->name('admin.admins.view-vendor-details');

        // Update admin status
        Route::post('/update-admin-status', [AdminController::class, 'updateAdminStatus']);

        // Admin logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Sections
        Route::get('/sections',[SectionController::class, 'sections'])->name('admin.sections.sections');

        // Update section status
        Route::post('/update-section-status', [SectionController::class, 'updateSectionStatus']);

        // Delete section
        Route::get('/delete-section/{id}', [SectionController::class, 'deleteSection']);

        // Add/Edit section
        Route::match(['get', 'post'], 'sections/add-edit-section/{id?}', [SectionController::class, 'addEditSection'])->name('admin.sections.add-edit-section');

        // Categories
        Route::get('/categories', [CategoryController::class, 'categories'])->name('admin.categories.categories');

        // Update category status
        Route::post('/update-category-status', [CategoryController::class, 'updateCategoryStatus']);

        // Delete category
        Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);

        //Append category level
        Route::get('append-category-level', [CategoryController::class, 'appendCategoryLevel'])->name('admins.categories.append-category-level');

        // Add/Edit category
        Route::match(['get', 'post'], '/categories/add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);

        // Delete category image
        Route::get('/delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);

        // Brands
        Route::get('/brands', [BrandController::class, 'brands'])->name('admin.brands.brands');

        // Update brand status
        Route::post('/update-brand-status', [BrandController::class, 'updateBrandStatus']);

        // Delete brand
        Route::get('/delete-brand/{id}', [BrandController::class, 'deleteBrand']);

        // Add/Edit brand
        Route::match(['get', 'post'], 'brands/add-edit-brand/{id?}', [BrandController::class, 'addEditBrand'])->name('admin.brands.add-edit-brand');

        // Values
        Route::get('/values', [ValueController::class, 'values'])->name('admin.values.values');

        // Delete value
        Route::get('/delete-value/{id}', [ValueController::class, 'deleteValue']);

        // Add/Edit value
        Route::match(['get', 'post'], 'values/add-edit-value/{id?}', [ValueController::class, 'addEditValue'])->name('admin.values.add-edit-value');

        // Options
        Route::get('/options', [OptionController::class, 'options'])->name('admin.options.options');

        // Delete option
        Route::get('/delete-option/{id}', [OptionController::class, 'deleteOption']);

        // Add/Edit option
        Route::match(['get', 'post'], 'options/add-edit-option/{id?}', [OptionController::class, 'addEditOption'])->name('admin.options.add-edit-option');

        // Products
        Route::get('/products', [ProductController::class, 'products'])->name('admin.products.products');

        // Update product status
        Route::post('/update-product-status', [ProductController::class, 'updateProductStatus']);

        // Delete product
        Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct']);

        // Add/Edit product
        Route::match(['get', 'post'], '/products/add-edit-product/{id?}', [ProductController::class, 'addEditProduct']);

        // Delete product image
        Route::get('/delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);

        //Attributes
        Route::match(['get', 'post'], '/attributes/add-edit-attributes/{id}', [ProductController::class, 'addEditAttributes']); 

        // Update attribute status
        Route::post('/update-attribute-status', [ProductController::class, 'updateAttributeStatus']);
        
        // Edit attribute
        Route::post('/edit-attributes/{id}', [ProductController::class, 'editAttributes']);

        // Add Images
        Route::match(['get', 'post'], '/add-images/{id}', [ProductController::class, 'addImages']);

        // Update image status
        Route::post('/update-image-status', [ProductController::class, 'updateImageStatus']);

        // Delete image
        Route::get('/delete-image/{id}', [ProductController::class, 'deleteImage']);

        /*=====================   Add option   ==============*/

        Route::get('product_options/{id}', [ProductController::class, 'getOption'])->name('getOption');

        Route::get('/get_option_value/{id}',[ProductController::class,'getOptionValue'])->name('get_option_value');

        Route::post('add_option',[ProductController::class,'addOption'])->name('addOption');

    });
});

Route::namespace('App\Http\Controller\Front')->group(function(){
    Route::get('/', [IndexController::class, 'index']);
});


