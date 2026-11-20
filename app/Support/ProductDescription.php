<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

final class ProductDescription
{
    private HtmlSanitizer $sanitizer;

    public function __construct()
    {
        $config = (new HtmlSanitizerConfig())
            ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
            ->allowRelativeLinks()
            ->withMaxInputLength(200000);

        foreach (['p', 'div', 'span', 'br', 'strong', 'b', 'em', 'i', 'u', 'del', 's', 'h2', 'h3', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code'] as $tag) {
            $config = $config->allowElement($tag, []);
        }
        $config = $config->allowElement('a', ['href', 'title']);
        $this->sanitizer = new HtmlSanitizer($config);
    }

    private function containsHtml(string $value): bool
    {
        return preg_match('/<\/?[a-z][^>]*>/i', $value) === 1;
    }

    public function sanitize(string $value): string
    {
        if (!$this->containsHtml($value)) {
            return trim($value);
        }
        // Keep product headings below the page's main H1.
        $value = preg_replace('/<(\/?)h1(?=[\s>])/i', '<$1h2', $value);
        return trim($this->sanitizer->sanitize($value));
    }

    public function html(string $value): string
    {
        if (!$this->containsHtml($value)) {
            return '<p>'.nl2br(e(trim($value))).'</p>';
        }
        return $this->sanitize($value);
    }

    public function plainText(string $value): string
    {
        if ($this->containsHtml($value)) {
            $value = $this->sanitize($value);
            $value = preg_replace('/<br\s*\/?\s*>|<\/(?:p|div|h2|h3|li|blockquote|pre)>/i', ' ', $value);
            $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        return trim(preg_replace('/[\s\x{00A0}\x{200B}]+/u', ' ', $value));
    }
}
