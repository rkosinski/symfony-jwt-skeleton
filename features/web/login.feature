Feature: Login page
    Different scenarios with login

    Scenario: Anonymous user going directly to login page
        Given I am on "/login"
        Then I should see "Login!"

    Scenario: User trying to login with not existing username
        Given I am on "/login"
        When I fill in "login_form_username" with "lorem@ipsum.com"
        And I fill in "login_form_password" with "test_password"
        And I press "login_button"
        Then I should see "Username could not be found."