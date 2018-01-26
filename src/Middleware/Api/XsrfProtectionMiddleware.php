<?php
/**
 * kiwi-suite/admin (https://github.com/kiwi-suite/admin)
 *
 * @package kiwi-suite/admin
 * @see https://github.com/kiwi-suite/admin
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace KiwiSuite\Admin\Middleware\Api;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use KiwiSuite\Admin\Entity\SessionData;
use KiwiSuite\Admin\Response\ApiErrorResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class XsrfProtectionMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (\in_array($request->getMethod(), ['HEAD', 'OPTIONS', 'GET'])) {
            return $handler->handle($request);
        }

        if (empty($request->getCookieParams()['XSRF-TOKEN'])) {
            return $this->createInvalidXsrfTokenResponse();
        }

        if (!$request->hasHeader('X-XSRF-TOKEN')) {
            return $this->createInvalidXsrfTokenResponse();
        }

        $xsrfToken = \implode("", $request->getHeader("X-XSRF-TOKEN"));

        if ($request->getCookieParams()['XSRF-TOKEN'] !== $xsrfToken) {
            return $this->createInvalidXsrfTokenResponse();
        }

        $sessionData = $request->getAttribute(SessionData::class);
        if (!($sessionData instanceof SessionData)) {
            return $this->createInvalidXsrfTokenResponse();
        }

        if ($sessionData->getXsrfToken() !== $xsrfToken) {
            return $this->createInvalidXsrfTokenResponse();
        }

        return $handler->handle($request);
    }

    private function createInvalidXsrfTokenResponse(): ApiErrorResponse
    {
        return new ApiErrorResponse("xsrf-token.invalid", [], 406);
    }
}
