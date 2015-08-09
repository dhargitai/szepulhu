Feature: Registration for clients
  In order to use all frontend functionality of the website
  As a user
  I need to register myself as a client

  Background:
    Given I am on the client registration page

  Scenario Outline: Register providing invalid data
    Given I fill in the form with these data
      | Field           | Value                   |
      | First name      | <first_name>            |
      | Last name       | <last_name>             |
      | Email           | <email>                 |
      | Username        | <username>              |
      | Password        | <password>              |
      | Repeat password | <password_confirmaton>  |
    When I submit the registration form
    Then I should not proceed with the process
    And I should see error messages next to the input fields
      | Field           | Message                         |
      | First name      | <first_name_message>            |
      | Last name       | <last_name_message>             |
      | Email           | <email_message>                 |
      | Username        | <username_message>              |
      | Password        | <password_message>              |
      | Repeat password | <password_confirmaton_message>  |

    Examples:
      | first_name | first_name_message           | last_name | last_name_message           | email                     | email_message                       | password  | password_message                                | password_confirmaton | password_confirmaton_message         | username  | username_message                |
      |            | Please enter your first name |           | Please enter your last name |                           | Please enter an email               |           | Please enter a password                         |                      |                                      |           | Please enter a username         |
      | Jakab      |                              | Gipsz     |                             | gipszjakab@invalid-email  | The email is not valid              | asdf1234  |                                                 | asdf1234             |                                      | testuser1 |                                 |
      | Jakab      |                              | Gipsz     |                             | foo.bar@server.com        | The email is already used           | asdf1234  |                                                 | asdf1234             |                                      | foobar    | The username is already used    |
      | Jakab      |                              | Gipsz     |                             | gipsz.jakab@gmail.com     |                                     | a2345     | The password must be at least 8 characters long | a2345                |                                      | testuser1 |                                 |
      | Jakab      |                              | Gipsz     |                             | gipsz.jakab@gmail.com     |                                     | a23456    | The entered passwords don't match               | b23456               |                                      | testuser1 |                                 |

  Scenario: Register with valid data
    Given I fill in the form with these data
      | Field           | Value                   |
      | First name      | Jakab                   |
      | Last name       | Gipsz                   |
      | Email           | gipszjakab@email.hu     |
      | Username        | jakab2015               |
      | Password        | asdf1234                |
      | Repeat password | asdf1234                |
    When I submit the registration form
    Then I should be redirected to the registration confirmation page
    And I should see the navigation menu for registered clients

  Scenario: Registered client logs in with email
    Given I am on the client login page
    When I log in with "foo.bar@server.com" and "asdf1234"
    Then I should see the message "Welcome Pista Kiss!"

  Scenario: Registered client logs in with username
    Given I am on the client login page
    When I log in with "foobar" and "asdf1234"
    Then I should see the message "Welcome Pista Kiss!"

  Scenario: Registered client logs out
    Given I am logged in as "foo.bar@server.com" and "asdf1234"
    When I click on the "Logout" link
    Then I should see the "Log in" link