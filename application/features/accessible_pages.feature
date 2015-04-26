Feature: Accessible pages
  In order to use the application
  As a website visitor
  I need to be able to visit all the public pages without error

  Scenario: Open the homepage
    Given I am on the homepage
    Then the response status code should be 200

  Scenario: Open a professional's profile
    Given I am on the homepage
    When I go to one of the featured professionals
    Then the response status code should be 200

  Scenario: Open a salon's page
    Given I am on the homepage
    When I go to one of the featured professionals
    And I go to its salon
    Then the response status code should be 200
