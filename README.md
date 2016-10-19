FeedbackBundle
==============

FeedbackBundle for Symfony 2

![image](https://cloud.githubusercontent.com/assets/182906/11544971/61d93210-994d-11e5-826a-aa1f1301f8a9.png)


##Installation

###Step 1

add
```
composer require --dev "he8us/feedback-bundle":"dev-master"

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
feedback:
    resource: "@He8usFeedbackBundle/Resources/config/routing.yml"
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
- @He8usFeedbackBundle/Resources/public/js/feedback.js
- @He8usFeedbackBundle/Resources/public/js/admin.js
- @He8usFeedbackBundle/Resources/public/css/feedback.css
```

## Step 6

add parameters.yml following lines
```yml
feedback_categories:
        -
            id: 1
            name: "General"
        -
            id: 2
            name: "Bug Report"
        -
            id: 3
            name: "Idea"
```

## step 7

add following before `</body>` in your twig file
```
{{ feedback_widget()|raw }}
```
