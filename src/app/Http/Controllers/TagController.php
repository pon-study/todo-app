<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest; // Tagモデルを使用
use App\Http\Requests\UpdateTagRequest; // 新規登録時のバリデーションを使用するため
use App\Models\Tag; // 更新時のバリデーションを使用するため

class TagController extends Controller
{
    /**
     * タグの一覧を表示するメソッド
     */
    public function index()
    {
        // タグを全件取得
        $tags = Tag::orderBy('created_at', 'desc')->get();

        // compactはPHPの標準機能
        // ['tags' => $tags]という連想配列を用意する
        // Viewがでは$tagsで使用できる
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * タグを新規登録するメソッド
     */
    public function store(StoreTagRequest $request)
    {
        // リクエストされた各変数を取得する。バリデーション済み
        $validated = $request->validated();

        Tag::create($validated);

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * タグの編集画面
     */
    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, string $id)
    {
        // tag.idのレコードが存在するかチェック（存在しない場合は404エラー）
        $tag = Tag::findOrFail($id);

        // バリデーション通過したカラムのみ取得
        $validated = $request->validated();

        $tag->update($validated);

        return redirect()->route('tags.index');
    }

    /**
     * タグを削除するメソッド
     */
    public function destroy(string $id)
    {
        // tag.idのレコードが存在するかチェック（存在しない場合は404エラー）
        $tag = Tag::findOrFail($id);

        // タグの削除を実行
        $tag->delete();

        return redirect()->route('tags.index');
    }
}
