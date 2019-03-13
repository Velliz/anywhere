<?php $routes = [
    "page" => [
        "" => [
            "controller" => "main",
            "function" => "main",
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
        "login" => [
            "controller" => "main",
            "function" => "userlogin",
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
        "logout" => [
            "controller" => "main",
            "function" => "userlogout",
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
        "home" => [
            "controller" => "main",
            "function" => "home",
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
        "beranda" => [
            "controller" => "users",
            "function" => "beranda",
            "accept" => [
                "GET",
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
        "guide/pte" => [
            "controller" => "guide",
            "function" => "pte",
            "accept" => [
                "GET",
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
        "pdf/main" => [
            "controller" => "pdf",
            "function" => "main",
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
        "pdf/html/{?}" => [
            "controller" => "pdf",
            "function" => "html",
            "accept" => [
                "GET",
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
        "pdf/render/{?}/{?}" => [
            "controller" => "pdf",
            "function" => "render",
            "accept" => [
                "GET",
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
        "excel/main" => [
            "controller" => "excel",
            "function" => "main",
            "accept" => [
                "GET",
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
        "excel/render/{?}/{?}" => [
            "controller" => "excel",
            "function" => "render",
            "accept" => [
                "GET",
                "POST"
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
        "word/main" => [
            "controller" => "word",
            "function" => "main",
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
        ],
        "word/render/{?}/{?}" => [
            "controller" => "word",
            "function" => "render",
            "accept" => [
                "GET",
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
        "mail/main" => [
            "controller" => "mail",
            "function" => "main",
            "accept" => [
                "GET",
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
        "mail/html/{?}" => [
            "controller" => "mail",
            "function" => "html",
            "accept" => [
                "GET",
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
        "mail/render/{?}/{?}" => [
            "controller" => "mail",
            "function" => "render",
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
        "images/main" => [
            "controller" => "images",
            "function" => "main",
            "accept" => [
                "GET",
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
        "images/render/{?}/{?}" => [
            "controller" => "images",
            "function" => "render",
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
        "api/placeholder" => [
            "controller" => "api\\image",
            "function" => "placeholder",
            "accept" => [
                "GET",
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
        "api/upload/wordtemplate" => [
            "controller" => "api\\word",
            "function" => "wordtemplate",
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
    ]
]; return $routes;