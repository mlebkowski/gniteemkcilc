Feature: Meetings

  Scenario: I can get meeting status
    Given I create a meeting
    When I fetch meeting details via API
    Then It has "open to registration" status

  Scenario: The meeting status changes over time
    Given I create a meeting for "+15 minutes"
    And now is "+30 minutes"
    When I fetch meeting details via API
    Then It has "in session" status

