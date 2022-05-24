## Install
```
composer require danielwinning/request
```

## Usage
```
use \DanielWinning\Request\Request;
```

### Methods
**`Request::uri()`** returns the current URL, without the query string, leading or trailing slashes.

**`Request::method()`** returns the current request method.

**`Request::hasQueryString()`** returns true if the current request has a query string attached.

**`Request::has()`** returns true if the current request has the specified query string parameter, or if the `$_POST` 
array has the specified key.

**`Request::get(string $key = null)`** returns the value of the specified query string parameter, or the value of the 
specified `$_POST` array key, depending on the current request method. If `$key` is not specified, the entire query 
string is returned as an array. If the method is `POST` and no key is specified, the entire `$_POST` array is returned.