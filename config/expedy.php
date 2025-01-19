<?php

return [
    'sid' => env('EXPEDY_SID'),
    'token' => env('EXPEDY_TOKEN'),
    'printer_uid' => env('EXPEDY_PRINTER_UID'),
    'printer_uid_backup' => env('EXPEDY_PRINTER_UID_BACKUP', ''),
    'sms_num' => env('EXPEDY_SMS_NUM', ''),
    'printer_size' => env('EXPEDY_PRINTER_SIZE', 58),
    'print_on' => env('EXPEDY_PRINT_ON', false),
    'logo_url' => env('EXPEDY_LOGO_URL', ''),
    'title' => env('EXPEDY_TITLE', ''),
    'company' => env('EXPEDY_COMPANY', ''),
    'company_id' => env('EXPEDY_COMPANY_ID', ''),
    'adr1' => env('EXPEDY_ADR1', ''),
    'adr2' => env('EXPEDY_ADR2', ''),
    'zip' => env('EXPEDY_ZIP', ''),
    'city' => env('EXPEDY_CITY', ''),
    'phone' => env('EXPEDY_PHONE', ''),
    'email' => env('EXPEDY_EMAIL', ''),
    'short_opts' => env('EXPEDY_SHORT_OPTS', 0),
    'print_nb' => env('EXPEDY_PRINT_NB', 1),
    'multistore' => env('EXPEDY_MULTISTORE', ''),
    'time_shift' => env('EXPEDY_TIME_SHIFT', 0),
];
?>