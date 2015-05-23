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
