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

    public function root(): View
    {
        $link = Link::where('path', '=', '/')->first();

        return $this->serve($link);
    }

    private function serve(?Link $link): View
    {
        if ($link == null) {
            abort(404);
        }

        $post = $link->post;
        if ($post == null) {
            abort(404);
        }

        $secondaryMenu = $link->menusEntries()
            ->where('menu', '!=', 'main')
            ->first();

        return view('app')->with([
            'content' => $this->markdown->toHtml($post->content),
            'path' => $link->path,
            'title' => $post->title,
            'secondaryMenu' => $secondaryMenu ? $secondaryMenu->menu : null,
        ]);
    }

    /**
     * Handle the incoming request on arbitrary path.
     */
    public function path(Request $request): Factory|View
    {
        $link = Link::where('path', '=', urldecode($request->path()))->first();

        return $this->serve($link);
    }
}
