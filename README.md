# Sketcher php-sdk
Official SDK for php


### How to use
```php

// Call the main class this this
$Sketcher = new \Sketcher\SDK\Main;

// Define the defaults variables
$Sketcher->SetBaseUri("The API url");
$Sketcher->SetToken("You app token");

// Enjoy!
$Endpoints 		= $Sketcher->Request("GET", "/endpoints");
$SomeRequest 	= $Sketcher->Request("PUT", "/some-request", [
    "hello" => "world!"
]);

```