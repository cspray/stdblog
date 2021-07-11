<?php declare(strict_types=1);

namespace Cspray\StdBlog\Configuration;

use Cspray\StdBlog\Model\Post;
use Illuminate\Container\Container;

class PostsCollectionConfig {

    private string $layout;
    private string $layoutSection;
    private string $urlPath;
    private bool $strictSummaryMode;

    public function __construct(
        string $layout = '_layouts.post',
        string $layoutSection = 'content',
        string $urlPath = 'blog/{-title}',
        bool $strictSummaryMode = true
    ) {
        $this->layout = $layout;
        $this->layoutSection = $layoutSection;
        $this->urlPath = $urlPath;
        $this->strictSummaryMode = $strictSummaryMode;
    }

    public function toArray() : array {
        return [
            'posts' => [
                'path' => $this->urlPath,
                'extends' => $this->layout,
                'section' => $this->layoutSection,
                'sort' => '-date',
                'map' => function($post) {
                    return Post::fromItem($post, $this->strictSummaryMode);
                },
                'filter' => function($post) {
                    $isProduction = Container::getInstance()->get('config')['production'];
                    return !$isProduction || $post->isPublished();
                }
            ]
        ];
    }

}