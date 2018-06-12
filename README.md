# sylius-invoice
A Plugin for Sylius to generate invoices

# Installation-procedure
```bash
$ composer require behappy/invoice-plugin
```

## Enable the plugin
Since this plugin has dependencies, you must also enable those.

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
        new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
		
        new \BeHappy\SyliusCompanyDataPlugin\BeHappySyliusCompanyDataPlugin(),
        new \BeHappy\SyliusInvoicePlugin\BeHappySyliusInvoicePlugin(),
    );
    // ...
}
```

```yaml
#in app/config/config.yml
imports:
    ...
    - { resource: "@BeHappySyliusCompanyDataPlugin/Resources/config/config.yml" }
    - { resource: "@BeHappySyliusInvoicePlugin/Resources/config/config.yml" }
    ...
```

```yaml
# in routing.yml
...
behappy_company_data_plugin:
    resource: '@BeHappySyliusCompanyDataPlugin/Resources/config/routing.yml'

behappy_invoice_plugin.admin:
    resource: '@BeHappySyliusInvoicePlugin/Resources/config/routes/admin.yml'
    prefix: /admin

behappy_invoice_plugin.shop:
    resource: '@BeHappySyliusInvoicePlugin/Resources/config/routes/shop.yml'
    prefix: /{_locale}/account
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
...
```

## Generate database
Simply launch

```bash
php bin/console doctrine:schema:update --dump-sql --force
``` 

You might have tables referring to BeHappySyliusCompanyDataPlugin if you did not enabled it before requiring this plugin

## Optional : generate invoices

In order to have invoices for previously placed orders, you can run this command :

```bash
php bin/console behappy:invoices:generate
``` 

This command will generate invoices for all orders in state FULFILLED with no invoices attached

# That's it !
From now on, each and every time an order is fulfilled, the event listener will create a new invoice and copy (if needed)
company data information into a separate table to make them static.

A new block is also displayed in admin under the shipment section of orders that have an invoice linked.

In the account section for your customers, a link is also displayed for every invoice linked to their orders.

# Configuration
By default, invoices will be generated with a 12 digits number filled with 0 (str_pad(12, '0', STR_PAD_LEFT))

You can redefine this length definition by overriding this :

```yaml
# in app/config.yml
parameters:
    ...
    behappy_invoice_plugin.invoice_number.length: 14
    ...
```

Now every invoice will be 14 digits long.

In a near future, this plugin will use a number generator that you'll be free to override according to your needs.

# Thanks
This plugin is partially inspired by BitBagCommerce/SyliusInvoicingPlugin (https://github.com/BitBagCommerce/SyliusInvoicingPlugin).

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.

# Other
You can also check our other packages (including Sylius plugins) at https://github.com/BeHappyCommunication
