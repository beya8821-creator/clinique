<?php

declare(strict_types=1);

namespace App\Core;

use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;
use Throwable;

final class TemplateRenderer
{
    private string $pageDir;

    public function __construct()
    {
        $this->pageDir = dirname(__DIR__) . '/Views/pages';
    }

    public function render(string $slug): string
    {
        $phpTemplate = $this->pageDir . '/' . $slug . '.php';
        $htmlTemplate = $this->pageDir . '/' . $slug . '.html';

        if (is_file($phpTemplate)) {
            ob_start();
            include $phpTemplate;
            $html = (string) ob_get_clean();
        } elseif (is_file($htmlTemplate)) {
            $html = (string) file_get_contents($htmlTemplate);
        } else {
            http_response_code(404);
            $html = (string) file_get_contents($this->pageDir . '/404.php');
        }

        $stored = $this->storedHtml($slug);
        if ($stored !== null) {
            $html = $stored;
        }

        return $this->makeDynamic($this->applyCmsContent($html, $slug), $slug);
    }

    private function storedHtml(string $slug): ?string
    {
        try {
            $stmt = Database::pdo()->prepare('SELECT html_content FROM pages WHERE slug = ? AND is_active = 1 LIMIT 1');
            $stmt->execute([$slug]);
            $html = $stmt->fetchColumn();
            return is_string($html) && $html !== '' ? $html : null;
        } catch (Throwable) {
            return null;
        }
    }

    private function makeDynamic(string $html, string $slug): string
    {
        $settings = $this->settings();
        $title = $this->seo($slug, 'meta_title') ?? $settings['meta_title'] ?? null;
        $description = $this->seo($slug, 'meta_description') ?? $settings['meta_description'] ?? null;
        $keywords = $this->seo($slug, 'keywords') ?? $settings['meta_keywords'] ?? null;

        if ($title) {
            $html = preg_replace('/<title>.*?<\/title>/is', '<title>' . Security::e($title) . '</title>', $html, 1) ?? $html;
        }
        if ($description !== null) {
            $html = preg_replace('/<meta name="description" content=".*?">/is', '<meta name="description" content="' . Security::e($description) . '">', $html, 1) ?? $html;
        }
        if ($keywords !== null) {
            $html = preg_replace('/<meta name="keywords" content=".*?">/is', '<meta name="keywords" content="' . Security::e($keywords) . '">', $html, 1) ?? $html;
        }

        $html = str_replace('<form action="forms/contact.php" method="post" class="php-email-form">', '<form action="forms/contact.php" method="post" class="php-email-form">' . Security::csrfField(), $html);
        $html = str_replace('<form action="forms/appointment.php" method="post" class="php-email-form">', '<form action="forms/appointment.php" method="post" class="php-email-form">' . Security::csrfField(), $html);

        return $html;
    }

    private function applyCmsContent(string $html, string $slug): string
    {
        $html = match ($slug) {
            'index' => $this->applyHomeContent($html),
            'about' => $this->applyAboutContent($html),
            'services' => $this->applyServicesContent($html),
            'contact' => $this->applyContactContent($html),
            default => $html,
        };

        return $this->applyGlobalContactContent($html);
    }

    private function applyHomeContent(string $html): string
    {
        $hero = CmsContentRepository::section('home', 'hero');
        if ($hero) {
            $html = $this->replaceMalformedHeroHeading($html, $hero['title'] ?? '');
            $html = $this->replaceFirstParagraphByClass($html, 'hero-description', $hero['body'] ?? '');
            $html = $this->replaceFirstLinkText($html, 'hero-actions', 1, $hero['button_text'] ?? '', $hero['button_url'] ?? '');
            $html = $this->replaceFirstImage($html, 'hero-visual', $hero['image_path'] ?? '');
        }
        $html = $this->replaceHeroImageWithSlider($html);

        $about = CmsContentRepository::section('home', 'about');
        if ($about) {
            $html = $this->replaceFirstHeading($html, 'about-content', $about['title'] ?? '', 'h2');
            $html = $this->replaceFirstParagraphByClass($html, 'lead-text', $about['subtitle'] ?? '');
            $html = $this->replaceNthParagraphInBlock($html, 'about-content', 2, $about['body'] ?? '');
            $html = $this->replaceFirstLinkText($html, 'cta-section', 1, $about['button_text'] ?? '', $about['button_url'] ?? '');
            $html = $this->replaceFirstImage($html, 'about-visual', $about['image_path'] ?? '');
        }

        $cta = CmsContentRepository::section('home', 'cta');
        if ($cta) {
            $html = $this->replaceFirstHeading($html, 'content-wrapper', $cta['title'] ?? '');
            $html = $this->replaceNthParagraphInBlock($html, 'content-wrapper', 1, $cta['body'] ?? '');
            $html = $this->replaceFirstLinkText($html, 'cta-wrapper', 1, $cta['button_text'] ?? '', $cta['button_url'] ?? '');
            $html = $this->replaceFirstImage($html, 'image-container', $cta['image_path'] ?? '');
        }

        return $html;
    }

