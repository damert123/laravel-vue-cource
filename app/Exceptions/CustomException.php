<?php

namespace App\Exceptions;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CustomException extends Exception
{
    protected $post;
    protected $operation;

    public function __construct(Post $post, $operation, string $message = "")
    {
        $this->post = $post;
        $this->operation = $operation;
        parent::__construct($message);
    }


    /**
     * Report the exception.
     */
    public function report(): void
    {
        $wasRecentlyCreated = $this->post->wasRecentlyCreated ? 'created' : 'updated';

        Log::channel('posts')->info("Post {$this->operation} - ID:  {$this->post->id}, Status:  {$wasRecentlyCreated}");
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => $this->message
        ]);
    }
}
