<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest; // トランザクションを利用するため
use App\Http\Requests\UpdateTodoRequest; // Todoモデルを使用するため
use App\Models\Tag; // Tagモデルを使用するため
use App\Models\Todo; // 新規登録時のバリデーションを使用するため
use Illuminate\Support\Facades\DB; // 更新時のバリデーションを使用するため

class TodoController extends Controller
{
    /**
     * Todoの一覧を表示するメソッド
     */
    public function index()
    {
        /**************************************
        livewireを使用しない場合は、以下のようにコントローラ側で記載する必要がある（学習のためコメントアウトで記録）
        --------------------------------------
        // //Eager Loadの仕組みを採用。2回のクエリに分けてまとめて取得することで、N+1問題を回避する
        // //todosテーブルを全件セレクトした後、tag_todoテーブルを結合して紐づくtagテーブルのレコードも取得する
        // $query = Todo::with('tags');

        // // リクエストに優先度のキーが存在している、かつ空文字ではない
        // if ($request->filled('priority')) {
        //     // 指定した優先度でwhereを追加
        //     // Laravelのローカルスコープを利用している
        //     // Todoモデル内の"scope" + OfPriority()を自動検索して呼び出す
        //     $query->ofPriority($request->input('priority'));
        // }

        // // リクエストにタグIDのキーが存在している、かつ空文字ではない
        // if ($request->filled('tag_id')) {
        //     // 指定したタグでwhereを追加
        //     $query->ofTag($request->input('tag_id'));
        // }

        // // リクエストに完了ステータスのキーが存在している、かつ空文字ではない
        // if ($request->has('status')) {
        //     // 指定した完了ステータスでwhereを追加
        //     $query->ofStatus($request->boolean('status'));
        // }

        // // 条件にヒットするTodoを全件取得する
        // $todos = $query->get();
        --------------------------------------
        **************************************/

        return view('todos.index');
    }

    /**
     * Todo新規登録画面を表示するメソッド
     */
    public function create()
    {
        $tags = Tag::all();

        return view('todos.create', compact('tags'));
    }

    /**
     * Todoを新規登録処理するメソッド
     */
    public function store(StoreTodoRequest $request)
    {
        // リクエストされた各変数を取得する。バリデーション済み
        $validated = $request->validated();

        // トランザクション開始
        // Laravelの標準機能を使用する
        $todo = DB::transaction(function () use ($validated, $request) {
            // 新規レコードをINSERTする
            // マスアサインメントという仕組みを利用しており、Todoモデルの$fillableに含まれるカラムのみを書き込む
            $todo = Todo::create($validated);

            if ($request->has('tags')) {
                // tag_todoの内容を同期させる
                // 不要なレコードはdelete, 新規のレコードはinsertする（※新規登録では全て新規レコードのためdeleteは発生しないが、異常ケースでidが重複で登録された時に重複除去してくれるため採用）
                $todo->tags()->sync($request->input('tags'));
            }

            return $todo;
        });

        // 一覧画面へリダイレクトする
        return redirect()->route('todos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Todoの編集画面を表示するメソッド
     */
    public function edit(string $id)
    {
        $todo = Todo::findOrFail($id); // 更新したいTodoが存在するかチェック
        $tags = Tag::all(); // タグを全件取得

        return view('todos.edit', compact('todo', 'tags'));
    }

    /**
     * Todoを更新処理するメソッド
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        // リクエストされた各変数を取得する。バリデーション済み
        $validated = $request->validated();

        // トランザクション開始
        $todo = DB::transaction(function () use ($validated, $request, $id) {
            // 更新対象のTodoを取得（存在しなければ404を自動返却）
            // Eloquentの静的メソッドを使用
            // エラーハンドリングをLaravel側が担当してくれるメリットがある
            $todo = Todo::findOrFail($id);

            // マスアサインメントで更新
            $todo->update($validated);

            if ($request->has('tags')) {
                // tag_todoの内容を同期させる
                $todo->tags()->sync($request->input('tags'));
            }

            return $todo;
        });

        // 一覧画面へリダイレクトする
        return redirect()->route('todos.index');
    }

    /**
     * Todoを削除するメソッド
     */
    public function destroy(string $id)
    {
        // todoのidが存在するかどうかチェック（存在しなければ404を自動返却）
        $todo = Todo::findOrFail($id);

        // レコードを削除する
        $todo->delete();

        // 一覧画面へリダイレクトする
        return redirect()->route('todos.index');
    }
}
