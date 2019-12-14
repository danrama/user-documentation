**This type is intended to help with code being transitioned from untyped mode to strict
mode.**

Although `dynamic` can be used as the type of a class constant or property, or a function
return type, its primary use is as a parameter type.

This special type is used to help capture dynamism in the existing codebase in typed code, in
a more manageable manner than `mixed`. With `dynamic`, the presence of dynamism in a function
is local to the function, and dynamic behaviors cannot leak into code that does not know about it.

Consider the following:
```Hack

function f(dynamic $x) : void {
  $n = $x + 5;            // $n is a num
  $s = $x . "hello!";     // $s is a string
  $y = $x->anyMethod();   // $y is dynamic
}
```

A value of type `dynamic` can be used in most local operations: like untyped expressions, we
can treat it like a `num` and add it, or a `string` and concatenate it, or call any method on it, as shown above.

When using a dynamic type in an operation, the type checker infers the best possible type with
the information it has. For example, using a dynamic in an arithmetic operation like + or - result
in a `num`, using a dynamic in a string operation result in a `string`, but calling a method on a
dynamic, results in another dynamic.

`dynamic` allows calls, property access, and bracket access without a null-check, but it can throw if the runtime value is null.

# Coercion

The `dynamic` type sits outside the normal type hierarchy. It is a supertype only of the bottom type `nothing`
and a subtype only of the top type `mixed`. The type interfaces with other types via coercion (`~>` in the 
examples). All types coerce to `dynamic`, which allows callers to pass any type into a function that expects dynamic. Also, any type 
coerces to its supertypes. Coercion points include function calls, return statements, and property assignment.

@@ dynamic-examples/coercion_to_dynamic.php @@

The runtime enforces a set of types by throwing `TypeHintViolationException` when an incorrect type is provided. This set includes

- primitive types
- classes without generics, or with reified generics
- reified generics with the `<<__Enforceable>>` attribute
- transparent type aliases to enforceable types

Hack approximates this runtime behavior by allowing values of type `dynamic` to coerce to enforceable types at coercion points.

@@ dynamic-examples/coercion_from_dynamic.php.type-errors @@

Unions with dynamic are also allowed to coerce to enforceable types provided that each element of the union can coerce.

@@ dynamic-examples/coercion_from_union.php.type-errors @@

Notably, unlike subtyping, coercion is *not* transitive, meaning that `int ~> dynamic` and `dynamic ~> string` does not imply that `int ~> string`.