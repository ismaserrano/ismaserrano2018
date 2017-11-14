# ismaserrano.com personal portfolio

Based on Symfony 3 with Kunstmaan Bundles.

> Modified navigation for **AJAX** experience with **jQuery**, **velocity.js**. Request listener to add **Content-Length** header for javascript loading progress and **Twig** conditional `app.request ` layout extend.


### How to install
1. `composer install` Follow the instructions when composer finish the process, creating database, editing DDBB parameters.
	1. `bin/console doctrine:schema:update --force` Creates the database structure.
	2. `bin/console doctrine:migration:migrate` Update current migrations versions.
2. `npm install`
3. `bower install`

Launch server with `bin/console server:run`