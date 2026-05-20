<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= isset($heading) ? $heading : 'Error' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; background: #f8f8f8; }
        h1 { font-size: 48px; margin: 0 0 20px; color: #d00; }
        p { font-size: 18px; margin: 0 0 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= isset($heading) ? $heading : 'An Error Was Encountered' ?></h1>
        <p><?= isset($message) ? $message : 'Sorry, something went wrong!' ?></p>
        <a href="<?= base_url() ?>" class="btn btn-primary">Kembali ke Home</a>
    </div>
</body>
</html>
