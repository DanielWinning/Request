<?php

namespace DanielWinning\Request;

class Request implements \DanielWinning\Request\Interfaces\RequestInterface
{
    public static function uri(): string
    {
        return trim(explode("#", explode("?", $_SERVER["REQUEST_URI"])[0])[0], "/");
    }

    public static function method(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public static function hasQueryString(): bool
    {
        if (str_contains($_SERVER["REQUEST_URI"], "?")) {
            return true;
        }

        return false;
    }

    public static function has(string $key = null): bool
    {
        if (self::method() === "GET") {
            if (self::hasQueryString()) {
                parse_str(parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY), $query);

                return array_key_exists($key, $query);
            }
        } elseif (self::method() === "POST") {
            return array_key_exists($key, $_POST);
        }

        return false;
    }

    public static function get(string $key = null): mixed
    {
        if (!is_null($key)) {
            if (self::method() === "GET") {
                if (self::hasQueryString()) {
                    parse_str(parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY), $query);

                    return $query[$key] ?? null;
                }

                return null;
            } elseif (self::method() === "POST") {
                return $_POST[$key] ?? null;
            }
        } else {
            if (self::method() === "GET") {
                if (self::hasQueryString()) {
                    parse_str(parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY), $query);

                    return $query;
                }

                return [];
            } elseif (self::method() === "POST") {
                return $_POST;
            }
        }

        return null;
    }
}