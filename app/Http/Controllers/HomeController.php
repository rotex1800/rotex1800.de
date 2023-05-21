<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class HomeController extends Controller
{
    private MarkdownRenderer $markdown;

    public function __construct()
    {
        $this->markdown = app(MarkdownRenderer::class);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $file = Storage::disk('content')->get('example.md');

        return view('home')->with(['content' => $this->markdown->toHtml($file),
        ]);
    }
}
