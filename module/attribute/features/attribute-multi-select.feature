Feature: Multi multi select attribute manipulation

  Background:
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"

  Scenario: Create multi select attribute
    And I send a "POST" request to "/api/v1/en/attributes" with body:
      """
      {
          "code": "MULTI_SELECT@@random_code@@",
          "type": "MULTI_SELECT",
          "groups": []
      }
      """
    Then the response status code should be 201
    And store response param "id" as "attribute_id"

  Scenario: Create option for attribute
    And I send a "POST" request to "/api/v1/en/attributes/@attribute_id@/options" with body:
      """
      {
        "code": "OPTION_@@random_code@@",
        "label":  {}
      }
      """
    Then the response status code should be 201
    And store response param "id" as "option_id"

  Scenario: Get created multi select
    And I send a "GET" request to "/api/v1/EN/attributes/@attribute_id@/options/@option_id@"
    Then the response status code should be 200

  Scenario: Update option for attribute
    And I send a "PUT" request to "/api/v1/en/attributes/@attribute_id@/options/@option_id@" with body:
      """
      {
        "code": "OPTION_@@random_code@@",
        "label":  {
          "pl": "Option pl 1",
          "en": "Option en 1"
        }
      }
      """
    Then the response status code should be 201

  Scenario: Get created multi select
    And I send a "GET" request to "/api/v1/EN/attributes/@attribute_id@/options/@option_id@"
    Then the response status code should be 200
    And the JSON node "label.pl" should contain "Option pl 1"
    And the JSON node "label.en" should contain "Option en 1"

  Scenario: Delete multi select attribute
    And I send a "DELETE" request to "/api/v1/EN/attributes/@attribute_id@"
    Then the response status code should be 204