<?php declare(strict_types=1);

namespace Cspray\StdBlog\Model;

use DateTimeImmutable;
use DateTimeInterface;
use TightenCo\Jigsaw\Collection\Collection;
use TightenCo\Jigsaw\Collection\CollectionItem;
use RuntimeException;

class Post extends CollectionItem {

    private Author $author;
    private bool $isPublished;
    private string $summary;

    public static function fromItem(CollectionItem $item, bool $strictSummaryMode = true) : Post {
        $source = $item->getSource();
        $summary = $item->summary;
        if ($strictSummaryMode && empty($summary)) {
            throw new RuntimeException(sprintf(
                'The post titled "%s" does not have a summary. Please define a summary in the front matter of all posts.',
                $item->title
            ));
        }

        $post = parent::fromItem($item);
        $tags = self::convertTagsToModel($post);

        $post->isPublished = strpos($source, '/_posts/draft') === false;
        $post->summary = $summary;
        $post->author = new Author($item->author->name);

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

    public function getDate() : DateTimeInterface {
        if (is_int($this->date)) {
            return new DateTimeImmutable('@' . $this->date, new \DateTimeZone('America/New_York'));
        } else {
            return DateTimeImmutable::createFromFormat('Y-m-d H:i', $this->date, new \DateTimeZone('America/New_York'));
        }
    }

    public function getHumanFriendlyDate() : string {
        return $this->getDate()->format('F jS, o');
    }

    public function getAuthor() : Author {
        return $this->author;
    }

    public function getSummary() : string {
        return $this->summary;
    }

    public function isTagged(string $tag) : bool {
        /** @var Collection $tags */
        $tags = $this->tags;
        return $tags->search(function($item) use($tag) {
            return $item->getName() === $tag;
        }) !== false;
    }


    public function isPublished() : bool {
        return $this->isPublished;
    }

}