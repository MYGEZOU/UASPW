<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Error</title>
    <style>
        body { font-family: monospace; margin: 40px; background: #f4f4f4; }
        .error-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .error-code { font-size: 72px; color: #d00; font-weight: bold; }
        .error-message { font-size: 24px; margin: 20px 0; color: #333; }
        pre { background: #f8f8f8; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <div class="error-message">Internal Server Error</div>
        <pre><?= esc($exception) ?></pre>
        <a href="<?= base_url() ?>">← Back to Home</a>
    </div>
</body>
</html>
