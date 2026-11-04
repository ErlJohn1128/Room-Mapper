<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class OverviewController extends Controller
{
   public function index(Request $request): View 
    {
        return view('admin.overview');
    }

}
