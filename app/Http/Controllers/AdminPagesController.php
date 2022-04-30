<?php

namespace App\Http\Controllers;

use App\Models\RssUrl;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AdminPagesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function home()
    {
        $rssUrls = RssUrl::orderBy("id","desc")->get();
        return view("admin.pages.home")->with(compact(
            "rssUrls"
        ));
    }

    public function rssToHtml(Request $req)
    {
        $this->validate($req,[
            "url" => "required"
        ]);
        $column = $req->column??4;
        $rssUrl = $req->url;
        $type = $req->type;
        $row = $req->row;

        $api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';

        $data = json_decode(file_get_contents($api_endpoint . urlencode($rssUrl)), true);
        
        if(!empty($data["status"]) && $data["status"] == "ok")
        {
            $blogs = $data["items"];
            $js = "";
            $css = "";

            if ($type == "grid") 
            {
                $html = view("admin.layouts.feed-grid-html")->with(compact(
                    "blogs",
                    "column",
                    "row"
                ))->render();
                $css = file_get_contents(public_path("css/templates/grid.css"));
            }
            else if($type == "masonry")
            {
                $html = view("admin.layouts.feed-masonry-html")->with(compact(
                    "blogs",
                    "column",
                    "row"
                ))->render();
            }
            else if($type == "carousel")
            {
                $html = view("admin.layouts.feed-carousel-html")->with(compact(
                    "blogs",
                    "column",
                    "row"
                ))->render();
                $css = file_get_contents(public_path("css/templates/carousel.css"));
                $js = view("admin.layouts.carousel-js",compact("column"))->render();
            }

            return [
                "status" => "ok",
                "html" => $html,
                "css" => $css,
                "js" => $js
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Couldn't fetch feed from the url.
                Please check the url and try again"
            ];
        }


    }

    public function addRss()
    {
        return view("admin.pages.add-rss");
    }

    public function rssList()
    {
        return view("admin.pages.list-rss");
    }

    public function myProfile()
    {
        $user = auth()->user();
        return view("admin.pages.my-profile",compact("user"));
    }


    public function userList()
    {
        if(auth()->user()->role == "super")
        {
            $users = User::orderBy("id","desc")->get();
            return view("admin.pages.super.user-list",compact("users"));
        }
        else
        {
            return [
                "status" => "fail",
                "message" => "You don't have permission to see this page"
            ];
        }
    }

    public function addUser()
    {
        if (auth()->user()->role == "super") {
            return view("admin.pages.super.add-user");
        } else {
            return [
                "status" => "fail",
                "message" => "You don't have permission to see this page"
            ];
        }
    }

    public function editUser(Request $req)
    {
        if($user = User::find($req->userid))
        {
            return view("admin.pages.super.edit-user",compact("user"));
        }
        else
        {
            return redirect()->back();
        }
    }

    public function carouselPreview(Request $req)
    {
        if($req->url != "")
        {
            $column = $req->column ?? 4;
            $rssUrl = $req->url;
            $row = $req->row;

            $api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';
            if($data = json_decode(@file_get_contents($api_endpoint . urlencode($rssUrl)), true))
            {
                if (!empty($data["status"]) && $data["status"] == "ok") 
                {
                    $blogs = $data["items"];
                    return view("admin.pages.carousel-prev")->with(compact(
                        "blogs",
                        "row",
                        "column"
                    ));

                } 
                else 
                {
                    return [
                        "status" => "failed",
                        "message" => "Remote api didn't returned any value"
                    ];
                }
            }
            else
            {
                return [
                    "status" => "failed",
                    "message" => "Failed to read data from the url. Check the url and try again"
                ];
            }

            


        }
        else
        {
            return [
                "status" => "failed",
                "message" => "Parameter missing"
            ];
        }
    }
}


