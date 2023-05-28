<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function __invoke(Request $request): Factory|View
    {
        $fileContent = Storage::disk('content')->get('example.md');
        if ($fileContent == null) {
            abort(404);
        }
        return view('home')->with(['content' => $this->markdown->toHtml($fileContent)]);
    }
}
