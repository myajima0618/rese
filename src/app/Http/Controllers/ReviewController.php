<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;



class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $review = $request->only(['user_id', 'shop_id', 'rating', 'comment']);
        $review['reservation_id'] = $request->id;
        Review::create($review);

        return redirect('/done')->with('message', '投稿ありがとうございました。');
    }
}
