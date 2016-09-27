Airport Challenge in PHP using tdd

This is a solution to the Aiport Kata.

### Aims
- To learn PHP language
- To produce test driven software using object oriented design
- To implement more features of testing framework unittest
  - mocking
  - stubbing
  - use of different matchers
  - spies
  - feature testing
- Implement different object oriented design principles
  - DRY
  - encapsulation
  - SRP
  - Dependency injection
- Implement refactoring skills
  - Extracting numbers to constants
  - Extracting methods and classes
- Implement different language features of php
  - classes, constructors
  - exceptions
  - randomness

### To run tests

Install composer follow the instructions here https://www.abeautifulsite.net/installing-composer-on-os-x

to setup ```composer install```

to run tests ```./vendor/bin/phpunit --testdox```

### User Stories being met
```
US1

As an air traffic controller
So I can get passengers to a destination
I want to instruct a plane to land at an airport and confirm that it has landed

US2

As an air traffic controller
So I can get passengers on the way to their destination
I want to instruct a plane to take off from an airport and confirm that it is no longer in the airport

US3

As an air traffic controller
To ensure safety
I want to prevent takeoff when weather is stormy

US4

As an air traffic controller
To ensure safety
I want to prevent landing when weather is stormy

US5

As an air traffic controller
To ensure safety
I want to prevent landing when the airport is full

US6

As the system designer
So that the software can be used for many different airports
I would like a default airport capacity that can be overridden as appropriate

US7

As an air traffic controller
To avoid errors and sabotaged planes
I want to prevent landing when plane is at airport

US8

As an air traffic controller
To avoid errors and sabotaged planes
I want to prevent take off when plane is not at airport

```
