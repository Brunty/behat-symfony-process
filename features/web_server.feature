@run-server
Feature: I can load the homepage without error

  Scenario: Blah blah this doesn't matter...
    Given nothing is happening
    When I visit the homepage
    Then I should see "Hello World!"
