<?php

namespace App\Features\Context;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given nothing is happening
     */
    public function nothingIsHappening()
    {

    }

    /**
     * @When I visit the homepage
     */
    public function nothingHappens()
    {
        $this->visit('/');
    }
}
