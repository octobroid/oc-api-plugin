# API Framework

It's a plugin for OctoberCMS for you that want to create an extensible and easy to use API server.

### Features

- [oAuth 2.0](https://oauth.net/2/) Server ready
- [CORS (Cross-origin Resource Sharing)](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) enabled
- Multiple request and respond formats available (form, json, xml, x-yaml)
- [JSON-API](http://jsonapi.org) compatible using [Fractal](http://fractal.thephpleague.com/)
- [RainLab.User](http://octobercms.com/plugin/rainlab-user) plugin integration

### Usage

This plugin is a base for your application API. You should create your "API" plugin for your application.

**Create your plugin**

```
php artisan plugin:create Foo.Bar
```

In your `Plugin.php` file, we recommend you to put `Octobro.API` as plugin dependency.

```php
class Plugin extends PluginBase
{
	public $require = ['Octobro.API'];
	
```

**Define the REST API routes**

Create `routes.php` using this starter template.

```php
Route::group([
	'prefix' => 'api/v1',
	'namespace' => 'Foo\Bar\Controllers',
	'middleware' => 'cors'
], function() {
	
	//	
	// Your public resources should be here
	//
	
	Route::group(['middleware' => 'oauth'], function() {
	
		//
		// Your protected resources should be here
		//
		
	});
});
```

Don't forget to change the Controllers `namespace` on your plugin.

**Create your app resources**

For example in an e-commerce application, we want to open the products catalog API.

Put the URL to your `routes.php`

```php
Route::get('products', 'Products@index');
Route::get('products/{id}', 'Products@show');
```

Create the `controllers/Products.php` file.

```php
<?php namespace Foo\Bar\Controllers;

use Octobro\API\Classes\ApiController;
use Foo\Bar\Models\Product;
use Foo\Bar\Transformers\ProductTransformer;

class Products extends ApiController
{
    public function index()
    {
        $products = Product::get();

        return $this->respondwithCollection($products, new ProductTransformer);
    }

    public function show($id)
    {
    	$product = Product::find($id);

    	return $this->respondwithItem($product, new ProductTransformer);
    }
}

```

And then create the `transformers/ProductTransformer.php`

```php
<?php namespace Foo\Bar\Transformers;

use Octobro\API\Classes\Transformer;
use Foo\Bar\Models\Product;

class ProductTransformer extends Transformer
{
    public $defaultIncludes = [];

    public $availableIncludes = [];

    public function transform(Product $product)
    {
        return [
            'id'          => (int) $product->id,
            'sku'         => $product->sku,
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => $product->price,
            'sale_price'  => $product->sale_price,
            'created_at'  => date($product->created_at),
        ];
    }
}

```

That's it! You're successfully created the API in easy way! There are ton of features that very usable for your scalable and extensible application.

> *More detailed documentation is coming soon!*


### oAuth 2.0 Authentication

This plugin has a built-in user authentication using password. You can create your own authentication using this plugin also.

To get started, the authentication is by creating an HTTP POST request to `http://yourapp.dev/api/v1/auth/access_token` with these body parameters:

| Param         | Description                                                          | Example                  |
|---------------|----------------------------------------------------------------------|--------------------------|
| client_id     | It's a key for an app. We generate it when you installed this plugin | `818492836130`           |
| client_secret | Key for selected app (make this one secret)                          | `dfxaksfhtokudiaqpieojx` |
| grant_type    | Authentication method. For this plugin only `password` is available  | `password`               |
| username      | Username/email from user                                             | `myusername`             |
| password      | Password from user                                                   | `mypassword`             |

The response will be:

```json
{
  "access_token": "O6qxvTwllfsoeTJ7dbpmaa5Vt7UA9a6GlrwlAgWd",
  "token_type": "Bearer",
  "expires_in": 604800
}
```
Use this access token for your next protected request by put it on header:

```
Authorization: Bearer {YOUR_ACCESS_TOKEN}
```


### Composer Packages Used

- [league/fractal](https://packagist.org/packages/league/fractal)
- [barryvdh/laravel-cors](https://packagist.org/packages/barryvdh/laravel-cors)
- [lucadegasperi/oauth2-server-laravel](https://packagist.org/packages/lucadegasperi/oauth2-server-laravel)

### License

The OctoberCMS platform is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).