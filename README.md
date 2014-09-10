erdiko-drupal
=============

Erdiko Drupal integration

Version (SemVer)
----------------

7.0.3

Installation
------------

* download drupal and put it in your erdiko root as /lib/drupal

* set up vhost for drupal (so you can access the native drupal admin)

* install drupal.  Use the drupal wizzard e.g. local.drupal.erdiko.org/install.php or update settings.php file with your database credentials

* Now that drupal is set up, time to get the erdiko-drupal package.  To do this simply run this on the commandline

	composer require erdiko/drupal 7.0.*

an alternative is to add drupal to your require list in your composer.json file and run, "composer update".

* symlink your files folder.  This will make sure that any files uploaded in drupal will be available in your erdiko site.  Go to the root of your site and run the follow commands (linux & OSX).

	mkdir -p public/sites/default
	cd public/sites/default
	ln -s ../../../lib/drupal/sites/default/files files

Attach an existing Drupal site to your erdiko app
-------------------------------------------------

copy your drupal code into /lib/drupal or add a symlink from your drupal codebase that links to /lib/drupal

another option is to hack the drupal module itself and point the bootstrap.php to your drupal root.  This is a less desireable approach.  We are considering adding the path to a config file for easy directory swapping.

Run headless drupal with Laravel or Symfony
-------------------------------------------

This erdiko/drupal package not just work with the Erdiko micro framework, it will work with any composer enabled framework, e.g. Laravel, Symfony, etc.  If you are having issues using it with your framework please submit an issue and we'll see if we can help.

Demo
----

To add some sample demos to see erdiko/drupal in action simply add these routes to your app.  Edit /app/config/application/routes.json and enter the routes below.  The demos will show up as yoursite.com/drupal and yoursite.com/user

	"drupal": "\erdiko\drupal\controllers\Example",
	"drupal/:alpha": "\erdiko\drupal\controllers\Example",
	"user": "\erdiko\drupal\controllers\User",
	"user/:alpha": "\erdiko\drupal\controllers\User"

FAQ
---

1. Why put the drupal files in /lib instead of /vendor?

	It is because the vendor folder should be for your composer libraries.  Since drupal 7 and below are not composer compatible we thought it best to put it somewhere more isolated.  All erdiko mash up libraries that aren't composer based should go in /lib.

2. What about Drupal 8?

	When drupal 8 finally gets released we may have to create a new branch of the module that is 8 compatible.  You would install it via, composer require 8.0.*.  Depending on how Drupal 8 matures, you may be able to directly run drupal under any framework without extra glue... only time will tell :-)

3. I found a bug, what do I do?

	Submit an issue, https://github.com/arroyolabs/erdiko-drupal/issues

4. I want to contribute

	Please fork and submit a pull request or drop us a line.


**Thank you for playing with Erdiko**
