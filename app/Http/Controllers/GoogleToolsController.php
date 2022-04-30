<?php

namespace App\Http\Controllers;

use App\Models\GoogleTools;
use Illuminate\Http\Request;

class GoogleToolsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function update(Request $req)
    {
        $data = GoogleTools::find(1);
        $data->analyticsId = $req->trackingId;
        $data->adsenseId = $req->adsenseId;
        $data->save();

        session()->flash('success',"Data was updated");
        return redirect()->back();
    }
}
