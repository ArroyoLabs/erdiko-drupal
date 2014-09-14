erdiko-drupal
=============

Erdiko Drupal integration

Run a headless version of drupal in your MVC app!  

Using this package is an easy way to run Drupal in another codebase (framework).  It essentially is a convenient way to bootstrap drupal and give you access to it's API.  Drupal becomes another data source.  Call the drupal model or extend the drupal model and make your own headless Drupal mashup.  Only requests that intiate the drupal model will load up Drupal.  This can be great for performance.

	$drupal = new \erdiko\drupal\Model; // Instantiate Drupal
	$node = $drupal->node_load(1); // Load some drupal content and theme or process it how ever you like

Version (SemVer)
----------------

7.0.5

Installation
------------

* download drupal and put it in your erdiko root as /lib/drupal

* set up vhost for drupal (so you can access the native drupal admin)

* install drupal.  Use the drupal wizzard e.g. local.drupal.erdiko.org/install.php or update settings.php file with your database credentials

* Now that drupal is set up, time to get the erdiko-drupal package.  To do this simply run this on the commandline

:~$

	composer require erdiko/drupal 7.0.*

* an alternative is to add erdiko/drupal to your require list in your project's composer.json file and run, "composer update".

* symlink your files folder.  This will make sure that any files uploaded in drupal will be available in your erdiko site.  Go to the root of your site and run the follow commands (linux & OSX).

:~$

	mkdir -p public/sites/default
	cd public/sites/default
	ln -s ../../../lib/drupal/sites/default/files files

Attach an existing Drupal site to your erdiko app
-------------------------------------------------

copy your drupal code into /lib/drupal or add a symlink from your drupal codebase that links to /lib/drupal.  The instructions are essentially the same as above except that you do not need to go through the drupal install process.

another option is to hack the drupal module itself and point the bootstrap.php to your drupal root.  This is a less desireable approach.  We are considering adding the path to a config file for easy directory swapping.

Run headless drupal with Laravel or Symfony
-------------------------------------------

This erdiko/drupal package not just work with the Erdiko micro framework, it will work with any composer enabled framework, e.g. Laravel, Symfony, etc.  If you are having issues using it with your framework please submit an issue and we'll see if we can help.

Demo
----

The demo below is for the [Erdiko micro framework](http://erdiko.org/) but you can still borrow some code to use in your MVC of choice (e.g. Laravel or Symfony).

To add some sample demos to see erdiko/drupal in action simply add these routes to your app.  Edit /app/config/application/routes.json and enter the routes below.  The demos will show up as yoursite.com/drupal and yoursite.com/user

	"drupal": "\erdiko\drupal\controllers\Example",
	"drupal/:alpha": "\erdiko\drupal\controllers\Example",
	"user": "\erdiko\drupal\controllers\User",
	"user/:alpha": "\erdiko\drupal\controllers\User"

Take a look at the Example Controllers for ideas of how to leverage Drupal in your project.  There are so many to leverage the Drupal CMS in an MVC web app or web service.

FAQ
---

1. Why put the drupal files in /lib instead of /vendor?

	It is because the vendor folder should be for your composer libraries.  Since drupal 7 and below are not composer compatible we thought it best to put it somewhere more isolated.  All erdiko mash up libraries that aren't composer based should go in /lib.

2. I'm using a CDN what do I do?

	It's still a good idea to do the symlink to your files folder from your app, but it's not required.  Make sure files in your native drupal site are being served from the CDN.  When you are theming your content retrieved from drupal check to see if the returned file (image) url is using your CDN.  If not run it through the drupal to get the CDN version of the file.  $drupal->file_create_url($uri)

3. What about Drupal 8?

	When drupal 8 finally gets released we may have to create a new branch of the module that is 8 compatible.  You would install it via, composer require 8.0.*.  Depending on how Drupal 8 matures, you may be able to directly run drupal under any framework without extra glue... only time will tell :-)

4. I found a bug, what do I do?

	Submit an issue, https://github.com/arroyolabs/erdiko-drupal/issues

5. I want to contribute

	Please fork and submit a pull request or drop us a line.


**Thank you for playing with Erdiko**
