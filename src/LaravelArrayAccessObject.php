<?php

namespace Takemo101\LaravelSimpleVM;

use Takemo101\SimpleVM\ArrayAccessObject;
use Illuminate\Contracts\Support\{
    Arrayable,
    Jsonable,
};
use Illuminate\Support\Arr;

/**
 * array access object for laravel class
 *
 * @implements Arrayable<string|int, mixed>
 */
final class LaravelArrayAccessObject extends ArrayAccessObject implements Arrayable, Jsonable
{
    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return boolean
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetExists(mixed $key): bool
    {
        if (!(is_int($key) || is_string($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        return Arr::exists($this->data, $key);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return mixed
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetGet(mixed $key): mixed
    {
        if (!(is_int($key) || is_string($key) || is_null($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        return Arr::get($this->data, $key);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        if (!(is_string($key) || is_null($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        Arr::set($this->data, $key, $value);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return void
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetUnset(mixed $key): void
    {
        if (!(is_array($key) || is_string($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        Arr::forget($this->data, $key);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return (string)json_encode($this->jsonSerialize(), $options);
    }

    /**
     * get and set the value by the method.
     *
     * @param string $method
     * @param mixed[] $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (count($parameters)) {

            $this[$method] = $parameters[0];

            return $this;
        }

        return $this[$method];
    }
}
