<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'binary'  => base_path(env('SNAPPY_PDF_BINARY_PATH', 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltopdf')),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => base_path(env('SNAPPY_IMAGE_BINARY_PATH', 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage')),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

);
