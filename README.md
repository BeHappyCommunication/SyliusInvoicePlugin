# sylius-invoice
A Plugin for Sylius to generate invoices

# Installation-procedure
```bash
$ composer require bhc/invoice-plugin
```

## Enable the plugin

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
		new BHC\InvoicePlugin\BHCInvoicePlugin,
	);
	// ...
}
```

```yml
#in app/config/config.yml
imports:
    ...
    - { resource: '@BHCInvoicePlugin/Resources/config/app/config.yml' }
```

```yml
# in routing.yml
...
bhc_invoice_admin:
    resource: "@BHCInvoicePlugin/Resources/config/app/routing_admin.yml"
    prefix: /admin

bhc_invoice_shop:
    resource: "@BHCInvoicePlugin/Resources/config/app/routing_shop.yml"
    prefix: /{_locale}/account
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
...
```

# That's it !
Now, a new button has been added in customer's account for every order marked as completed.
An new block has also been added in BackOffice under the shipment section to see the invoice.

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.
