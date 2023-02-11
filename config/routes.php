<?php $routes = [
    "router" => [
        "" => [
            "controller" => "main",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "about" => [
            "controller" => "main",
            "function" => "about",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "api/convert/{?}/to/pdf" => [
            "controller" => "api\\convert",
            "function" => "topdf",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "api/digitalsigns/verify" => [
            "controller" => "api\\digitalsigns",
            "function" => "verify",
            "accept" => [
                "POST"
            ]
        ],
        "api/getplaceholder/{?}/{?}" => [
            "controller" => "api\\image",
            "function" => "getplaceholder",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "api/language/indices/sync" => [
            "controller" => "api\\language\\indices",
            "function" => "syncs",
            "accept" => [
                "POST"
            ]
        ],
        "api/placeholder" => [
            "controller" => "api\\image",
            "function" => "placeholder",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "api/upload/wordplaceholder/{?}" => [
            "controller" => "api\\word",
            "function" => "placeholder",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "api/upload/wordtemplate" => [
            "controller" => "api\\word",
            "function" => "wordtemplate",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "beranda" => [
            "controller" => "users",
            "function" => "beranda",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "constant" => [
            "controller" => "constant",
            "function" => "manage",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "constanta/create" => [
            "controller" => "primary\\constanta",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "constanta/explore" => [
            "controller" => "primary\\constanta",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "constanta/search" => [
            "controller" => "primary\\constanta",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "constanta/table" => [
            "controller" => "primary\\constanta",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "constanta/{?}" => [
            "controller" => "primary\\constanta",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "constanta/{?}/delete" => [
            "controller" => "primary\\constanta",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "constanta/{?}/update" => [
            "controller" => "primary\\constanta",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "digital_sign_users/create" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "digital_sign_users/explore" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "digital_sign_users/search" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "digital_sign_users/table" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "digital_sign_users/{?}" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "digital_sign_users/{?}/delete" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "digital_sign_users/{?}/update" => [
            "controller" => "primary\\digital_sign_users",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "digital_signs/create" => [
            "controller" => "primary\\digital_signs",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "digital_signs/explore" => [
            "controller" => "primary\\digital_signs",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "digital_signs/search" => [
            "controller" => "primary\\digital_signs",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "digital_signs/table" => [
            "controller" => "primary\\digital_signs",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "digital_signs/{?}" => [
            "controller" => "primary\\digital_signs",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "digital_signs/{?}/delete" => [
            "controller" => "primary\\digital_signs",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "digital_signs/{?}/update" => [
            "controller" => "primary\\digital_signs",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "digitalsigns/users" => [
            "controller" => "digitalsigns",
            "function" => "users",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "digitalsigns/verify/{?}" => [
            "controller" => "digitalsigns",
            "function" => "verify",
            "accept" => [
                "GET"
            ]
        ],
        "excel/coderender/{?}/{?}" => [
            "controller" => "excel",
            "function" => "coderender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "excel/create" => [
            "controller" => "primary\\excel",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "excel/explore" => [
            "controller" => "primary\\excel",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "excel/main" => [
            "controller" => "excel",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "excel/render/{?}/{?}" => [
            "controller" => "excel",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "excel/search" => [
            "controller" => "primary\\excel",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "excel/table" => [
            "controller" => "primary\\excel",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "excel/update/{?}" => [
            "controller" => "excel",
            "function" => "update",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "excel/{?}" => [
            "controller" => "primary\\excel",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "excel/{?}/delete" => [
            "controller" => "primary\\excel",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "excel/{?}/update" => [
            "controller" => "primary\\excel",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "feedback/create" => [
            "controller" => "primary\\feedback",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "feedback/explore" => [
            "controller" => "primary\\feedback",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "feedback/search" => [
            "controller" => "primary\\feedback",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "feedback/table" => [
            "controller" => "primary\\feedback",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "feedback/{?}" => [
            "controller" => "primary\\feedback",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "feedback/{?}/delete" => [
            "controller" => "primary\\feedback",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "feedback/{?}/update" => [
            "controller" => "primary\\feedback",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "guide" => [
            "controller" => "guide",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "guide/pte" => [
            "controller" => "guide",
            "function" => "pte",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "home" => [
            "controller" => "main",
            "function" => "home",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "images/coderender/{?}/{?}" => [
            "controller" => "images",
            "function" => "coderender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "images/create" => [
            "controller" => "primary\\images",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "images/explore" => [
            "controller" => "primary\\images",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "images/main" => [
            "controller" => "images",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "images/render/{?}/{?}" => [
            "controller" => "images",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "images/search" => [
            "controller" => "primary\\images",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "images/table" => [
            "controller" => "primary\\images",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "images/update/{?}" => [
            "controller" => "images",
            "function" => "update",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "images/{?}" => [
            "controller" => "primary\\images",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "images/{?}/delete" => [
            "controller" => "primary\\images",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "images/{?}/update" => [
            "controller" => "primary\\images",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "language/indices/update/{?}" => [
            "controller" => "languange\\indices",
            "function" => "update",
            "accept" => [
                "GET"
            ]
        ],
        "language_indices/create" => [
            "controller" => "primary\\language_indices",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "language_indices/explore" => [
            "controller" => "primary\\language_indices",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "language_indices/search" => [
            "controller" => "primary\\language_indices",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "language_indices/table" => [
            "controller" => "primary\\language_indices",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "language_indices/{?}" => [
            "controller" => "primary\\language_indices",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "language_indices/{?}/delete" => [
            "controller" => "primary\\language_indices",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "language_indices/{?}/update" => [
            "controller" => "primary\\language_indices",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "log_mail/create" => [
            "controller" => "primary\\log_mail",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "log_mail/explore" => [
            "controller" => "primary\\log_mail",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "log_mail/search" => [
            "controller" => "primary\\log_mail",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "log_mail/table" => [
            "controller" => "primary\\log_mail",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "log_mail/{?}" => [
            "controller" => "primary\\log_mail",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "log_mail/{?}/delete" => [
            "controller" => "primary\\log_mail",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "log_mail/{?}/update" => [
            "controller" => "primary\\log_mail",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "log_pdf/create" => [
            "controller" => "primary\\log_pdf",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "log_pdf/explore" => [
            "controller" => "primary\\log_pdf",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "log_pdf/search" => [
            "controller" => "primary\\log_pdf",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "log_pdf/table" => [
            "controller" => "primary\\log_pdf",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "log_pdf/{?}" => [
            "controller" => "primary\\log_pdf",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "log_pdf/{?}/delete" => [
            "controller" => "primary\\log_pdf",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "log_pdf/{?}/update" => [
            "controller" => "primary\\log_pdf",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "login" => [
            "controller" => "main",
            "function" => "userlogin",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "logout" => [
            "controller" => "main",
            "function" => "userlogout",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/coderender/{?}/{?}" => [
            "controller" => "mail",
            "function" => "coderender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/create" => [
            "controller" => "primary\\mail",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "mail/explore" => [
            "controller" => "primary\\mail",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "mail/html/{?}" => [
            "controller" => "mail",
            "function" => "html",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/main" => [
            "controller" => "mail",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/render/{?}/{?}" => [
            "controller" => "mail",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/search" => [
            "controller" => "primary\\mail",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "mail/style/{?}" => [
            "controller" => "mail",
            "function" => "style",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/table" => [
            "controller" => "primary\\mail",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "mail/update/{?}" => [
            "controller" => "mail",
            "function" => "update",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "mail/{?}" => [
            "controller" => "primary\\mail",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "mail/{?}/delete" => [
            "controller" => "primary\\mail",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "mail/{?}/update" => [
            "controller" => "primary\\mail",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "pdf/coderender/{?}/{?}" => [
            "controller" => "pdf",
            "function" => "coderender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/create" => [
            "controller" => "primary\\pdf",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "pdf/explore" => [
            "controller" => "primary\\pdf",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "pdf/html/{?}" => [
            "controller" => "pdf",
            "function" => "html",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/render/{?}/{?}" => [
            "controller" => "pdf",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/search" => [
            "controller" => "primary\\pdf",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "pdf/style/{?}" => [
            "controller" => "pdf",
            "function" => "style",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/table" => [
            "controller" => "primary\\pdf",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "pdf/timeline/{?}" => [
            "controller" => "pdf",
            "function" => "timeline",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/timeline/{?}/{?}/{?}" => [
            "controller" => "pdf",
            "function" => "timelinerender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/update/{?}" => [
            "controller" => "pdf",
            "function" => "update",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "pdf/{?}" => [
            "controller" => "primary\\pdf",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "pdf/{?}/delete" => [
            "controller" => "primary\\pdf",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "pdf/{?}/update" => [
            "controller" => "primary\\pdf",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "pdf/{?}/update/html" => [
            "controller" => "primary\\pdf",
            "function" => "update_html",
            "accept" => [
                "POST"
            ]
        ],
        "profil" => [
            "controller" => "users",
            "function" => "profil",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "qr" => [
            "controller" => "qr",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "qr/render" => [
            "controller" => "qr",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "qr/render/{?}" => [
            "controller" => "qr",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "register" => [
            "controller" => "main",
            "function" => "register",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "sorry" => [
            "controller" => "main",
            "function" => "sorry",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "status/create" => [
            "controller" => "primary\\status",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "status/explore" => [
            "controller" => "primary\\status",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "status/search" => [
            "controller" => "primary\\status",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "status/table" => [
            "controller" => "primary\\status",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "status/{?}" => [
            "controller" => "primary\\status",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "status/{?}/delete" => [
            "controller" => "primary\\status",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "status/{?}/update" => [
            "controller" => "primary\\status",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "testimonial/create" => [
            "controller" => "primary\\testimonial",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "testimonial/explore" => [
            "controller" => "primary\\testimonial",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "testimonial/search" => [
            "controller" => "primary\\testimonial",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "testimonial/table" => [
            "controller" => "primary\\testimonial",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "testimonial/{?}" => [
            "controller" => "primary\\testimonial",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "testimonial/{?}/delete" => [
            "controller" => "primary\\testimonial",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "testimonial/{?}/update" => [
            "controller" => "primary\\testimonial",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "users/create" => [
            "controller" => "primary\\users",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "users/data" => [
            "controller" => "primary\\users",
            "function" => "data",
            "accept" => [
                "GET"
            ]
        ],
        "users/explore" => [
            "controller" => "primary\\users",
            "function" => "explore",
            "accept" => [
                "POST",
                "GET"
            ]
        ],
        "users/login" => [
            "controller" => "primary\\users",
            "function" => "login",
            "accept" => [
                "POST"
            ]
        ],
        "users/search" => [
            "controller" => "primary\\users",
            "function" => "search",
            "accept" => [
                "POST"
            ]
        ],
        "users/table" => [
            "controller" => "primary\\users",
            "function" => "table",
            "accept" => [
                "POST"
            ]
        ],
        "users/{?}" => [
            "controller" => "primary\\users",
            "function" => "read",
            "accept" => [
                "GET"
            ]
        ],
        "users/{?}/delete" => [
            "controller" => "primary\\users",
            "function" => "delete",
            "accept" => [
                "DELETE"
            ]
        ],
        "users/{?}/update" => [
            "controller" => "primary\\users",
            "function" => "update",
            "accept" => [
                "PUT",
                "POST"
            ]
        ],
        "word/coderender/{?}/{?}" => [
            "controller" => "word",
            "function" => "coderender",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "word/main" => [
            "controller" => "word",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "word/render/{?}/{?}" => [
            "controller" => "word",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "word/update/{?}" => [
            "controller" => "word",
            "function" => "update",
            "accept" => [
                "GET",
                "POST"
            ]
        ]
    ],
    "error" => [
        "controller" => "error",
        "function" => "display",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "not_found" => [
        "controller" => "error",
        "function" => "notfound",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "maintenance" => [
        "controller" => "error",
        "function" => "maintenance",
        "accept" => [
            "GET",
            "POST"
        ]
    ]
]; return $routes;