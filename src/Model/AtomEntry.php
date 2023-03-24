<?php declare(strict_types=1);


namespace Cspray\StdBlog\Model;


use DateTimeInterface;
use TightenCo\Jigsaw\Jigsaw;

class AtomEntry {

    private Jigsaw $jigsaw;
    private Post $post;

    public function __construct(Jigsaw $jigsaw, Post $post) {
        $this->jigsaw = $jigsaw;
        $this->post = $post;
    }

    public function getId() : string {
        return $this->getUrl();
    }

    public function getTitle() : string {
        return $this->post->title;
    }

    public function getAuthor() : Author {
        return $this->post->getAuthor();
    }

    public function getUpdated() : string {
        return $this->post->getDate()->format(DateTimeInterface::RFC3339);
    }

    public function getSummary() : string {
        return $this->post->getSummary();
    }

    public function getContent() : string {
        return $this->post->getContent();
    }

    public function getUrl() : string {
        return sprintf(
            '%s%s',
            $this->jigsaw->getConfig('atomFeed.url'),
            $this->post->getUrl()
        );
    }

}