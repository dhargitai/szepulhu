Feature: Featured professionals
  In order to find professionals in my area very fast
  as a user
  I need to see featured professionals listed on the homepage

  Background:
    Given I am on the homepage

  Scenario: There are one or more free featured professional slot in the selected county
    Given I am on the homepage
    When I select "Csongrád" county in the location selector
    And there isn't enough featured professionals to fill all the slots
    Then I should see silhouettes on the empty spaces linking to "/vallalkozasoknak"

  Scenario: There isn't any free featured professional slot in the selected city
    Given I am on the homepage
    When I select "Szeged" county in the location selector
    Then I shouldn't see any free featured professional slot

  Scenario: Geolocating the nearest location with featured professionals
    # Mórahalom
    Given the user shared his location's coordinates "46.21806000" as latitude and "19.88510000" as longitude
    When I wait for the featured professionals block's changing
    Then I should see "Szeged" in the location selector as nearest location
