Feature: Meetings

  Scenario: I can get meeting status
    Given I create a meeting
    When I fetch meeting details via API
    Then It has "open to registration" status
