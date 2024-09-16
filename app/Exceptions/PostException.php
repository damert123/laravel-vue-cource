<?php

namespace App\Exceptions;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostException extends Exception
{



    public function __construct(private Post $post, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::channel('posts')->info('Post already exists {id}', ['id' => $this->post->id]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => $this->message,
        ], $this->code);
    }

    public static function checkIfPostExists(Post $post)
    {
        if (!$post->wasRecentlyCreated){
            throw new self ($post, 'Post already exists', 200);
        }

    }
}
