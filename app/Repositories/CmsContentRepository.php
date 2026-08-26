<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;
use Throwable;

final class CmsContentRepository
{
    public static function section(string $pageSlug, string $sectionKey): ?array
    {
        try {
            $stmt = self::pdo()->prepare('SELECT * FROM cms_sections WHERE page_slug = ? AND section_key = ? LIMIT 1');
            $stmt->execute([$pageSlug, $sectionKey]);
            $section = $stmt->fetch();

            return is_array($section) ? $section : null;
        } catch (Throwable) {
            return null;
        }
    }

    public static function saveSection(array $data): void
    {
        $stmt = self::pdo()->prepare(
            'INSERT INTO cms_sections
                (page_slug, section_key, label, title, subtitle, body, button_text, button_url, image_path, video_url, extra_json)
             VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                label = VALUES(label),
                title = VALUES(title),
                subtitle = VALUES(subtitle),
                body = VALUES(body),
                button_text = VALUES(button_text),
                button_url = VALUES(button_url),
                image_path = VALUES(image_path),
                video_url = VALUES(video_url),
                extra_json = VALUES(extra_json),
                updated_at = NOW()'
        );
        $stmt->execute([
            $data['page_slug'],
            $data['section_key'],
            $data['label'] ?? '',
            $data['title'] ?? '',
            $data['subtitle'] ?? '',
            $data['body'] ?? '',
            $data['button_text'] ?? '',
            $data['button_url'] ?? '',
            $data['image_path'] ?? '',
            $data['video_url'] ?? '',
            $data['extra_json'] ?? null,
        ]);
    }

    public static function sections(string $pageSlug): array
    {
        try {
            $stmt = self::pdo()->prepare('SELECT * FROM cms_sections WHERE page_slug = ? ORDER BY id');
            $stmt->execute([$pageSlug]);

            return $stmt->fetchAll();
        } catch (Throwable) {
            return [];
        }
    }

    public static function services(bool $activeOnly = true): array
    {
        try {
            $sql = 'SELECT * FROM cms_services';
            if ($activeOnly) {
                $sql .= ' WHERE is_active = 1';
            }
            $sql .= ' ORDER BY sort_order, id';

            return self::pdo()->query($sql)->fetchAll();
        } catch (Throwable) {
            return [];
        }
    }

    public static function service(int $id): ?array
    {
        try {
            $stmt = self::pdo()->prepare('SELECT * FROM cms_services WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            $service = $stmt->fetch();

            return is_array($service) ? $service : null;
        } catch (Throwable) {
            return null;
        }
    }

    public static function saveService(array $data): void
    {
        if (!empty($data['id'])) {
            $stmt = self::pdo()->prepare(
                'UPDATE cms_services
                 SET title = ?, slug = ?, description = ?, image_path = ?, icon_class = ?, button_text = ?, button_url = ?,
                     features_text = ?, sort_order = ?, is_active = ?, updated_at = NOW()
                 WHERE id = ?'
            );
            $stmt->execute([
                $data['title'],
                $data['slug'],
                $data['description'],
                $data['image_path'],
                $data['icon_class'],
                $data['button_text'],
                $data['button_url'],
                $data['features_text'],
                (int) $data['sort_order'],
                (int) $data['is_active'],
                (int) $data['id'],
            ]);
            return;
        }

        $stmt = self::pdo()->prepare(
            'INSERT INTO cms_services
                (title, slug, description, image_path, icon_class, button_text, button_url, features_text, sort_order, is_active)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['description'],
            $data['image_path'],
            $data['icon_class'],
            $data['button_text'],
            $data['button_url'],
            $data['features_text'],
            (int) $data['sort_order'],
            (int) $data['is_active'],
        ]);
    }

    public static function deleteService(int $id): void
    {
        self::pdo()->prepare('DELETE FROM cms_services WHERE id = ?')->execute([$id]);
    }

    public static function heroSlides(bool $activeOnly = true): array
    {
        try {
            $sql = 'SELECT * FROM hero_slider';
            if ($activeOnly) {
                $sql .= ' WHERE status = 1';
            }
            $sql .= ' ORDER BY display_order, id';

            return self::pdo()->query($sql)->fetchAll();
        } catch (Throwable) {
            return [];
        }
    }

    public static function heroSlide(int $id): ?array
    {
        try {
            $stmt = self::pdo()->prepare('SELECT * FROM hero_slider WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            $slide = $stmt->fetch();

            return is_array($slide) ? $slide : null;
        } catch (Throwable) {
            return null;
        }
    }

    public static function saveHeroSlide(array $data): void
    {
        if (!empty($data['id'])) {
            $stmt = self::pdo()->prepare(
                'UPDATE hero_slider
                 SET image = ?, title = ?, subtitle = ?, button_text = ?, button_link = ?,
                     display_order = ?, status = ?, updated_at = NOW()
                 WHERE id = ?'
            );
            $stmt->execute([
                $data['image'],
                $data['title'] ?? '',
                $data['subtitle'] ?? '',
                $data['button_text'] ?? '',
                $data['button_link'] ?? '',
                (int) ($data['display_order'] ?? 0),
                (int) ($data['status'] ?? 1),
                (int) $data['id'],
            ]);
            return;
        }

        $stmt = self::pdo()->prepare(
            'INSERT INTO hero_slider (image, title, subtitle, button_text, button_link, display_order, status)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['image'],
            $data['title'] ?? '',
            $data['subtitle'] ?? '',
            $data['button_text'] ?? '',
            $data['button_link'] ?? '',
            (int) ($data['display_order'] ?? 0),
            (int) ($data['status'] ?? 1),
        ]);
    }

