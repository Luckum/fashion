<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>Redirect to partner</title>
    <style>
        .center-screen {
            font-family: 'Roboto Condensed', Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
            font-weight: 600;
            margin-top: -75px;
            font-size: 20px;
        }
    </style>
    <script>
        setTimeout(function () {window.location.href = 'http://go.skimresources.com/?id=118861X1578703&url=<?= urlencode($url) ?>'}, 3000)
    </script>
</head>
<body>
    <div class="center-screen">
        <p>Taking you to <?= strtoupper($partner_site_name) ?></p>
        <p style="font-weight: 300; font-size: 13px;">If you are not automatically redirected, <a href="http://go.skimresources.com/?id=118861X1578703&url=<?= urlencode($url) ?>">click here</a></p>
    </div>
</body>
</html>