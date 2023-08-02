# Certification Quiz


### Requirements
 - PHP ^8.1

## Installation
- `composer install`
- `npm install`
- `npm run prod`
- `bin/console doctrine:migrations:migrate`
- `bin/console doctrine:fixtures:load`


## Getting started
In order to use the `symfony` command you need first to install `symfony cli`

`curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash`
`sudo apt install symfony-cli`

Then you will be able to do `symfony serve -d` to run the server as daemon or `symfony serve`

Alternatively you can use: `php -S localhost:8000 -t public/`
## Ideas for a future development

- Web iterface from which a new `yml` files can be uploaded containing information about the categories, questions and answers
- Every new topic can be add as new `bundle` in which all the data for the new topic will added such as `routes`, `controllers`, `templates`
- Docker version of the project to be easier for setup and used

There are endless posibilites how it can be improved...get wild...