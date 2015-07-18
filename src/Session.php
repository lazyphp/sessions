<?php

namespace duncan3dc\Sessions;

/**
 * A static interface for SessionInstance.
 */
class Session
{
    /**
     * @var string $name The name of the session.
     */
    protected static $name = "";

    /**
     * @var SessionInstance $session The underlying session instance.
     */
    protected static $session = null;

    /**
     * Set the name of the session to use.
     *
     * @param string $name The name of the session
     *
     * @return void
     */
    public static function name($name)
    {
        static::$name = $name;
        static::$session = null;
    }


    /**
     * Ensure the session instance has been created.
     *
     * @return void
     */
    protected static function getInstance()
    {
        if (static::$session instanceof SessionInstance) {
            return static::$session;
        }

        if (strlen(static::$name) < 1) {
            throw new \Exception("Cannot start session, no name has been specified, you must call Session::name() before using this class");
        }

        static::$session = new SessionInstance(static::$name);

        return static::$session;
    }


    /**
     * Create a new namespaced section of this session to avoid clashes.
     *
     * @param string $name The namespace of the session
     *
     * @return SessionNamespace
     */
    public static function createNamespace($name)
    {
        return static::getInstance()->createNamespace($name);
    }


    /**
     * Get a value from the session data cache.
     *
     * @param string $key The name of the name to retrieve
     *
     * @return mixed
     */
    public static function get($key)
    {
        return static::getInstance()->get($key);
    }


    /**
     * Get all the current session data.
     *
     * @return array
     */
    public static function getAll()
    {
        return static::getInstance()->getAll();
    }


    /**
     * Set a value within session data.
     *
     * @param string|array $data Either the name of the session key to update, or an array of keys to update
     * @param mixed $value If $data is a string then store this value in the session data
     *
     * @return void
     */
    public static function set($data, $value = null)
    {
        static::getInstance()->set($data, $value);
    }


    /**
     * This is a convenience method to prevent having to do several checks/set for all persistant variables.
     *
     * If the key name has been passed via POST then that value is stored in the session and returned.
     * If the key name has been passed via GET then that value is stored in the session and returned.
     * If there is already a value in the session data then that is returned.
     * If all else fails then the default value is returned.
     * All checks are truthy/falsy (so a POST value of "0" is ignored), unless the 3rd parameter is set to true.
     *
     * @param string $key The name of the key to retrieve from session data
     * @param mixed $default The value to use if the current session value is falsy
     * @param bool $strict Whether to do strict comparisons or not
     *
     * @return mixed
     */
    public static function getSet($key, $default = null, $strict = false)
    {
        return static::getInstance()->getSet($key, $default, $strict);
    }


    /**
     * Unset a value within session data.
     *
     * @param string $keys The keys to delete from the session
     *
     * @return void
     */
    public static function delete(...$keys)
    {
        static::getInstance()->delete(...$keys);
    }


    /**
     * Clear all previously set values.
     *
     * @return void
     */
    public static function clear()
    {
        static::getInstance()->clear();
    }


    /**
     * Tear down the session and wipe all it's data.
     *
     * @return void
     */
    public static function destroy()
    {
        static::getInstance()->destroy();
    }
}
