Feature: Export Profile Magento 2 CSV

  Scenario: Get configuration with magento 2 csv
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en/export-profile/magento-2-csv/configuration"
    Then the response status code should be 200

  Scenario: Post Create Export profile to magento 2 csv
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a POST request to "/api/v1/en/export-profile" with body:
      """
        {
          "type": "magento-2-csv",
          "name": "Magento 2 csv",
          "filename": "m2.csv",
          "default_language": "en"
        }
      """
    Then the response status code should be 201
    And store response param "id" as "export-profile"

  Scenario: Post Create Export profile to magento 2 csv no file name
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a POST request to "/api/v1/en/export-profile" with body:
      """
        {
          "type": "magento-2-csv",
          "name": "Magento 2 csv",
          "default_language": "en"
        }
      """
    Then the response status code should be 500

  Scenario: Get export profile
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en/export-profile/@export-profile@"
    Then the response status code should be 200

  Scenario: Update Export Profile
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a POST request to "/api/v1/en/export-profile/@export-profile@" with body:
      """
        {
          "type": "magento-2-csv",
          "name": "Magento 2 csv",
          "default_language": "en",
          "filename": "maaa2.csv"
        }
      """
    Then the response status code should be 204

  Scenario: Delete export profile
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a DELETE request to "/api/v1/en/export-profile/@export-profile@"
    Then the response status code should be 204
