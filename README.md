FeedbackBundle
==============

FeedbackBundle for Symfony 2

**This module is not yet functionnal**

Based on [bulutyazilim/FeedbackBundle](https://github.com/bulutyazilim/FeedbackBundle) but heavily modified to follow Symfony3 code style and best-practices

##Installation

###Step 1

Require the package
```
composer require "he8us/feedback-bundle"
```


###Step 2

add this those lines to your app/AppKernel.php file

```php
<?php

// app/AppKernel.php

// ...

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            // We depends on this bundle so you need to require it
            new \Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new He8us\FeedbackBundle\He8usFeedbackBundle(),
        );

        // ...
    }

    // ...
}
```

##Step 3

import routing 

```yml
# We depends on this bundle so you need to require it's routes
captcha:
    resource: "@GregwarCaptchaBundle/Resources/config/routing/routing.yml"
    prefix: /

feedback:
    resource: "@He8usFeedbackBundle/Resources/config/routing.yml"
    prefix:   /
```

## Step 4

add configurations to app/config.yml
Do not forget to define your base view

```yml
gregwar_captcha: ~

# Twig Configuration    
twig:
    globals:
        admin_base_view: '::base.html.twig'
```

## Step 5

add CSS and Javascript files to your layout.

```html
    <!-- Add the CSS in the <head></head> of your template
    <link rel="stylesheet" href="{{ asset("bundles/he8usfeedback/css/feedback.css") }}"/>
</head>
```

```html
    <!-- Add the javascript at the very end of your HTML -->
    <script src="{{ asset('bundles/he8usfeedback/js/feedback.js') }}"></script>
    <script src="{{ asset('bundles/he8usfeedback/js/admin.js') }}"></script>
    <script src="{{ asset('bundles/he8usfeedback/js/html2canvas.min.js') }}"></script>

</body>
```

## Step 6

Set some categories 

## step 7

add following before `</body>` in your twig file
```html
{{ feedback_widget()|raw }}
```
