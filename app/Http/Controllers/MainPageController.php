<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class MainPageController extends Controller
{
    public function index()
    {
        ob_start();
        include resource_path('pages/mainpage.php');
        $content = ob_get_clean();

        return response($content, 200)
            ->header('Content-Type', 'text/html');
    }

    //quite complicated but it is the way to not to show up 1 as the success on the page lmao.
}