    private function applyAboutContent(string $html): string
    {
        $intro = CmsContentRepository::section('about', 'intro');
        if ($intro) {
            $html = $this->replaceFirstHeading($html, 'about-content', $intro['title'] ?? '', 'h2');
            $html = $this->replaceFirstParagraphByClass($html, 'lead', $intro['subtitle'] ?? '');
            $html = $this->replaceNthParagraphInBlock($html, 'about-content', 2, $intro['body'] ?? '');
            $html = $this->replaceFirstImage($html, 'image-wrapper', $intro['image_path'] ?? '');
        }

        $values = CmsContentRepository::section('about', 'values');
        if ($values) {
            $html = $this->replaceFirstHeading($html, 'values-section', $values['title'] ?? '', 'h3');
            $html = $this->replaceFirstParagraphByClass($html, 'section-description', $values['body'] ?? '');
        }

        return $html;
    }

    private function applyServicesContent(string $html): string
    {
        $services = CmsContentRepository::services();
        if ($services === []) {
            return $html;
        }

        $cards = '';
        foreach ($services as $index => $service) {
            $delay = 200 + ($index * 50);
            $features = $this->renderServiceFeatures((string) ($service['features_text'] ?? ''));
            $cards .= '<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="' . $delay . '">
            <div class="service-item">
              <div class="service-image">
                <img src="' . Security::e((string) $service['image_path']) . '" alt="' . Security::e((string) $service['title']) . '" class="img-fluid">
                <div class="service-overlay">
                  <i class="' . Security::e((string) $service['icon_class']) . '"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>' . Security::e((string) $service['title']) . '</h3>
                <p>' . Security::e((string) $service['description']) . '</p>
                <div class="service-features">' . $features . '</div>
                <a href="' . Security::e((string) $service['button_url']) . '" class="service-btn">
                  <span>' . Security::e((string) $service['button_text']) . '</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>';
        }

        return preg_replace('/<div class="row gy-4">.*?<\/div>\s*<\/div>\s*<\/section>/is', '<div class="row gy-4">' . "\n\n          " . $cards . "\n\n        </div>\n\n      </div>\n\n    </section>", $html, 1) ?? $html;
    }

    private function applyContactContent(string $html): string
    {
        $contact = CmsContentRepository::contact();

        $html = $this->replaceContactInfoItem($html, 1, $contact['address_title'], [$contact['address']]);
        $html = $this->replaceContactInfoItem($html, 2, $contact['email_title'], [$contact['email_primary'], $contact['email_secondary']]);
        $html = $this->replaceContactInfoItem($html, 3, $contact['hours_title'], [$contact['hours_primary'], $contact['hours_secondary']]);
        $html = $this->replaceFirstHeading($html, 'contact-form-card', $contact['form_title'], 'h2');
        $html = $this->replaceFirstParagraphByClass($html, 'mb-4', $contact['form_intro']);
        $html = preg_replace('/<iframe\s+src=".*?"/is', '<iframe src="' . Security::e($contact['map_embed_url']) . '"', $html, 1) ?? $html;

        return $html;
    }

    private function applyGlobalContactContent(string $html): string
    {
        $contact = CmsContentRepository::contact();
        $phone = trim((string) ($contact['phone'] ?? ''));
        if ($phone === '') {
            return $html;
        }

        $phoneEscaped = Security::e($phone);
        $tel = preg_replace('/[^\d+]/', '', $phone) ?: $phone;
        $html = preg_replace('/href="tel:[^"]*"/i', 'href="tel:' . Security::e($tel) . '"', $html) ?? $html;
        $html = preg_replace('/\+243\s?970\s?22\s?0803|\+243\s?970\s?220\s?803/i', $phoneEscaped, $html) ?? $html;

        return $html;
    }

    private function renderServiceFeatures(string $featuresText): string
    {
        $features = array_filter(array_map('trim', preg_split('/\R|\\\\n/', $featuresText) ?: []));
        $html = '';
        foreach ($features as $feature) {
            $html .= '<span class="feature-item"><i class="fas fa-check"></i> ' . Security::e($feature) . '</span>';
        }

        return $html;
    }

