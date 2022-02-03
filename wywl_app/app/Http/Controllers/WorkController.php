<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Want;
use App\Models\User;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ホーム
    public function index()
    {
        $wants = Want::where('user_id', Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3);
        return view('wants', [
            'wants' => $wants,
            'user_name' => Auth::user()->name,
            'target_amount' => Auth::user()->target_amount,
        ]);
    }

    // 登録
    public function store(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'want_name' => 'required|min:3|max:255',
            'want_amount' => 'required|max:100000000',
        ]);

        // バリデーション：エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $file = $request->file('want_image'); // file取得
        if (!empty($file)) {                  // fileが空かチェック
            $filename = $file->getClientOriginalName();     // ファイル名を取得
            $move = $file->move('./upload/', $filename);    // ファイルを移動:パスが"./upload"の場合もあるCloud9
        } else {
            $filename = "";
        }

        // Eloquentモデル（登録処理）
        $wants = new Want;
        $wants->user_id = Auth::user()->id;
        $wants->want_name = $request->want_name;
        $wants->want_amount = $request->want_amount;
        $wants->want_image = $filename;
        $wants->save();
        return redirect('/')->with('message', '欲しいもの登録が完了しました');
    }

    // 欲しいもの更新画面
    public function edit($want_id)
    {
        $wants = Want::where('user_id', Auth::user()->id)->find($want_id);
        return view('wantsedit', ['want' => $wants]);
    }

    // 欲しいもの更新処理
    public function update(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'want_name' => 'required|min:3|max:255',
            'want_amount' => 'required|max:100000000',
        ]);
        // バリデーション：エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        // データ更新
        $wants = Want::where('user_id', Auth::user()->id)->find($request->id);
        $wants->user_id = Auth::user()->id;
        $wants->want_name = $request->want_name;
        $wants->want_amount = $request->want_amount;
        $wants->save();
        return redirect('/');
    }

    // 削除
    function destroy(Want $want)
    {
        $want->delete();
        return redirect('/');
    }
}
