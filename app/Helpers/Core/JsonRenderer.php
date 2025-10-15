<?php

declare(strict_types=1);

namespace App\Helpers\Core;

use Psr\Http\Message\ResponseInterface;

/**
 * JSON response renderer utility.
 *
 * Provides functionality to render JSON responses with proper headers
 * and encoding for PSR-7 HTTP responses.
 */
final class JsonRenderer
{
    /**
     * Render JSON response with proper headers.
     *
     * Takes a PSR-7 response object and data, encodes the data as JSON,
     * sets the appropriate Content-Type header, and writes the JSON to the response body.
     *
     * @param ResponseInterface $response The PSR-7 response object to modify
     * @param mixed $data Optional data to encode as JSON
     * @return ResponseInterface The modified response with JSON content and headers
     */
    public function json(
        ResponseInterface $response,
        mixed $data = null,
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(
            (string)json_encode(
                $data,
                JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR
            )
        );

        return $response;
    }
}
