<?php

namespace App\Http\Controllers;

use App\Models\FrontendSection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebController extends Controller
{

    public function index(): View
    {
        $title = "Home";
        return view('frontend.home', compact('title'));
    }

    public function pages($key , $id): View
    {
        $title = "Pages";
        $data = FrontendSection::where('id',$id)->first();
        $description = getArrayValue($data ->section_value, 'details');

        return view('frontend.pages', compact('title',"description",'key'));
    }
}
