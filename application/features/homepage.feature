@core
Feature: Homepage
  In order to get information about professionals in my area
  as a user
  I need to see the homepage

  Background:
    Given I am on the homepage

  Scenario: Navigation
    Then I should see the following navigation links:
      | label              | target page          |
      | Browse photos      | Photos               |
      | How it works       | How It Works         |
      | Sign up            | Clients\Registration |
      | Log in             | Clients\Login        |
      | List your business | List Your Business   |

  Scenario: Search for professionals
    Given I fill the search fields with the following properties
      | Name of the service?  | Service location? | Appointment date? | Appointment time? |
      | hajfestés             | hodmezovasarhely  |                   |                   |
    When I press the "Search" button
    Then I should see the search result page
    And I should see the list of matching professionals

  Scenario: Validation error when searching for professionals
    Given I leave the search form empty
    When I press the "Search" button
    Then I should see the message "Alter search parameters to get results."
    And I should not see any result

  Scenario: View featured professionals
    Given I am logged out
    When I visit the homepage
    And I select "Budapest" city in the location selector
    Then I should see basic information about a list of featured professionals like
      | Name          | Profession  | Photo                                                             |
      | Jakabné Gipsz | Fodrász     | stock-photo-young-woman-portrait-isolated-on-white-115309930.jpg  |

  Scenario: Filter featured professionals by region
    Given I am logged out
    When I go to the homepage
    And I select "Csongrád" county in the location selector
    Then I should see only professionals from "Csongrád" county

  Scenario: Browse the list of professionals
    Given I am logged out
    And I am on the homepage
    When I select the location "szeged" on the search form
    And I press the "Search" button
    Then I should be on the Book an Appointment page
    And I should see basic information of a professional
      | name            |
      | profession      |
      | salon           |
      | postal_address  |
      | link_to_profile |
      | link_to_map     |
      | photo           |