<?php

namespace App\Http\Controllers;

use App\Models\RssUrl;
use Illuminate\Http\Request;

class RssUrlController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function add(Request $req)
    {
        $this->validate($req,[
            "url" => "required|unique:rss_urls,url",
        ],[
            "url.unique" => "The url already exists"
        ]);

        $url = new RssUrl();
        $url->url = $req->url;
        $url->user_id = auth()->user()->id;
        $url->save();
        return [
            "status" => "ok",
            "msg" => "Url was added"
        ];
    }
    
    public function delete(Request $req)
    {
        $this->validate($req,[
            "urlId" => "required|exists:rss_urls,id"
        ]);

        $data = RssUrl::find($req->urlId,["id","url"]);

        $data->delete();

        return [
            "status" => "ok",
            "msg" => "Item was deleted"
        ];
    }

    public function getList(Request $req)
    {
        $lists = RssUrl::orderBy("id","desc")->with("user:id,name")->get();

        return response()->json($lists);
    }
}
