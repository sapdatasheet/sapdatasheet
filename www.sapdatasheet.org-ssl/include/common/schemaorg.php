<?php

// Classes for http://schema.org/ Objects

namespace OrgSchema;

class Thing {

    /**
     * The name of the item.
     *
     * Expected Type: Text
     */
    public $name;

    /**
     * An alias for the item.
     *
     * Expected Type: Text
     */
    public $alternateName;

    /**
     * A description of the item.
     *
     * Expected Type: Text
     */
    public $description;

    /**
     * A sub property of description. A short description of the item used to disambiguate from other, similar items. Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.
     *
     * Expected Type: Text
     */
    public $disambiguatingDescription;

    /**
     * URL of the item.
     *
     * Expected Type: URL
     */
    public $url;

    /**
     * URL of a reference Web page that unambiguously indicates the item's identity. E.g. the URL of the item's Wikipedia page, Freebase page, or official website.
     *
     * Expected Type: URL
     */
    public $sameAs;

    /**
     * An image of the item. This can be a URL or a fully described ImageObject.
     *
     * Expected Type: ImageObject or URL
     */
    public $image;

    /**
     * An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the 'typeof' attribute - for multiple types. Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.
     *
     * Expected Type: URL
     */
    public $additionalType;

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See background notes for details.
     *
     * Expected Type: CreativeWork or URL
     */
    public $mainEntityOfPage;

    /**
     * Indicates a potential Action, which describes an idealized action in which this thing would play an 'object' role.
     *
     * Expected Type: Action
     */
    public $potentialAction;

    /**
     * Convert to Json object for the Schema.org Object.
     *
     * @return string Object in JSON format
     */
    public function toJson() {
        $json = array();
        $refClass = new \ReflectionClass($this);
        $json['@context'] = 'http://schema.org/';
        $json['@type'] = $refClass->getShortName();
        foreach ($this as $key => $value) {
            if (empty($value) == FALSE) {
                $json[$key] = $value;
            }
        }
        return json_encode($json);
    }

}

/**
 * Class for CreativeWork object.
 * 
 * @see http://schema.org/CreativeWork
 */
class CreativeWork extends Thing {

    public $about;
    public $accessibilityAPI;
    public $accessibilityControl;
    public $accessibilityFeature;
    public $accessibilityHazard;
    public $accountablePerson;
    public $aggregateRating;
    public $alternativeHeadline;
    public $associatedMedia;
    public $audience;
    public $audio;
    public $author;
    public $award;
    public $character;
    public $citation;
    public $comment;
    public $commentCount;
    public $contentLocation;
    public $contentRating;
    public $contributor;
    public $copyrightHolder;
    public $copyrightYear;
    public $creator;
    public $dateCreated;
    public $dateModified;
    public $datePublished;
    public $discussionUrl;
    public $editor;
    public $educationalAlignment;
    public $educationalUse;
    public $encoding;
    public $exampleOfWork;
    public $fileFormat;
    public $genre;
    public $hasPart;
    public $headline;
    public $inLanguage;
    public $interactionStatistic;
    public $interactivityType;
    public $isBasedOn;
    public $isFamilyFriendly;
    public $isPartOf;
    public $keywords;
    public $learningResourceType;
    public $license;
    public $locationCreated;
    public $mainEntity;
    public $mentions;
    public $offers;
    public $position;
    public $producer;
    public $provider;
    public $publication;
    public $publisher;
    public $publishingPrinciples;
    public $recordedAt;
    public $releasedEvent;
    public $review;
    public $schemaVersion;
    public $sourceOrganization;
    public $text;
    public $thumbnailUrl;
    public $timeRequired;
    public $translator;
    public $typicalAgeRange;
    public $version;
    public $video;
    public $workExample;

}

/**
 * Class for Book object.
 * 
 * @see http://schema.org/Book
 */
class Book extends CreativeWork {

    public $bookEdition;
    public $bookFormat;
    public $illustrator;
    public $isbn;
    public $numberOfPages;

}
