<?php
$routers = [
    "blog_index" => [
        "url" => "/blog/index",
        "class" => "Article",
        "action" => "select",
        "template" => "index.twig"
    ],
    "blog_post" => [
        "url" => "/blog/post/(\d+)",
        "class" => "Article",
        "action" => "selectOne",
        "template" => "post.twig"
    ],
    "login" => [
        "url" => "/blog/login",
        "class" => "Member",
        "action" => "login",
        "template" => "empty.twig"
    ],
    "register" => [
        "url" => "/blog/register",
        "class" => "Member",
        "action" => "insert",
        "template" => "register.twig"
    ],
    "contact" => [
       "url" => "/blog/contact",
       "class" => "Contact",
       "action" => "insert",
       "template" => "contact.twig",
    ],
    "logout" => [
        "url" => "/blog/logout",
        "class" => "User",
        "action" => "logOut",
        "template" => "empty.twig",
    ],
];