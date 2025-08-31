<?php

return [
    'isRemoteEnabled' => true, // Required for loading images via asset()
    'isHtml5ParserEnabled' => true,
    'enable_php' => false,
    'dpi' => 96, // Lower DPI to reduce rendering time
    'default_media_type' => 'screen',
    'font_cache' => storage_path('app/dompdf_fonts/'), // Custom font cache path
    'isFontSubsettingEnabled' => false, // Disable font subsetting to reduce processing
];
