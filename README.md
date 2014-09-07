erdiko-drupal
=============

Erdiko Drupal integration

Version (SemVer)
----------------

7.0.2

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

FAQ
---

1. Why put the drupal files in /lib instead of /vendor?

	It is because the vendor folder should be for your composer libraries.  Since drupal 7 and below are not composer compatible we thought it best to put it somewhere more isolated.  All erdiko mash up libraries that aren't composer based should go in /lib.

**Thank you for playing with Erdiko**
