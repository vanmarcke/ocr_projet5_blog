<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Head site ***************************************** -->
    <title>Frédéric Vanmarcke | Portfolio - Développeur & Intégrateur Web</title>

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="VMKDEV">
    <meta name="apple-mobile-web-app-title" content="VMKDEV">
    <meta name="msapplication-starturl" content="https://vmkdev.com/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="robots" content="index,follow">
    <meta name="description" content="Je m'appelle Frédéric Vanmarcke, je suis Développeur web front / Full-Stack à Rambouillet. 
    Après 18 ans dans la métallurgie, j’effectue une reconversion professionnelle, en intégrant une formation
    de Développeur WEB largement dominée par un public plus jeune.">
    <meta name="author" content="Frédéric Vanmarcke">
    <meta name="keywords" content="Frédéric Vanmarcke, Portfolio, Intégrateur, Informatique, Web, page web, HTML, CSS, 
    développeur IDF,développeur France, Developpeur web, Full-Stack, Jquery, Javascript, PHP, symfony, angular, 
    react native, Wordpress, bootstrap, Photoshop, illustrator, webdesign, ajax, création site web rambouillet île de france, 
    site internet île de france, SEO, Intégration et développement web">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           

    <!-- CSS, frameworks & Responsive ***************************************** -->
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" type="image/png" href="public/favicon.ico">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_menu.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_slider.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_aboutMe.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_parcours.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_expe_compet.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_portFolio.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_loisirsContact.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_networkIcons.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_footer.css">
    <link rel="stylesheet" type="text/css" href="public/css/responsive_max_width_768px.css">
    <link rel="stylesheet" type="text/css" href="public/css/responsive_max_width_480px.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="manifest" href="public/manifest.json" />

    <!-- CSS Transition and Transformation script  -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- Global site tag (gtag.js) - Function for Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B8PVFKPPGT"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-B8PVFKPPGT');
    </script>

    <!-- reCAPTCHA v3 - Load the JavaScript API with my sitekey. -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LeytAEbAAAAAJbWsEdMqp7_npryrc-itzfYYxS9"></script>
    <!-- Call grecaptcha.execute on each send action of the contact form.  -->
    <script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeytAEbAAAAAJbWsEdMqp7_npryrc-itzfYYxS9', {action: 'submit'}).then(function(token) {
            document.getElementById('recaptchaResponse').value = token
        });
    });
    </script>  

</head>

<body id="body">
    <div id="home"></div>
    <main>
        
        <!-- NAV ***************************************** -->
        <header id="header" class="flex sticky-top" style="display: none;">
            <figure id="logo">
                <a href="#home"> <img alt="Logo du Portfolio Frédéric Vanmarcke - Développeur & Intrégateur web" src="public/images/logo_small.png"> </a>
            </figure>
            <div id="hamburger">
                <div id="hamburger-content">
                    <nav id="menu" role="navigation">
                        <ul class="nav-pills" id="pills-tab" role="tablist">
                            <li>
                                <a href="#me">A PROPOS DE MOI</a>
                            </li>
                            <li>
                                <a href="#formation">PARCOURS
                                </a>
                            </li>
                            <li>
                                <a href="#experience">EXPERIENCE</a>
                            </li>
                            <li>
                                <a href="#competence">COMPÉTENCES</a>
                            </li>
                            <li>
                                <a href="#portfolio">PORTFOLIO</a>
                            </li>
                            <li>
                                <a href="#contact">CONTACT</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <button id="hamburger-button">&#9776;</button>
                <div id="hamburger-sidebar">
                    <div id="hamburger-sidebar-header"></div>
                    <div id="hamburger-sidebar-body"></div>
                </div>
                <div id="hamburger-overlay"></div>
            </div>
        </header>
        <!-- NAV END ***************************************** -->

        <!-- SLIDER ***************************************** -->

        <section id="slider">
            <div>
                <img src="public/images/slider.png" alt="Background coucher de soleil">
            </div>
            <div class="background"></div>
            <div class="pres row align-items-center headline">
                <h1>
                    <span class="tagline">Frédéric Vanmarcke</span>
                    <br />
                    <span class="int tagline">Développeur - Intégrateur Web & Web Mobile à Rambouillet</span>
                   
                </h1>
            </div>
            <a id="toDown" title="Go to down" href="#me" class="fa fa-chevron-down punchline">
            </a>
        </section>
        <!-- SLIDER END ***************************************** -->
        
        <?php
        // ABOUT ME *****************************************

         include 'public/view/aboutMe.twig';

        //  TRAINING *****************************************
        
         include 'public/view/training.twig';

        //  EXPERIENCE *****************************************
       
         include 'public/view/experience.twig';

        //  SKILL  *****************************************
    
         include 'public/view/skill.twig';

        //  PORTFOLIO  *****************************************
     
         include 'public/view/portFolio.twig';

        //  HOBBIES  *****************************************
        
         include 'public/view/hobbies.twig';
        ?>
        <!-- CONTACT  ***************************************** -->
       
        <section id="contact">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="titreBorder">Mes réseaux</h1>
                </div>
                <div class="col-lg-12">
                    <ul class="networks">
                        <li>
                            <a href="https://linkedin.com/in/frédéric-vanmarcke/" target="_blank" rel="noopener" class="fa fa-linkedin"></a>
                        </li>

                        <li>
                            <a href="https://github.com/vanmarcke/" target="_blank" rel="noopener" class="fa fa-github"></a>
                        </li>
                        <li>
                            <a href="https://www.pinterest.fr/fvanmarcke72/" target="_blank" rel="noopener" class="fa fa-pinterest"></a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/guedin78/" target="_blank" rel="noopener" class="fa fa-facebook"></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-12">
                <h1 class="titreBorder">Me contacter</h1>
            </div>
            <div class="col-lg-8 mx-auto">

                <form method="POST" action="EmailProcessing.php" id="contactForm">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nom"></label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Vos Nom et Prénom *" >                            
                        </div>
                        <div class="form-group col-md-12">
                            <label for="sujet"></label>
                            <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet *" >
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email"></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Votre E-mail *" >
                        </div>

                        <div class="form-group col-md-12">
                            <label for="message"></label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Votre message *" ></textarea>
                        </div>                         

                    </div>

                    <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
          
                    <input class="btn btn-primary" data-sitekey="6LeytAEbAAAAAJbWsEdMqp7_npryrc-itzfYYxS9" type="submit" name="submit" value="Envoyer" />
                    
                </form>
            </div>
        </section>

        <!-- CONTACT end  ***************************************** -->  


        <!-- FOOTER ***************************************** -->
        <?php

        include 'public/view/footer.twig';

        ?>

        <a id="toTop" title="Go to top" href="#home" class="fa fa-chevron-up"></a>

    </main>

    <!-- Scripts ***************************************** -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="public/js/app.js" async defer></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/cookie-bar/cookiebar-latest.min.js?forceLang=fr&theme=flying&always=1"></script>

</body>

</html>
