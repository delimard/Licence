# Licence
This thelia 2 module was created to generate product_key serial and expiration date for virtual product.

*The expiration date is set by default to the date of the order invoice +1 year.*
## Installation

**Manually**

Copy the module into <thelia_root>/local/modules/ directory.
Activate it in your thelia administration panel

## Loop
This module provide a new loop: licence

*Example:*
</br>
 {loop type="licence" name="Licence" order_id="$order_id" product_id="$ID"}
</br>
        {$PRODUCT_KEY}</li>
</br>
        {$EXPIRATION_DATE|date_format:"%d/%m/%Y"}
</br>
{/loop}

### Output arguments

|Variable         |Description |
|---              |--- |
|$ID              | the licence id                                                             |                                                                       
|$ORDER_ID        | the order id                                                               |                                                                                      |$CUSTOMER_ID     | the customer id                                                            |
|$PRODUCT_ID      | the product id                                                             |                                                                                  
|$PRODUCT_KEY     | the product key generated                                                  |                                                                          
|$EXPIRATION_DATE | the date of expiration                                                     |          
|$ACTIVE_MACHINE  | free input. Can be set the way you want                                    |

## Hook
A hook is added on the order page. You can have a quick look on the product_key and the expiration_date generated when the order is paid.

## Email
When the order is paid, an email is sent to the customer with the name of the product, the product key and his expiration date.

## Special Thanks
Special thanks to [@Roadster31](https://github.com/roadster31) for his help to understanding Thelia 2 module developpement.

And a thank to the [thelia forum](https://forum.thelia.net).