    public static function deleteHeroSlide(int $id): void
    {
        self::pdo()->prepare('DELETE FROM hero_slider WHERE id = ?')->execute([$id]);
    }

    public static function reorderHeroSlides(array $orders): void
    {
        $stmt = self::pdo()->prepare('UPDATE hero_slider SET display_order = ?, updated_at = NOW() WHERE id = ?');
        foreach ($orders as $id => $order) {
            $stmt->execute([(int) $order, (int) $id]);
        }
    }

    public static function contact(): array
    {
        $defaults = [
            'address_title' => 'Our Address',
            'address' => '1842 Maple Avenue, Portland, Oregon 97204',
            'email_title' => 'Email Address',
            'email_primary' => 'info@example.com',
            'email_secondary' => 'contact@example.com',
            'hours_title' => 'Hours of Operation',
            'hours_primary' => 'Sunday-Fri: 9 AM - 6 PM',
            'hours_secondary' => 'Saturday: 9 AM - 4 PM',
            'phone' => '+243 970 220 803',
            'form_title' => 'Send us a Message',
            'form_intro' => 'Have questions or want to learn more? Reach out to us and our team will get back to you shortly.',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus',
            'facebook_url' => '',
            'instagram_url' => '',
            'linkedin_url' => '',
            'whatsapp_url' => '',
        ];

        try {
            $rows = self::pdo()->query('SELECT `key`, `value` FROM cms_contact_settings')->fetchAll();
            foreach ($rows as $row) {
                $defaults[(string) $row['key']] = (string) $row['value'];
            }
        } catch (Throwable) {
        }

        return $defaults;
    }

    public static function saveContact(array $settings): void
    {
        $stmt = self::pdo()->prepare(
            'INSERT INTO cms_contact_settings (`key`, `value`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), updated_at = NOW()'
        );

        foreach ($settings as $key => $value) {
            $stmt->execute([(string) $key, (string) $value]);
        }
    }

    public static function textReplacements(string $pageSlug): array
    {
        try {
            $stmt = self::pdo()->prepare('SELECT original_hash, replacement_text FROM cms_text_replacements WHERE page_slug = ?');
            $stmt->execute([$pageSlug]);

            return array_column($stmt->fetchAll(), 'replacement_text', 'original_hash');
        } catch (Throwable) {
            return [];
        }
    }

    public static function saveTextReplacements(string $pageSlug, array $originals, array $replacements): void
    {
        $pdo = self::pdo();
        $upsert = $pdo->prepare(
            'INSERT INTO cms_text_replacements (page_slug, original_hash, original_text, replacement_text)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE original_text = VALUES(original_text), replacement_text = VALUES(replacement_text), updated_at = NOW()'
        );
        $delete = $pdo->prepare('DELETE FROM cms_text_replacements WHERE page_slug = ? AND original_hash = ?');

        foreach ($originals as $hash => $original) {
            $replacement = trim((string) ($replacements[$hash] ?? ''));
            $originalText = trim((string) $original);

            if ($replacement === '' || $replacement === $originalText) {
                $delete->execute([$pageSlug, (string) $hash]);
                continue;
            }

            $upsert->execute([$pageSlug, (string) $hash, $originalText, $replacement]);
        }
    }

    public static function textCandidates(string $pageSlug): array
    {
        $file = dirname(__DIR__) . '/Views/pages/' . $pageSlug . '.php';
        if (!is_file($file)) {
            $file = dirname(__DIR__) . '/Views/pages/' . $pageSlug . '.html';
        }
        if (!is_file($file)) {
            return [];
        }

        $html = (string) file_get_contents($file);
        $html = preg_replace('/<\?php.*?\?>/is', '', $html) ?? $html;
        $html = preg_replace('/<script\b.*?<\/script>/is', '', $html) ?? $html;
        $html = preg_replace('/<style\b.*?<\/style>/is', '', $html) ?? $html;
        preg_match_all('/>([^<>]+)</u', $html, $matches);

        $texts = [];
        foreach ($matches[1] ?? [] as $text) {
            $normalized = self::normalizeText(html_entity_decode((string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if (self::isEditableText($normalized)) {
                $texts[sha1($normalized)] = $normalized;
            }
        }

        return $texts;
    }

    public static function normalizeText(string $text): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', $text));
    }

    private static function isEditableText(string $text): bool
    {
        if ($text === '' || mb_strlen($text) < 2) {
            return false;
        }

        if (preg_match('/^[{}();,\[\].#:=\s]+$/', $text)) {
            return false;
        }

        return !str_contains($text, '<?') && !str_contains($text, '?>');
    }

    private static function pdo(): PDO
    {
        return Database::pdo();
    }
}
