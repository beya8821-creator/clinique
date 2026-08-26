<?php

declare(strict_types=1);

$baseDir = __DIR__;
$pageDir = $baseDir . '/app/Views/pages';
$files = glob($pageDir . '/*.html');

foreach ($files as $file) {
    $slug = basename($file, '.html');
    $html = file_get_contents($file);
    if ($html === false) {
        fwrite(STDERR, "Failed to read $file\n");
        continue;
    }

    if (!preg_match('/<head\b.*?>.*<\/head>/is', $html, $headMatch)) {
        fwrite(STDERR, "Missing <head> in $file\n");
        continue;
    }
    $head = $headMatch[0];

    if (!preg_match('/<body\b([^>]*)>(.*)<\/body>/is', $html, $bodyMatch)) {
        fwrite(STDERR, "Missing <body> in $file\n");
        continue;
    }

    $bodyAttrs = trim($bodyMatch[1]);
    $bodyContent = $bodyMatch[2];
    $bodyOpen = '<body' . ($bodyAttrs !== '' ? ' ' . $bodyAttrs : '') . '>';

    if (!preg_match('/<header\b.*?<\/header>/is', $bodyContent, $headerMatch)) {
        fwrite(STDERR, "Missing <header> in $file\n");
        continue;
    }

    if (!preg_match('/<footer\b.*?<\/footer>/is', $bodyContent, $footerMatch)) {
        fwrite(STDERR, "Missing <footer> in $file\n");
        continue;
    }

    $headerHtml = $headerMatch[0];
    $footerHtml = $footerMatch[0];

    $headerStart = strpos($bodyContent, $headerHtml);
    $footerStart = strpos($bodyContent, $footerHtml);
    $contentBeforeHeader = substr($bodyContent, 0, $headerStart);
    $contentBetween = substr($bodyContent, $headerStart + strlen($headerHtml), $footerStart - ($headerStart + strlen($headerHtml)));
    $contentAfterFooter = substr($bodyContent, $footerStart + strlen($footerHtml));
    $bodyInner = $contentBeforeHeader . $contentBetween . $contentAfterFooter;

    if (preg_match('/<a\b[^>]*class="[^"]*logo[^"]*"[^>]*>(.*?)<\/a>/is', $headerHtml, $logoMatch)) {
        $logoHtml = trim($logoMatch[1]);
    } else {
        $logoHtml = '<h1 class="sitename">Polyclinique Yetu</h1>';
    }

    $phpContent = "<?php\n";
    $phpContent .= "declare(strict_types=1);\n\n";
    $phpContent .= "\$currentPage = '$slug';\n";
    $phpContent .= "\$headerLogoHtml = <<<HTML\n";
    $phpContent .= $logoHtml . "\nHTML;\n\n";
    $phpContent .= "?>\n";
    $phpContent .= "<!DOCTYPE html>\n<html lang=\"en\">\n";
    $phpContent .= $head . "\n";
    $phpContent .= $bodyOpen . "\n";
    $phpContent .= "<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>\n";
    $phpContent .= $bodyInner . "\n";
    $phpContent .= "<?php include dirname(__DIR__, 3) . '/includes/footer.php'; ?>\n";
    $phpContent .= "</body>\n</html>\n";

    $phpFile = $pageDir . '/' . $slug . '.php';
    file_put_contents($phpFile, $phpContent);
    echo "Created $phpFile\n";
}
