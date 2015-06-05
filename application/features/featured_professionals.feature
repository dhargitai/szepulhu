Feature: Featured professionals
  In order to find professionals in my area very fast
  as a user
  I need to see featured professionals listed on the homepage

  Background:
    Given I am on the homepage

  @javascript
  Scenario: There are one or more free featured professional slot in the selected county
    When I select "Csongrád" county in the county selector
    And there isn't enough featured professionals to fill all the slots
    Then I should see silhouettes on the empty spaces linking to "/vallalkozasoknak"

  @javascript
  Scenario: There isn't any free featured professional slot in the selected city
    When I select "Szeged" county in the county selector
    Then I shouldn't see any free featured professional slot

#  Scenario: Visit from known county
#    When my location is in one of the country's county
#    And there are featured professionals in the current county
#    Then I should see featured professionals from my location's county
#    And the county selector should be on the county of "my location"
#
#  Scenario: Visit from unknown county
#    When my location is outside of the current country
#    And there are featured professionals in the capital's county
#    Then I should see featured professionals from the capital's county
#    And the county selector should be on the county of "the capital"