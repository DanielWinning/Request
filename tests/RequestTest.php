<?php

use PHPUnit\Framework\TestCase;
use DanielWinning\Request\Request;

final class RequestTest extends TestCase {
    public function setUp(): void
    {
        $_SERVER["REQUEST_URI"] = "/blog/posts/";
    }

    /**
     * Request::uri()
     */
    public function testDoesRequestUriTrimTrailingAndPrecedingSlashes()
    {
        $this->assertEquals("blog/posts", Request::uri(), "Request::uri() should trim trailing and preceding slashes");
    }

    public function testDoesRequestUriRemoveQueryString()
    {
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertEquals("blog/posts", Request::uri(), "Request::uri() should remove query string");
    }

    public function testDoesRequestUriRemoveFragment()
    {
        $_SERVER["REQUEST_URI"] = "/blog/posts#page=2";
        $this->assertEquals("blog/posts", Request::uri(), "Request::uri() should remove fragment");
    }

    /**
     * Request::method()
     */
    public function testDoesRequestMethodReturnMethod()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $this->assertEquals("GET", Request::method(), "Request::method() should return GET");
        $_SERVER["REQUEST_METHOD"] = "POST";
        $this->assertEquals("POST", Request::method(), "Request::method() should return POST");
    }

    /**
     * Request::hasQueryString()
     */
    public function testDoesRequestHasQueryStringReturnTrueWhenQueryStringIsSet()
    {
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertTrue(Request::hasQueryString(), "Request::hasQueryString() should return true");
    }

    public function testDoesRequestHasQueryStringReturnFalseWhenQueryStringIsNotSet()
    {
        $_SERVER["REQUEST_URI"] = "/blog/posts";
        $this->assertFalse(Request::hasQueryString(), "Request::hasQueryString() should return false");
    }

    /**
     * Request::has()
     */
    public function testDoesRequestHasReturnTrueWhenQueryVariableIsSet()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertTrue(Request::has("page"), "Request::has() should return true");
    }

    public function testDoesRequestHasReturnFalseWhenQueryVariableIsNotSet()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertFalse(Request::has("page2"), "Request::has() should return false");
    }

    public function testDoesRequestHasReturnFalseWhenQueryVariableIsNotSetAndQueryStringIsNotSet()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts";
        $this->assertFalse(Request::has("page"), "Request::has() should return false");
    }

    public function testDoesRequestHasReturnFalseWhenNoArgumentIsEntered()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertFalse(Request::has(), "Request::has() should return false");
    }

    /**
     * Request::get()
     */
    public function testDoesRequestGetReturnQueryVariable()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertEquals("2", Request::get("page"), "Request::get() should return query variable");
    }

    public function testDoesRequestGetReturnNullWhenQueryVariableIsNotSet()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2";
        $this->assertNull(Request::get("page2"), "Request::get() should return null");
    }

    public function testDoesRequestGetReturnNullWhenQueryVariableIsNotSetAndQueryStringIsNotSet()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts";
        $this->assertNull(Request::get("page"), "Request::get() should return null");
    }

    public function testDoesRequestGetReturnQueryVariableWhenMethodIsPost()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["page"] = "2";
        $this->assertEquals("2", Request::get("page"), "Request::get() should return query variable");
    }

    public function testDoesRequestGetReturnNullWhenQueryVariableIsNotSetAndMethodIsPost()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["page"] = "2";
        $this->assertNull(Request::get("page2"), "Request::get() should return null");
    }

    public function testDoesRequestGetReturnArrayWhenNoKeyIsSpecifiedAndQueryStringExists()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts?page=2&sort=desc";
        $this->assertEquals(["page" => "2", "sort" => "desc"], Request::get(), "Request::get() should return array");
    }

    public function testDoesRequestGetReturnArrayWhenNoKeyIsSpecifiedAndQueryStringDoesNotExist()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/blog/posts";
        $this->assertEquals([], Request::get(), "Request::get() should return array");
    }

    public function testDoesRequestGetReturnArrayWhenNoKeyIsSpecifiedAndPostDataExistsAndMethodIsPost()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["page"] = "2";
        $_POST["sort"] = "desc";
        $this->assertEquals(["page" => "2", "sort" => "desc"], Request::get(), "Request::get() should return array");
    }
}