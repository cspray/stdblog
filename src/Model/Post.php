<?php declare(strict_types=1);

namespace Cspray\StdBlog\Model;

use Illuminate\Support\HtmlString;
use TightenCo\Jigsaw\Collection\Collection;
use TightenCo\Jigsaw\Collection\CollectionItem;
use RuntimeException;

class Post extends CollectionItem {

    private string|HtmlString $excerpt;

    public static function fromItem(CollectionItem $item) : Post {
        $post = parent::fromItem($item);

        $tags = self::convertTagsToModel($post);

        $post->addVariables([
            'tags' => $tags
        ]);

        return $post;
    }

    private static function convertTagsToModel(Post $post) : Collection {
        $tags = $post->tags;
        $newTags = new Collection();
        $newTags->name = 'tags';
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $newTags->push(new Tag(trim($tag)));
            }
        } elseif (is_string($tags)) {
            $tags = explode(',', $tags);
            foreach ($tags as $tag) {
                $newTags->push(new Tag(trim($tag)));
            }
        } elseif (is_null($tags)) {
            // There is nothing to do here but we don't want to bail out just because a post may not have a tag
        } else {
            throw new RuntimeException('Could not parse a tags setting that is not an array or string');
        }

        return $newTags;
    }

    public function excerpt() : string|HtmlString {
        if (!isset($this->excerpt)) {
            $content = $this->getContent();
            $morePos = strpos($content, '<!--excerpt-->');
            if (!$morePos) {
                $this->excerpt = '';
            } else {
                $this->excerpt = new HtmlString(trim(substr($content, 0, $morePos)));
            }
        }

        return $this->excerpt;
    }

    public function isTagged(string $tag) : bool {
        /** @var Collection $tags */
        $tags = $this->tags;
        return $tags->search(function($item) use($tag) {
            return $item->getName() === $tag;
        }) !== false;
    }


}