    private function replaceFirstHeading(string $html, string $blockClass, string $value, string $tag = 'h1'): string
    {
        if ($value === '') {
            return $html;
        }

        return preg_replace('/(<div class="' . preg_quote($blockClass, '/') . '".*?>.*?<' . $tag . '[^>]*>).*?(<\/' . $tag . '>)/is', '$1' . Security::e($value) . '$2', $html, 1) ?? $html;
    }

    private function replaceFirstParagraphByClass(string $html, string $class, string $value): string
    {
        if ($value === '') {
            return $html;
        }

        return preg_replace('/(<p class="' . preg_quote($class, '/') . '"[^>]*>).*?(<\/p>)/is', '$1' . Security::e($value) . '$2', $html, 1) ?? $html;
    }

    private function replaceNthParagraphInBlock(string $html, string $blockClass, int $position, string $value): string
    {
        if ($value === '') {
            return $html;
        }

        $blockOffset = $this->findClassOffset($html, $blockClass);
        if ($blockOffset === null) {
            return $html;
        }

        if (!preg_match_all('/<p\b[^>]*>.*?<\/p>/is', $html, $matches, PREG_OFFSET_CAPTURE, $blockOffset)) {
            return $html;
        }

        $target = $matches[0][$position - 1] ?? null;
        if (!$target) {
            return $html;
        }

        $replacement = preg_replace('/(<p\b[^>]*>).*?(<\/p>)/is', '$1' . Security::e($value) . '$2', $target[0], 1) ?? $target[0];

        return substr_replace($html, $replacement, (int) $target[1], strlen($target[0]));
    }

    private function replaceFirstLinkText(string $html, string $blockClass, int $position, string $text, string $url): string
    {
        if ($text === '' && $url === '') {
            return $html;
        }

        $blockOffset = $this->findClassOffset($html, $blockClass);
        if ($blockOffset === null) {
            return $html;
        }

        if (!preg_match_all('/<a\s+href="(.*?)"([^>]*)>.*?<\/a>/is', $html, $matches, PREG_OFFSET_CAPTURE, $blockOffset)) {
            return $html;
        }

        $target = $matches[0][$position - 1] ?? null;
        if (!$target) {
            return $html;
        }

        $replacement = preg_replace_callback('/<a\s+href="(.*?)"([^>]*)>(.*?)<\/a>/is', static function (array $matches) use ($text, $url): string {
            $href = $url !== '' ? Security::e($url) : $matches[1];
            $label = $text !== '' ? Security::e($text) : $matches[3];

            return '<a href="' . $href . '"' . $matches[2] . '>' . $label . '</a>';
        }, $target[0], 1) ?? $target[0];

        return substr_replace($html, $replacement, (int) $target[1], strlen($target[0]));
    }

    private function replaceFirstImage(string $html, string $blockClass, string $path): string
    {
        if ($path === '') {
            return $html;
        }

        $blockOffset = $this->findClassOffset($html, $blockClass);
        if ($blockOffset === null || !preg_match('/<img\s+src=".*?"/is', $html, $match, PREG_OFFSET_CAPTURE, $blockOffset)) {
            return $html;
        }

        $replacement = preg_replace('/src=".*?"/is', 'src="' . Security::e($path) . '"', $match[0][0], 1) ?? $match[0][0];

        return substr_replace($html, $replacement, (int) $match[0][1], strlen($match[0][0]));
    }

    private function replaceHeroImageWithSlider(string $html): string
    {
        $slides = CmsContentRepository::heroSlides();
        if ($slides === []) {
            return $html;
        }

        $blockOffset = $this->findClassOffset($html, 'hero-visual');
        if ($blockOffset === null || !preg_match('/<img\s+[^>]*>/is', $html, $match, PREG_OFFSET_CAPTURE, $blockOffset)) {
            return $html;
        }

        if (count($slides) === 1) {
            $slide = $slides[0];
            $replacement = preg_replace('/src=".*?"/is', 'src="' . Security::e($this->assetWithVersion((string) $slide['image'], $slide['updated_at'] ?? $slide['created_at'] ?? '')) . '"', $match[0][0], 1) ?? $match[0][0];

            return substr_replace($html, $replacement, (int) $match[0][1], strlen($match[0][0]));
        }

        $images = '';
        foreach ($slides as $index => $slide) {
            $images .= '<img src="' . Security::e($this->assetWithVersion((string) $slide['image'], $slide['updated_at'] ?? $slide['created_at'] ?? '')) . '" alt="' . Security::e((string) ($slide['title'] ?: 'Hero image')) . '" class="cms-hero-slide' . ($index === 0 ? ' is-active' : '') . '" loading="' . ($index === 0 ? 'eager' : 'lazy') . '">';
        }

        $slider = '<div class="cms-hero-slider img-fluid" data-cms-hero-slider>' . $images . '</div>';
        $html = substr_replace($html, $slider, (int) $match[0][1], strlen($match[0][0]));

        return $this->injectHeroSliderAssets($html);
    }

