<?php

return [
    "host" => env("MAIL_HOST", "smtp.mailtrap.io"),
    "port" => env("MAIL_PORT", 2525),
    "username" => env("MAIL_USERNAME"),
    "password" => env("MAIL_PASSWORD"),
    "encryption" => env("MAIL_ENCRYPTION", "tls"),
];