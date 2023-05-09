<?php

namespace App\Http;

class Helpers {
    /**
     * Check if a submitted review is valid
     * 
     * @param string $review the review text
     * @param int $rating the rating value (one to five)
     * @return bool true if the review is valid
     */
    public static function isReviewValid(string $review, int $rating) : bool
    {
        if (empty($review) || empty($rating)) {
            return false;
        } else if (($rating > 5) || ($rating < 0)) {
            return false;
        } else {
            return true;
        }
    }
}