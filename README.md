#ApiClientBundle

Symfony 2 Bundle wrapping [ApnMarketplace/ApiClient](https://github.com/APNMarketplace/ApiClient).

## Installation

1. Add ``apnmarketplace/apiclientbundle`` as a dependency in your project's ``composer.json`` file:

        // composer.json
        {
            "require": {
            // ...
            "apnmarketplace/apiclient": "dev-master",
            "apnmarketplace/apiclientbundle": "dev-master"
            },
        }

2. Add repositories: (These need to be added to the root as composer cannot handle recursive repos. In future these will be available on packagist.)

        // composer.json
        {
            "repositories": [
                // ...
                {
                    "type": "vcs",
                    "url": "git@github.com:APNMarketplace/ApiClient.git"
                },
                {
                    "type": "vcs",
                    "url": "git@github.com:APNMarketplace/ApiClientBundle.git"
                }
            ]
        }

3. Install your dependencies using [composer](http://getcomposer.org):

        php composer.phar update apnmarketplace/apiclientbundle

4. Register the bundle

        // app/AppKernel.php
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new ApnMarketplace\ApiClientBundle\ApnMarketplaceApiClientBundle(),
            );
        }

5. Configure the service:

        # app/config/config.yml
        apn_marketplace_api_client:
            id: client_id
            secret: client_secret
            # any client implementing the interface may be used, default based on Guzzle is supplied
            client: apnmarketplace.guzzle_client
            # prevent curl validating self signed certificates when developing
            guzzle_verify_ssl: true
            # cache responses based on http caching headers
            guzzle_caching: true

## Usage

Use the service where necessary:

    // src/Acme/DefaultBundle/Controller/DefaultController.php
    public function indexAction()
    {
        $app = $this->get('apnmarketplace.api_client');
        $app->get('some.resource');
    }

See  [ApnMarketplace/ApiClient](https://github.com/APNMarketplace/ApiClient) for more information.