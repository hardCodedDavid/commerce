<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function action(Review $review, $action)
    {
        if ($review['status'] == $action)
            return back()->with('error', 'Review already '.$action);
        $review->update(['status' => $action]);
        return back()->with('success', 'Review '.$action);
    }
}
