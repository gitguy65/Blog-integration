<?php

namespace App\Http\Controllers;

use BinshopsBlog\Laravel\Fulltext\Search;
use Illuminate\Http\Request;
use BinshopsBlog\Models\BinshopsCategory;
use BinshopsBlog\Models\BinshopsLanguage; 
use BinshopsBlog\Models\BinshopsPostTranslation;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request, $category_slug = null)
    {
        $locale = $request->get('locale', 'en');
        $lang_id = BinshopsLanguage::where('locale', $locale)->first()->id;

        $title = 'Blog Page'; // default title...
        $categoryChain = null;
        $posts = array();

        if ($category_slug) {
            $category = BinshopsCategory::where("slug", $category_slug)->firstOrFail();
            $categoryChain = $category->getAncestorsAndSelf();
            $posts = $category->posts()->where("binshops_post_categories.category_id", $category->id)
                ->with(['postTranslations' => function($query) use ($lang_id) {
                    $query->where("lang_id", $lang_id);
                }])
                ->paginate(config("binshopsblog.per_page", 10));

            \View::share('binshopsblog_category', $category);
            $title = 'Posts in ' . $category->category_name . " category";
        } else {
            $posts = BinshopsPostTranslation::join('binshops_posts', 'binshops_post_translations.post_id', '=', 'binshops_posts.id')
                ->where('lang_id', $lang_id)
                ->where("is_published", true)
                ->where('posted_at', '<', Carbon::now()->format('Y-m-d H:i:s'))
                ->orderBy("posted_at", "desc")
                ->paginate(config("binshopsblog.per_page", 10));
        }

        $rootList = BinshopsCategory::roots()->get();
        BinshopsCategory::loadSiblingsWithList($rootList);

        return view("binshopsblog::index", [
            'lang_list' => BinshopsLanguage::all('locale', 'name'),
            'locale' => $locale,
            'lang_id' => $lang_id,
            'category_chain' => $categoryChain,
            'categories' => $rootList,
            'posts' => $posts,
            'title' => $title,
            'routeWithoutLocale' => $request->get("routeWithoutLocale"),
        ]);
    }

    public function search(Request $request)
    {
        if (!config("binshopsblog.search.search_enabled")) {
            throw new \Exception("Search is disabled");
        }
        $query = $request->get("s");
        $search = new Search();
        $search_results = $search->run($query);

        \View::share("title", "Search results for " . e($query));

        $rootList = BinshopsCategory::roots()->get();
        BinshopsCategory::loadSiblingsWithList($rootList);

        return view("binshopsblog::search", [
            'lang_id' => $request->get('lang_id'),
            'locale' => $request->get("locale", "en"),
            'categories' => $rootList,
            'query' => $query,
            'search_results' => $search_results,
            'routeWithoutLocale' => $request->get("routeWithoutLocale")
        ]
        );
    }

    public function view_category(Request $request)
    {
        $hierarchy = $request->route('subcategories');

        $categories = explode('/', $hierarchy);
        return $this->index($request->get('locale', 'en'), $request, end($categories));
    }

    public function viewSinglePost(Request $request, $post_slug)
    {
        $locale = $request->get('locale', 'en');
        $lang_id = BinshopsLanguage::where('locale', $locale)->first()->id;

        $post = BinshopsPostTranslation::where('slug', $post_slug)
            ->where('lang_id', $lang_id)
            ->firstOrFail();

        return view('binshopsblog::single_post', [
            'post' => $post,
            'locale' => $locale,
        ]);
    }

}
