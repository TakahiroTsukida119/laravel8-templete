<?php
declare(strict_types=1);

namespace App\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

/**
 * Class BearerTokenSecurityScheme
 * @package App\OpenApi\SecuritySchemes
 */
class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    /**
     * @return SecurityScheme
     */
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerToken')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer')
            ->bearerFormat('JWT');
    }
}
