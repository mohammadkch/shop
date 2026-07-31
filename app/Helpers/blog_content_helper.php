<?php

function sanitizeBlogHtml(?string $html): string
{
    $html = trim((string) $html);
    if ($html === '') {
        return '';
    }

    $html = strip_tags($html, '<p><br><h2><h3><h4><strong><b><em><i><u><s><blockquote><ol><ul><li><a><span>');
    $html = preg_replace('/\son\w+\s*=\s*(["\']).*?\1/iu', '', $html);
    $html = preg_replace('/\sstyle\s*=\s*(["\']).*?\1/iu', '', $html);
    $html = preg_replace_callback('/<a\b([^>]*)>/iu', static function ($match) {
        $href = '';
        if (preg_match('/href\s*=\s*(["\'])(.*?)\1/iu', $match[1], $hrefMatch)) {
            $candidate = trim(html_entity_decode($hrefMatch[2], ENT_QUOTES, 'UTF-8'));
            if (preg_match('#^(https?://|mailto:|tel:|/)#iu', $candidate)) {
                $href = ' href="' . esc($candidate, 'attr') . '"';
            }
        }
        return '<a' . $href . ' target="_blank" rel="noopener noreferrer">';
    }, $html);
    $html = preg_replace_callback('/<span\b([^>]*)>/iu', static function ($match) {
        if (preg_match('/class\s*=\s*(["\'])(ql-(?:align-(?:center|right|justify)|direction-rtl))\1/iu', $match[1], $class)) {
            return '<span class="' . esc($class[2], 'attr') . '">';
        }
        return '<span>';
    }, $html);
    $html = preg_replace_callback('/<(p|h2|h3|h4|strong|b|em|i|u|s|blockquote|ol|ul|li)\b([^>]*)>/iu', static function ($match) {
        $tag = strtolower($match[1]);
        if (preg_match('/class\s*=\s*(["\'])(ql-(?:align-(?:center|right|justify)|direction-rtl))\1/iu', $match[2], $class)) {
            return '<' . $tag . ' class="' . esc($class[2], 'attr') . '">';
        }
        return '<' . $tag . '>';
    }, $html);

    return $html;
}
