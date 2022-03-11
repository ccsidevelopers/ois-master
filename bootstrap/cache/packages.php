<?php return array (
  'barryvdh/laravel-dompdf' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
    ),
  ),
  'barryvdh/laravel-snappy' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Snappy\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\Snappy\\Facades\\SnappyPdf',
      'SnappyImage' => 'Barryvdh\\Snappy\\Facades\\SnappyImage',
    ),
  ),
  'chumper/zipper' => 
  array (
    'providers' => 
    array (
      0 => 'Chumper\\Zipper\\ZipperServiceProvider',
    ),
    'aliases' => 
    array (
      'Zipper' => 'Chumper\\Zipper\\Zipper',
    ),
  ),
  'hisorange/browser-detect' => 
  array (
    'providers' => 
    array (
      0 => 'hisorange\\BrowserDetect\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Browser' => 'hisorange\\BrowserDetect\\Facade',
    ),
  ),
  'intervention/image' => 
  array (
    'providers' => 
    array (
      0 => 'Intervention\\Image\\ImageServiceProvider',
    ),
    'aliases' => 
    array (
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ),
  ),
  'jimmyjs/laravel-report-generator' => 
  array (
    'providers' => 
    array (
      0 => 'Jimmyjs\\ReportGenerator\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PdfReport' => 'Jimmyjs\\ReportGenerator\\Facades\\PdfReportFacade',
      'ExcelReport' => 'Jimmyjs\\ReportGenerator\\Facades\\ExcelReportFacade',
      'CSVReport' => 'Jimmyjs\\ReportGenerator\\Facades\\CSVReportFacade::class',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'maatwebsite/excel' => 
  array (
    'providers' => 
    array (
      0 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' => 
    array (
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'maddhatter/laravel-fullcalendar' => 
  array (
    'providers' => 
    array (
      0 => 'MaddHatter\\LaravelFullcalendar\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Calendar' => 'MaddHatter\\LaravelFullcalendar\\Facades\\Calendar',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'simplesoftwareio/simple-qrcode' => 
  array (
    'providers' => 
    array (
      0 => 'SimpleSoftwareIO\\QrCode\\QrCodeServiceProvider',
    ),
    'aliases' => 
    array (
      'QrCode' => 'SimpleSoftwareIO\\QrCode\\Facades\\QrCode',
    ),
  ),
  'yajra/laravel-datatables-oracle' => 
  array (
    'providers' => 
    array (
      0 => 'Yajra\\DataTables\\DataTablesServiceProvider',
    ),
    'aliases' => 
    array (
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ),
  ),
  'zanysoft/laravel-zip' => 
  array (
    'providers' => 
    array (
      0 => 'ZanySoft\\Zip\\ZipServiceProvider',
    ),
    'aliases' => 
    array (
      'Zip' => 'ZanySoft\\Zip\\ZipFacade',
    ),
  ),
);