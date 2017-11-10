# sylius-invoice
A Plugin for Sylius to generate invoices

# Installation-procedure
```bash
$ composer require behappy/invoice-plugin
```

## Enable the plugin

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
		new Behappy\InvoicePlugin\BehappyInvoicePlugin,
	);
	// ...
}
```

```yml
#in app/config/config.yml
imports:
    ...
    - { resource: '@BehappyInvoicePlugin/Resources/config/app/config.yml' }
...

twig:
    paths:
        '%kernel.project_dir%/vendor/behappy/invoice-plugin/src/Resources/views': BehappyInvoice
```

```yml
# in routing.yml
...
behappy_invoice_admin:
    resource: "@BehappyInvoicePlugin/Resources/config/app/routing_admin.yml"
    prefix: /admin

behappy_invoice_shop:
    resource: "@BehappyInvoicePlugin/Resources/config/app/routing_shop.yml"
    prefix: /{_locale}/account
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
...
```


# That's it !
Now, a new button has been added in customer's account for every order marked as completed (STATE_FULFILLED).
An new block has also been added in BackOffice under the shipment section to see the invoice.

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.
