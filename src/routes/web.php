<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TagController; // Route文を記載するときにフルパスを指定せずにTodoControllerと記述できるようにするために記載。
use App\Http\Controllers\TodoController; // Route文を記載するときにフルパスを指定せずにTagControllerと記述できるようにするために記載。
use Illuminate\Support\Facades\Route; // カレンダーコントローラ

/*
指定のURLに対して、7つのCRUD操作をそれぞれ対応したメソッドにルーティングしている
Route::resourceとき記載することで、index, create, store, show, edit, update, destroyのメソッドがそれぞれ別のURLで呼び出される
*/
Route::resource('todos', TodoController::class);
Route::resource('tags', TagController::class);

Route::get('/', function () {
    return redirect()->route('todos.index');
});

// /calendarで遷移したときは、calendar/index.blade.phpを表示する
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
