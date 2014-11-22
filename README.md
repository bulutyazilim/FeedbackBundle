FeedbackBundle
==============

FeedbackBundle for Symfony 2


##Installation

###Step 1

add
```
"okulbilisim/feedback-bundle":"dev-master"
```

to `require` block of your composer.json

###Step 2

```bash
composer update
```

###Step 3

add this line to your app/AppKernel.php file

```
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

##Step 4

import routing 

```
feedback:
    resource: "@OkulbilisimFeedbackBundle/Resources/config/routing.yml"
    prefix:   /
```

