<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TruePath Express - Global consignment and logistics platform for reliable shipping and package tracking worldwide.">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | TruePath Express' : 'TruePath Express'; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="../../assets/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="TruePath Express">
    <link rel="manifest" href="../../assets/favicon/site.webmanifest">

    <!-- Preconnect to CDN for faster external resources -->
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">

    <!-- Preload Critical Fonts -->
    <link rel="preload" as="font" href="/assets/fonts/Coolvetica Rg.woff2" type="font/woff2" crossorigin>
    <link rel="preload" as="font" href="/assets/fonts/Coolvetica Rg It.woff2" type="font/woff2" crossorigin>

    <!-- Phosphor Icons -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/main.min.css">
    <link rel="stylesheet" href="/assets/css/responsive.min.css">
</head>
<body>
    <!-- Page Loader -->
    <div class="loader" id="pageLoader">
        <div class="loader__spinner"></div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
