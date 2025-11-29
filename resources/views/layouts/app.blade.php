<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM Premium')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#0a0a0a',
                            800: '#121212',
                            700: '#1a1a1a',
                            600: '#262626',
                        },
                        brand: {
                            500: '#3b82f6', // Blue for Kanban
                            600: '#2563eb',
                        }
                    }
                }
            }
        }
    </script>
    
    @php
        $gaId = App\Models\Setting::get('google_analytics');
        $gtmHead = App\Models\Setting::get('gtm_head');
    @endphp
    
    @if($gaId)
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
    @endif
    
    @if($gtmHead)
    {!! $gtmHead !!}
    @endif
</head>
<body class="bg-dark-900 text-white antialiased min-h-screen flex flex-col">
    @php
        $gtmBody = App\Models\Setting::get('gtm_body');
    @endphp
    
    @if($gtmBody)
    {!! $gtmBody !!}
    @endif
    
    @yield('content')
</body>
</html>
