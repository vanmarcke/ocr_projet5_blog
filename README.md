# Project 5 OpenClassrooms - Create your first blog in PHP

## Application Developer Path - PHP / Symfony

Creation of a Blog via an object-oriented MVC architecture.

## Code Quality

**Codacy:**

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/cb28696844634f7cb350a125523dc178)](https://www.codacy.com/gh/vanmarcke/ocr_projet5_blog/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=vanmarcke/ocr_projet5_blog&amp;utm_campaign=Badge_Grade)

**SymfonyInsight:**

[![SymfonyInsight](https://insight.symfony.com/projects/b3a17fcb-b2ec-4c03-aa3a-819a029f81c1/big.svg)](https://insight.symfony.com/projects/b3a17fcb-b2ec-4c03-aa3a-819a029f81c1)

## Project description

Features available according to the different statuses:

**Visitor:**

* Visit the home page and open the various links available.
* Access to CV.
* Browse the list of blogs and its comments.
* Send a message to the blog creator.

**User:**

* Prerequisite: to have registered via the registration form and to be accepted by the administrator.
* Access to the same functionalities as the visitor.
* Addition of comments (subject to validation by the administrator).

**Administrator:**

* Prerequisite: have administrator status.
* Access to the same functionalities as the visitor.
* Add / remove / edit blog post.
* Addition / validation / deletion of comments.

## Information

Blog Theme: Clean Blog Bootstrap

Theme for administrator: SB Admin 2 Bootstrap

PHP Version: 7.4.3

## Libraries used

* twig
* ckeditor
* symfony/var-dumper

## Installation

## Prerequisites

Php, Composer as well as a Database Management System (DBMS) type 'xampp' must be installed on your machine in order to be able to launch the blog.
A Google account for the configuration of reCAPTCHA V3

**Step 1:** Clone the repository on your machine in a folder in your DBMS

    Example with xampp: $ C:\xampp\htdocs\Blog

**Step 2:** In a powershell type terminal run the command "composer install" at the root of the project in order to install all the libraries.

    Example: $ C:\xampp\htdocs\Blog> composer install

**Step 3:** Import the app/project5_blog.sql file into your DBMS in order to create the database.

**Step 4:** Check and / or modify if necessary the app/config.xml file with the access to your database.

**Step 5:** Follow the steps on 'https://www.google.com/recaptcha/admin/create' in order to obtain the 'reCAPTCHA_site_key' for the configuration of reCAPTCHA V3, documentation 'https://developers.google.com/recaptcha/docs/v3'

Rename the controller/EmailProcessingCopy.php file to EmailProcessing.php

Update line 10 with your obtained secret key.

```php
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=votre code secret ici&response={$_POST['recaptcha-response']}";
```

Example:

```php
    $url = "https://www.google.com/recaptcha/api/siteverify?6LeytEeDh6NSmX14_n6JR6&response={$_POST['recaptcha-response']}";
```

In this same file modify line 54 with your email.

Example:

```php
    $email = 'admin@vmkdev.com';
```

In the src/view/contact.twig file

Modify line 55 with your data-sitekey (public key)

Example :

```html
    <input class="btn btn-primary" data-sitekey="6LeytAEbJbWsEdMqp7_npc-itzxS9" type="submit" name="submit" value="Envoyer"/>
```

In the src/view/head.twig file

Modify lines 57 and 61 with your data-sitekey (public key)

Example :

```javascript
    <script src="https://www.google.com/recaptcha/api.js?render=6LeytAEbJbWsEdMqp7_npc-itzxS9"></script>
    <!-- Call grecaptcha.execute on each send action of the contact form.  -->
    <script>
        grecaptcha.ready(function () {
    grecaptcha.execute('6LeytAEbJbWsEdMqp7_npc-itzxS9', {action: 'submit'}).then(function (token) {
    document.getElementById('recaptchaResponse').value = token
    });
    });
    </script>
```

In this same file, if you wish to follow your site with Google Analytics, replace the block script of lines 46 to 54 with your own Global site tag (gtag.js) created with your Google Analytics account.

Otherwise, remove or comment out those same lines.

Currently, the entire PortFolio part is hard-coded in the branch files (see future developments below). If you want to recover the site for your personal use, you will have to modify all the branch files corresponding to the PortFolio with your own information.

**Step 6:** The blog is now functional, you can use visitor and administrator access with the identifiers below.

**User:**

* Email: titi@free.fr
* Password: 123456789

**Administrator:**

* Email: Admin@vmkdev.com
* Password: 123456789

## Future developments

* Create a profile page so that each user can modify their profile information (passwords, nickname, email address, etc.) and receive notifications from the administrator in the event that a comment is refused.

* Create all the controllers, entities and models concerning the PortFolio so that it can be managed directly from the administrator Dashboard.

## Author

**Frédéric Vanmarcke** - Student Openclassrooms school path PHP / Symfony application developer
