<?php


namespace App\Http\Controllers\Admin;


use App\Crawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacebookSdkController extends Controller
{
    public function index(Request $request, Crawler $crawler) {
        $type = $request->get('type');
        $id_fb = $request->get('id_fb');
        $access_token = $request->get('access_token');
        
        $feeds = [];
        if ($type && $id_fb) {
            switch ($type) {
                case "GROUP":
                    $feeds = $crawler->getFeedOfGroup($id_fb, $access_token, 12);
                    break;
                case "FANPAGE":
                    $feeds = $crawler->getFeedOfFanpage($id_fb, $access_token, 12);
                    break;
            }
        } else {
            $feeds = [];
        }
        
        return view("FacebookSDK.index", compact('feeds'));
    }
}