# laravel-collection-extensions
Extensions for Laravel's Collection class. Notably groupByMultiple for grouping collections on multiple fields instead of just one.

**Example:**

A | B | C | D
------------ | ------------- | ------------- | -------------
foo | bar | baz | thud
foo | garply | corge | plugh
foo | bar | corge | thud
foo | bar | corge | waldo
qux | garply | xyzzy | fred
qux | grault | garply | quuz

By calling myCollection->groupBy(['A', 'B', 'C', 'D']) the result would become:

* foo
  * bar
    * baz
      * thud [foo, bar, baz, thud]
    * corge
      * thud [foo, bar, corge, thud]
      * waldo [foo, bar, corge, waldo]
  * garply
    * corge
      * plugh [foo, garply, corge, plugh]
* qux
  * garply
    * xyzzy
      * fred [quz, garply, xyzzy, fred]
  * grault
    * garply
      * quuz [qux, grault, garply, quuz]

**Cross compatibility**
The groupByMultiple function is somewhat compatible with Laravel's original groupBy in that it functions in the same way if you pass as first argument something that is not an array, so just like groupBy you can call it with a string or a closure. The function just puts the first argument in an array if it isn't one. If you try to pass a callable as an array, so ["Foo", "Bar"] where Foo::Bar() is a valid method, then of course the groupByMultiple function will just attempt to group on the key "Foo" first and "Bar" second; this is the main incompatibility with groupBy(). Of course you can pass an array with a callable in it, so [["Foo", "Bar"]] or [["Foo", "Bar"], "Baz"] would work just fine. For people already using groupBy, this function will be very easy to switch to.
