Feature: Homepage
  In order to get information about professionals in my area
  as a user
  I need to see the homepage

  Background:
    Given I am on the homepage

  Scenario: Navigation
    Then I should see the following navigation links:
      | label                   | target page         |
      | Fotók                   | Photos              |
      | Hogy működik?           | How It Works        |
      | Regisztráció            | Registration        |
      | Belépés                 | Login               |
      | Hirdesd a vállalkozásod | List Your Business  |

  Scenario: Search for professionals
    Given I fill the search fields with the following properties
      | Name of the service?  | Service location? | Appointment date? | Appointment time? |
      | hajfestés             | hodmezovasarhely  |                   |                   |
    When I press the "Search" button
    Then I should see the search result page
    And I should see the list of matching professionals