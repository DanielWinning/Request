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

**`Request::get(string $key)`** returns the value of the specified query string parameter, or the value of the specified 
`$_POST` array key.