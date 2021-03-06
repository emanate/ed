# ed *(core class)*

The `ed` class is the heart of the library.  This is a static class that only has one method: `import`.  This class is included in your `appconfig.php` file and does the rest of the class loading in your application for you.  No more messy lists of `require()` or `include()` calls!

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("ClassContainer.ClassName");
```

## Documentation Index

* [Importing Classes](#importing-classes)

## Importing Classes

Once you have included (or required) your base ed class, you can use the static `import` method to load any required classes and their associated dependencies.

*__NOTE__*
There is a second legacy method in this class called `load` which acts identically to `import`.