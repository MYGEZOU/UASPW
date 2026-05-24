<?php
$dir = new RecursiveDirectoryIterator('C:\\xampp\\htdocs\\UASPW\\app\\Views');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;

        // 1. fa-edit without title/aria-label
        $content = preg_replace(
            '/(<a\s+href="[^"]+"\s+class="btn\s+btn-[^"]+"\s*)(>)(?=\s*<i\s+class="fas\s+fa-edit"><\/i>\s*<\/a>)/i',
            '$1 aria-label="Edit"$2',
            $content
        );

        // 2. fa-edit with title (replace title with aria-label or just add aria-label)
        $content = preg_replace(
            '/(<a\s+href="[^"]+"\s+class="btn\s+btn-[^"]+"\s+)title="[^"]+"(\s*)(>)(?=\s*<i\s+class="fas\s+fa-edit"><\/i>\s*<\/a>)/i',
            '$1aria-label="Edit"$2$3',
            $content
        );

        // 3. fa-trash without title
        $content = preg_replace(
            '/(<a\s+href="[^"]+"\s+class="btn\s+btn-[^"]+"\s+onclick="[^"]+"\s*)(>)(?=\s*<i\s+class="fas\s+fa-trash"><\/i>\s*<\/a>)/i',
            '$1 aria-label="Hapus"$2',
            $content
        );

        // 4. fa-trash with title
        $content = preg_replace(
            '/(<a\s+href="[^"]+"\s+class="btn\s+btn-[^"]+"\s+)title="[^"]+"(\s+onclick="[^"]+"\s*)(>)(?=\s*<i\s+class="fas\s+fa-trash"><\/i>\s*<\/a>)/i',
            '$1aria-label="Hapus"$2$3',
            $content
        );

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}
echo "Done replacing aria-labels.\n";
