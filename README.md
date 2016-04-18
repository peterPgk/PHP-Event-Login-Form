# Login form with observer pattern implementation

======

This form is only for exercise purpose.

======

This is an attempt to use some of the design patterns, namely Observer for login process.
Here we treat basic login processes like 'register', 'login', 'logout', etc, like events,  
which gives us ability to attach and notify other events (observers) to them.

Even more, we can choose to notify given observer depending on how main event is finished.
Encountered as a result from an job interview question.

## Getting started

Must be fulfilled following steps, before starting:

  1. Run .sql file to create database structure;
  2. Run  ``` composer-install ``` from root folder to install required dependences.
  3. Populate  ``` options.php ``` with database and mail credentials.

### TODO

1. Some .css
2. Pre- and after- filters.
3. Implement middleware-like services for authentication.

