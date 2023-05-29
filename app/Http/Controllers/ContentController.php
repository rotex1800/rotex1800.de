<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class ContentController extends Controller
{
    private MarkdownRenderer $markdown;

    public function __construct()
    {
        $this->markdown = app(MarkdownRenderer::class);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Link $link): Factory|View
    {
        $post = $link->post;
        if ($post == null) {
            abort(404);
        }
        return view('home')->with(['content' => $this->markdown->toHtml($post->content)]);
    }
}
