Feature: Homepage
  In order to get information about professionals in my area
  as a user
  I need to see the homepage

  Background:
    Given I am on the homepage

  Scenario Outline: Use the navigation menu
    When I follow the link in the navigation menu with label "<label>"
    Then I should get on the "<target>" page

    Examples:
      | label                   | target              |
      | Fotók                   | Photos              |
      | Hogy működik?           | How It Works        |
      | Regisztráció            | Registration        |
      | Belépés                 | Login               |
      | Hirdesd a vállalkozásod | List Your Business  |
