<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class InfoPageController extends Controller
{
    public function index()
    {
        ob_start();
        include resource_path('pages/info.php');
        $content = ob_get_clean();

        return response($content, 200)
            ->header('Content-Type', 'text/html');
    }
}