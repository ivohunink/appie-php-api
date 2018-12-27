# appie-php-api
The Appie-PHP-API is a PHP class enabling you to access the unofficial Appie (Albert Heijn) REST API. It can be easily used in combination with any PHP project, or in combination with your Google Assistant / Google Home device.

# Usage for your PHP project
```
$appie = new Appie();
$appie->login("email@email.com","password");
$appie->addProduct("Icecream");
```

# Usage for your Google Assistant / Google Home device
You can easily use this to add products to your Appie shopping list using your Google Assistant / Google Home device. Depending on your setup, it takes approx. 5 minutes to set this up.

1. First upload Appie-PHP-API to your own PHP server.
2. Go to IFTTT.com and create an account if you don't have one already.
3. Go to Applets, and click "New Applet".
4. Click "This" and search for the "Google Assistant" service. Select it.
5. Choose the "Say a phrase with a text ingredient" trigger.
6. For "What do you want to say?" use "Add $ to list".
7. For "What do you want the Assistant to say in response?" use "Added $".
8. Click "Create Trigger".
9. Click "That" and search for the "Webhook" service. Select it.
10. Click "Make a web request".
11. For "URL" use "http://your-server/appie-php-api/example.php?username=your-email-address@mail.com&password=your-password&product=$". Please make sure you replace your-server with your server details, your-email-address@mail.com with your Appie email address, and your-password with your Appie password.
12. Click "Create action".
13. Now you can use your Google Assistant to easily add products to Appie's shopping list. Say "Ok, Google. Add apples to list." to test it.

# Credits
This Appie-PHP-API was inspired by Sander van der Graaf's Appie Python library (see https://github.com/svdgraaf).
