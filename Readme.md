# Licence
 
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

## Hook
A hook is added on the order page. You can have a quick look on the product_key and the expiration_date generated when the order is paid.

## Email
When the order is paid, an email is sent to the customer with the name of the product, the product key and his expiration date.