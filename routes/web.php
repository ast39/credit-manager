<?php

use App\Http\Controllers\Credit\{
    CreditController, CreditCalcController, CreditCheckController, CreditPaymentController
};

use Illuminate\Support\Facades\{
    Route, Auth
};

use App\Http\Controllers\{
    WallController, DemoController
};


Route::get('/', function () {
    return redirect('/wall');
});

# События
Route::get('wall', WallController::class)->middleware('auth')->name('wall.index');

# Демо доступ
Route::get('demo', DemoController::class)->name('demo.index');

# Кредит
Route::group(['prefix' => 'credit'], function() {

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('create', [CreditCalcController::class, 'create'])->name('credit.calc.create');
        Route::post('', [CreditCalcController::class, 'store'])->name('credit.calc.store');
        Route::get('{id}', [CreditCalcController::class, 'show'])->name('credit.calc.show');
    });

    # Проверка
    Route::group(['prefix' => 'check'], function () {

        Route::get('create', [CreditCheckController::class, 'create'])->name('credit.check.create');
        Route::post('', [CreditCheckController::class, 'store'])->name('credit.check.store');
        Route::get('{id}', [CreditCheckController::class, 'show'])->name('credit.check.show');
    });

});

# Кредит
Route::group(['prefix' => 'credit', 'middleware' => ['auth', 'verified']], function() {

    # Кредиты
    Route::group(['prefix' => 'item'], function () {

        Route::get('index/{sortable?}', [CreditController::class, 'index'])->name('credit.index');
        Route::get('create', [CreditController::class, 'create'])->name('credit.create');
        Route::post('', [CreditController::class, 'store'])->name('credit.store');
        Route::get('{id}', [CreditController::class, 'show'])->name('credit.show');
        Route::get('{id}/edit', [CreditController::class, 'edit'])->name('credit.edit');
        Route::put('{id}', [CreditController::class, 'update'])->name('credit.update');
        Route::delete('{id}', [CreditController::class, 'destroy'])->name('credit.destroy');
    });

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('', [CreditCalcController::class, 'index'])->name('credit.calc.index');
        Route::delete('{id}', [CreditCalcController::class, 'destroy'])->name('credit.calc.destroy');
    });

    # Проверка
    Route::group(['prefix' => 'check'], function () {

        Route::get('', [CreditCheckController::class, 'index'])->name('credit.check.index');
        Route::delete('{id}', [CreditCheckController::class, 'destroy'])->name('credit.check.destroy');
    });

    # Транзакции
    Route::group(['prefix' => 'payment'], function () {

        Route::get('create/{credit_id}', [CreditPaymentController::class, 'create'])->name('credit.payment.create');
        Route::post('', [CreditPaymentController::class, 'store'])->name('credit.payment.store');
        Route::delete('{id}', [CreditPaymentController::class, 'destroy'])->name('credit.payment.destroy');
    });
});

Auth::routes(['verify' => true]);
