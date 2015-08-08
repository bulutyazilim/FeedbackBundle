FeedbackBundle
==============

FeedbackBundle for Symfony 2


##Installation

###Step 1

add
```
composer require --dev "okulbilisim/feedback-bundle":"dev-master"

```

to `require` block of your composer.json

###Step 2

add this line to your app/AppKernel.php file

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

            new Okulbilisim\FeedbackBundle\OkulbilisimFeedbackBundle(),
        );

        // ...
    }

    // ...
}
```

##Step 3

import routing 

```yml
feedback:
    resource: "@OkulbilisimFeedbackBundle/Resources/config/routing.yml"
    prefix:   /
```

## Step 4

add configurations to app/config.yml

```yml
# Twig Configuration    
twig:
    globals:
        admin_base_view: '::ojs_base.html.twig'
```

## Step 5

add style and css files to your layout.

```yml
- @OkulbilisimFeedbackBundle/Resources/public/js/feedback.js
- @OkulbilisimFeedbackBundle/Resources/public/js/admin.js
- @OkulbilisimFeedbackBundle/Resources/public/js/feedback.css
