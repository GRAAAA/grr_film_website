<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewPageController extends Controller
{
    public function ShowForm()
    {
        ob_start();
        include resource_path('pages/review.php');
        $content = ob_get_clean();

        return response($content, 200)
            ->header('Content-Type', 'text/html');
    }
    // Handle form submission
    public function submitReview(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);

        \DB::table('reviews')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // Redirect back with success message
        return redirect('/review')->with('success', 'Review submitted successfully!');
    }
}
