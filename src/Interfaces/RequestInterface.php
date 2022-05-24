<?php

namespace DanielWinning\Request\Interfaces;

interface RequestInterface
{
    public static function uri(): string;
    public static function method(): string;
    public static function hasQueryString(): bool;
    public static function has(string $key = null): bool;
    public static function get(string $key = null): mixed;
}