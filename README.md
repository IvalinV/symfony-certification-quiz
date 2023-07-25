# Certification Quiz


### Requirements
 - PHP ^8.0

## Installation
`composer install`
`npm install`
`npm run prod`
`bin/console doctrine:migrations:migrate`
`bin/console doctrine:fixtures:load`


## Getting started
`symfony serve -d` to run the server as deamon alternativly you can use `symfony serve`

*** if you run into some problems regarding the memoery limit, be sure to change `memory_limit` for both `CLI` and `fpm` to `-1` ***
## Ideas for a future development

- Web iterface from which a new `yml` files can be uploaded containing information about the categories, questions and answers
- Every new topic can be add as new `bundle` in which all the data for the new topic will added such as `routes`, `controllers`, `templates`

There are endless posibilites how it can be aproved...get wild...