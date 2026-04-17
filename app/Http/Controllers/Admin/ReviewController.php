<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
