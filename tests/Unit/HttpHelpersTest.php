<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Helpers;

class HttpHelpersTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_review_valid_false(): void
    {
        $review = '';
        $rating = 1;
        $result = Helpers::isReviewValid($review, $rating);
        $this->assertFalse($result);
    }

    public function test_is_review_valid_true(): void
    {
        $review = 'hello world';
        $rating = 1;
        $result = Helpers::isReviewValid($review, $rating);
        $this->assertTrue($result);
    }

    public function test_is_review_valid_rating(): void
    {
        $review = 'hello world';
        $rating = 6;
        $result = Helpers::isReviewValid($review, $rating);
        $this->assertFalse($result);
    }
}
