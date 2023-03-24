<?php declare(strict_types=1);

namespace Cspray\StdBlog\EventListeners;

use Cspray\StdBlog\Model\AtomEntry;
use Cspray\StdBlog\Model\AtomFeed;
use DOMDocument;
use TightenCo\Jigsaw\Jigsaw;

class AtomFeedGenerator {

    public function handle(Jigsaw $jigsaw) {
        $atomFeed = $this->createAtomFeedModel($jigsaw);
        $this->generateAtomFeedFile($jigsaw, $atomFeed);
    }

    private function createAtomFeedModel(Jigsaw $jigsaw) : AtomFeed {
        $posts = $jigsaw->getCollection('posts');
        $atomFeed = new AtomFeed($jigsaw);

        foreach ($posts as $post) {
            if (!$post->isPublished()) {
                continue;
            }
            $atomFeed->addEntry(new AtomEntry($jigsaw, $post));
        }

        return $atomFeed;
    }

    private function generateAtomFeedFile(Jigsaw $jigsaw, AtomFeed $atomFeed) : void {
        $domDocument = new DOMDocument();
        $domDocument->formatOutput = true;
        $domDocument->encoding = 'utf-8';
        $domDocument->xmlVersion = '1.0';

        $feed = $domDocument->createElement('feed');
        $xmlnsAttr = $domDocument->createAttribute('xmlns');
        $xmlnsAttr->value = 'http://www.w3.org/2005/Atom';
        $feed->setAttributeNode($xmlnsAttr);

        $feedId = $domDocument->createElement('id');
        $feedId->nodeValue = $atomFeed->getId();

        $feedLink = $domDocument->createElement('link');
        $feedLinkHref = $domDocument->createAttribute('href');
        $feedLinkHref->value = $jigsaw->getConfig('atomFeed.url');
        $feedLink->setAttributeNode($feedLinkHref);

        $feedTitle = $domDocument->createElement('title');
        $feedTitle->nodeValue = $atomFeed->getTitle();

        $feedUpdated = $domDocument->createElement('updated');
        $feedUpdated->nodeValue = $atomFeed->getUpdated();


        $generator = $domDocument->createElement('generator');
        $generatorUri = $domDocument->createAttribute('uri');
        $generatorUri->value = 'https://github.com/cspray/stdblog';
        $generator->setAttributeNode($generatorUri);
        $generatorVersion = $domDocument->createAttribute('version');
        $generatorVersion->value = '1.0';
        $generator->setAttributeNode($generatorVersion);
        $generator->nodeValue = 'cspray/stdblog';

        $feed->appendChild($feedId);
        $feed->appendChild($feedTitle);
        $feed->appendChild($feedLink);
        $feed->appendChild($feedUpdated);
        $feed->appendChild($generator);

        /** @var AtomEntry $atomEntry */
        foreach ($atomFeed as $atomEntry) {
            $entry = $domDocument->createElement('entry');

            $entryId = $domDocument->createElement('id');
            $entryId->nodeValue = $atomEntry->getId();

            $entryTitle = $domDocument->createElement('title');
            $entryTitle->nodeValue = $atomEntry->getTitle();

            $entryAuthor = $domDocument->createElement('author');
            $entryAuthorName = $domDocument->createElement('name');
            $entryAuthorName->nodeValue = $atomEntry->getAuthor()->getName();
            $entryAuthor->appendChild($entryAuthorName);

            $entryLink = $domDocument->createElement('link');
            $entryLinkHref = $domDocument->createAttribute('href');
            $entryLinkHref->value = $atomEntry->getUrl();
            $entryLink->setAttributeNode($entryLinkHref);

            $entryUpdated = $domDocument->createElement('updated');
            $entryUpdated->nodeValue = $atomEntry->getUpdated();

            $entrySummary = $domDocument->createElement('summary');
            $entrySummary->nodeValue = $atomEntry->getSummary();

            $entryContent = $domDocument->createElement('content');
            $langAttribute = $domDocument->createAttribute('lang');
            $langAttribute->value = 'en';
            $entryContent->setAttributeNode($langAttribute);
            $entryContent->nodeValue = $atomEntry->getContent();

            $entry->appendChild($entryId);
            $entry->appendChild($entryTitle);
            $entry->appendChild($entryAuthor);
            $entry->appendChild($entryLink);
            $entry->appendChild($entryUpdated);
            $entry->appendChild($entrySummary);
            $entry->appendChild($entryContent);
            $feed->appendChild($entry);
        }

        $domDocument->appendChild($feed);
        $jigsaw->writeOutputFile(
            'feed.atom',
            $domDocument->saveXML()
        );
    }

}