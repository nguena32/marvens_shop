<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Encapsulation de la réponse HTTP sortante avec En-têtes de sécurité OWASP systématiques
 */
class Response
{
    private int $statusCode;
    private array $headers;
    private string $content;

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public static function html(string $content, int $statusCode = 200): self
    {
        return new self($content, $statusCode, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    public static function json(array $data, int $statusCode = 200): self
    {
        return new self(
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
            $statusCode,
            ['Content-Type' => 'application/json; charset=UTF-8']
        );
    }

    public static function redirect(string $url, int $statusCode = 302): self
    {
        return new self('', $statusCode, ['Location' => $url]);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        if (!headers_sent()) {
            http_response_code($this->statusCode);

            // En-têtes de sécurité renforcés (OWASP Security Headers)
            $defaultSecurityHeaders = [
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-XSS-Protection' => '1; mode=block',
                'Referrer-Policy' => 'strict-origin-when-cross-origin',
                'X-Permitted-Cross-Domain-Policies' => 'none',
            ];

            // Si HTTPS est actif ou configuré, activer HSTS
            $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                       (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
                       (Config::get('app.session_secure_cookie', false) === true);

            if ($isHttps) {
                $defaultSecurityHeaders['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
            }

            foreach ($defaultSecurityHeaders as $secHeader => $secValue) {
                if (!isset($this->headers[$secHeader])) {
                    header("{$secHeader}: {$secValue}");
                }
            }

            foreach ($this->headers as $name => $value) {
                header("{$name}: {$value}");
            }
        }

        echo $this->content;
    }
}
