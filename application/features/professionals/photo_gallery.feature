Feature: Display photo gallery of a professional
  In order to see some reference work
  As a visitor
  I need to browse the photo gallery

  Background:
    Given I am on the profile page of "mekk_elek"

  Scenario Outline: Use carousel
    Given I have a <Direction> arrow button
    When I click on it
    Then I should see a new list of photos from the gallery

    Examples:
      | Direction |
      | next      |
      | previous  |

  Scenario: View photo gallery
    When I click on any photo from the gallery
    Then I should see that image opened in a modal window
    And I should have a next button
    And I should have a previous button