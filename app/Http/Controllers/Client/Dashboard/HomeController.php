<?php


namespace App\Http\Controllers\Client\Dashboard;


use App\Http\Controllers\Controller;

final class HomeController extends Controller
{
    public function index()
    {
        return view('pages.client.dashboard.index');
    }
}
