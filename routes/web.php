<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificatorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HelpdeskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\Owner\SalesController;
use App\Http\Controllers\SalesRecommendationController;

// Route untuk mengambil data produk dari database
Route::get('/cashier/products', [CashierController::class, 'getProducts']);

// Halaman Utama
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Middleware Auth & Verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Logika Redirect Berdasarkan Role
        if ($user->role_id === 1) {
            return redirect()->route('verificator.dashboard');
        } elseif ($user->role_id === 2) {
            if (!$user->is_approved) {
                Auth::logout();
                return redirect('/')->with('message', 'Your account is still pending approval from a verificator.');
            }
            return redirect()->route('owner.dashboard');
        } elseif ($user->role_id === 3) {
            // Employees dibagi menjadi cashier dan stock
            if ($user->employees_role === 'cashier') {
                return redirect()->route('employee.cashier');
            } elseif ($user->employees_role === 'stock') {
                return redirect()->route('employee.stock');
            } else {
                return redirect()->route('employee.dashboard');
            }
        }

        abort(403, 'Unauthorized action.');
    })->name('dashboard');

    // **Route untuk Employees**
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
        Route::get('/cashier', [EmployeeController::class, 'cashier'])->name('cashier');
        Route::get('/stock', [EmployeeController::class, 'stock'])->name('stock');
        
        // Route untuk menampilkan halaman Tambah Produk (khusus admin stok)
        Route::get('/stock/add', [ProductController::class, 'create'])->name('stock.add');
    
        // Route untuk menyimpan produk baru (khusus admin stok)
        Route::post('/stock', [ProductController::class, 'store'])->name('stock.store'); 
    
        // Route untuk melihat daftar produk (khusus admin stok)
        Route::get('/stock/products', [ProductController::class, 'index'])->name('stock.products');
        
        // Route untuk halaman invoice pembayaran
        Route::get('/invoice', function () {
            return Inertia::render('Employee/InvoicePembayaran');
        })->name('invoice');
    });

    // **Route untuk Owner**
    Route::prefix('owner')->name('owner.')->group(function () {
        // Owner dashboard
        Route::get('/dashboard', [EmployeeController::class, 'ownerDashboard'])->name('dashboard');
        
        // Route untuk cashier
        Route::get('/cashier', [EmployeeController::class, 'ownerCashier'])->name('cashier');
        
        // Route untuk stock management
        Route::get('/stock', [EmployeeController::class, 'ownerStock'])->name('stock');
        
        // Route untuk menampilkan halaman Tambah Produk
        Route::get('/stock/add', [ProductController::class, 'create'])->name('stock.add');
        
        // Route untuk menyimpan produk baru
        Route::post('/stock', [ProductController::class, 'store'])->name('stock.store'); 
        
        // Route untuk melihat daftar produk
        Route::get('/stock/products', [ProductController::class, 'index'])->name('stock.products');
        
        // Route untuk halaman invoice pembayaran
        Route::get('/invoice', function () {
            return Inertia::render('Employee/InvoicePembayaran');
        })->name('invoice');
    });

    // **Verifikator**
    Route::prefix('verificator')->name('verificator.')->group(function () {
        Route::get('/dashboard', [VerificatorController::class, 'dashboard'])->name('dashboard');
        Route::post('/approve/{id}', [VerificatorController::class, 'approveUser'])->name('approve');
        Route::post('/reject/{id}', [VerificatorController::class, 'rejectUser'])->name('reject');

        // Helpdesk di dalam verifikator
        Route::prefix('helpdesk')->name('helpdesk.')->group(function () {
            Route::get('/', [HelpdeskController::class, 'index'])->name('index'); // Lihat FAQ
            Route::get('/faq', [HelpdeskController::class, 'faq'])->name('faq'); // Lihat daftar FAQ
            Route::get('/create', [HelpdeskController::class, 'create'])->name('create'); // Tambah FAQ
            Route::post('/store', [HelpdeskController::class, 'store'])->name('store'); // Simpan FAQ
        });
    });

    // **Profil**
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Load Routes untuk Otentikasi (Bawaan Laravel)
require __DIR__.'/auth.php';

// Halaman Publik
Route::get('/faq', fn() => Inertia::render('FAQ'))->name('faq.index');
Route::get('/blog', fn() => Inertia::render('blog'))->name('blog.index');
Route::get('/Aboutus', fn() => Inertia::render('Aboutus'))->name('Aboutus.index');
Route::get('/FAQ', fn() => Inertia::render('FAQ'))->name('FAQ.index');  
Route::get('/pos-guide', fn() => Inertia::render('pos-guide'))->name('pos-guide.index'); 

// Resource Controller Employees (CRUD Pegawai)
Route::resource('employees', EmployeeController::class);


Route::middleware(['auth', 'role:verificator'])->group(function () {
    Route::get('/verificator/owners/{id}', [VerificatorController::class, 'showOwner'])->name('verificator.owners.show');
});

Route::get('/payment', function () {
    $user = Auth::user();
    
    if ($user && $user->role_id === 2) {
        // If owner, add owner payment route
        return inertia('Employee/Payment', [
            'returnRoute' => 'owner.cashier'
        ]);
    }
    
    // Default for employees
    return inertia('Employee/Payment', [
        'returnRoute' => 'employee.cashier'
    ]);
});

Route::post('/cashier/checkout', [CashierController::class, 'checkout']);

Route::get('/owner/sales', [SalesController::class, 'index'])->name('owner.sales');


// **Penambahan route untuk export CSV**

Route::middleware(['auth'])->group(function () {
    Route::get('/owner/sales', [SalesController::class, 'index'])->name('owner.sales');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/sales/export', [SalesController::class, 'export']);
});

Route::middleware(['auth'])->group(function () {
    // Route untuk halaman Rekomendasi Penjualan
    Route::get('/owner/salesrecommendation', [SalesRecommendationController::class, 'index'])->name('owner.sales.recommendation');
});
Route::get('/sales-recommendation/export', [SalesRecommendationController::class, 'exportCSV']); // Untuk download CSV