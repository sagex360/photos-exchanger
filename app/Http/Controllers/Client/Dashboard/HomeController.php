<?php


namespace App\Http\Controllers\Client\Dashboard;


use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.client.dashboard.index');
    }
}
