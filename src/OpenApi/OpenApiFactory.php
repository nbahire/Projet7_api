<?php
namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(private readonly OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $paths = [
            '/api/products',
            '/api/products/{id}',
            '/api/users',
            '/api/users/{id}'
        ];

        $openApi = $this->decorated->__invoke($context);
        foreach ($paths as $path){
            $pathItem = $openApi->getPaths()->getPath($path);
            $operation = $pathItem->getGet();
            $operation->addResponse(new Model\Response('Unauthorized'), '401');

            if($path === '/api/users'){
                $pathItem = $openApi->getPaths()->getPath($path);
                $operation = $pathItem->getPost();
                $operation->addResponse(new Model\Response('Unauthorized'), '401');
            }
            if($path === '/api/users/{id}'){
                $pathItem = $openApi->getPaths()->getPath($path);
                $operation = $pathItem->getDelete();
                $operation->addResponse(new Model\Response('Unauthorized'), '401');
            }
        }
        $openApi = $openApi->withInfo((new Model\Info(
            'BilMo Api',
            'v3',
            'This is BilMo api Server based on the OpenAPI 3.0 specification. It expose a selection of high-end mobile phones to clients'
        ))->withExtensionProperty('info-key', 'Info value'));
        $openApi = $openApi->withExtensionProperty('key', 'Custom x-key value');
        $openApi = $openApi->withExtensionProperty('x-value', 'Custom x-value value');

        // to define base path URL
        return $openApi->withServers([new Model\Server('')]);
    }
}