    private function injectHeroSliderAssets(string $html): string
    {
        $assets = <<<'HTML'
<style>
.cms-hero-slider{position:relative;width:100%;overflow:hidden}
.cms-hero-slide{display:block;width:100%;height:auto;opacity:0;position:absolute;inset:0;transition:opacity 700ms ease}
.cms-hero-slide.is-active{opacity:1;position:relative}
@media (prefers-reduced-motion: reduce){.cms-hero-slide{transition:none}}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-cms-hero-slider]').forEach(function (slider) {
    var slides = slider.querySelectorAll('.cms-hero-slide');
    if (slides.length < 2) return;
    var index = 0;
    window.setInterval(function () {
      slides[index].classList.remove('is-active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('is-active');
    }, 5000);
  });
});
</script>
HTML;

        return str_replace('</body>', $assets . "\n</body>", $html);
    }

    private function assetWithVersion(string $path, string $version): string
    {
        $url = Url::asset($path);
        $version = trim($version);
        if ($version === '') {
            return $url;
        }

        return $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . rawurlencode($version);
    }

    private function replaceContactInfoItem(string $html, int $position, string $title, array $lines): string
    {
        if (!preg_match_all('/<div class="contact-info-item"[^>]*>/i', $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $target = $matches[0][$position - 1] ?? null;
        if (!$target) {
            return $html;
        }

        $start = (int) $target[1];
        $next = $matches[0][$position][1] ?? strpos($html, '<div class="col-lg-7">', $start);
        $length = ($next === false ? strlen($html) : (int) $next) - $start;
        $block = substr($html, $start, $length);
        $block = preg_replace('/<h3>.*?<\/h3>/is', '<h3>' . Security::e($title) . '</h3>', $block, 1) ?? $block;
        $paragraphs = '';
        foreach ($lines as $line) {
            if ((string) $line !== '') {
                $paragraphs .= '<p>' . Security::e((string) $line) . '</p>';
            }
        }
        $block = preg_replace('/(?:<p>.*?<\/p>\s*)+/is', $paragraphs, $block, 1) ?? $block;

        return substr_replace($html, $block, $start, $length);
    }

    private function replaceMalformedHeroHeading(string $html, string $value): string
    {
        if ($value === '') {
            return $html;
        }

        $blockOffset = $this->findClassOffset($html, 'hero-content');
        if ($blockOffset === null) {
            return $html;
        }

        $headingOffset = strpos($html, '<h1 data-aos="fade-right" data-aos-delay="300">', $blockOffset);
        $paragraphOffset = strpos($html, '<p class="hero-description"', $blockOffset);
        if ($headingOffset === false || $paragraphOffset === false || $paragraphOffset <= $headingOffset) {
            return $html;
        }

        $openEnd = strpos($html, '>', $headingOffset);
        if ($openEnd === false) {
            return $html;
        }

        $replacement = "\n                " . Security::e($value) . "\n              </h1>\n\n              ";

        return substr_replace($html, $replacement, $openEnd + 1, $paragraphOffset - ($openEnd + 1));
    }

    private function findClassOffset(string $html, string $class): ?int
    {
        if (!preg_match('/<[^>]+class="[^"]*\b' . preg_quote($class, '/') . '\b[^"]*"/i', $html, $match, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        return (int) $match[0][1];
    }

    /** @return array<string, string> */
    private function settings(): array
    {
        try {
            $rows = Database::pdo()->query('SELECT `key`, `value` FROM settings')->fetchAll();
            return array_column($rows, 'value', 'key');
        } catch (Throwable) {
            return [];
        }
    }

    private function seo(string $slug, string $field): ?string
    {
        try {
            $stmt = Database::pdo()->prepare("SELECT {$field} FROM seo WHERE page_slug = ? LIMIT 1");
            $stmt->execute([$slug]);
            $value = $stmt->fetchColumn();
            return is_string($value) && $value !== '' ? $value : null;
        } catch (Throwable) {
            return null;
        }
    }
}
