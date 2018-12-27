# appie-php-api
Appie-PHP-API is a PHP class enabling you to access the unofficial Appie (Albert Heijn) REST API.

# Installation
Include Appie.class.php into your PHP project.

# Usage
```
$appie = new Appie();
$appie->login("email@email.com","password");
$appie->addProduct("Icecream");
```

# Credits
This Appie-PHP-API was inspired by Sander van der Graaf's Appie Python library (see https://github.com/svdgraaf).
