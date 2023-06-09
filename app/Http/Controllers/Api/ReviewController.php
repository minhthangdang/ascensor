<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;
use App\Http\Helpers;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $movieId)
    {
        $review = $request->post('review');
        $rating = intval($request->post('rating'));

        if (Helpers::isReviewValid($review, $rating)) {
            $reviewModel = new Review;
            $reviewModel->review = $review;
            $reviewModel->rating = $rating;
            $reviewModel->movie_id = $movieId;
            $reviewModel->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Return 5 most recent resources
     */
    public function recent()
    {
        $reviews = Review::orderBy('created_at', 'desc')->with('movie')->limit(5)->get();
        return response()->json(['reviews' => $reviews]);
    }
}
