<?php

namespace AliRaza\FileCache;

use Illuminate\Contracts\Cache\Store;

class FileCache implements Store
{
    protected $directory;

    public function __construct($directory = null)
    {
        $this->directory = $directory ?: config('filecache.cache_directory');
    }

    public function put($key, $value, $seconds)
    {
        $path = $this->getPath($key);

        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0755, true);
        }
        $data = [
            'value' => $value,
            'expires_at' => ($seconds > 0) ? time() + $seconds : null,
        ];

        file_put_contents($path, serialize($data), LOCK_EX);
    }

    public function get($key)
    {
        $path = $this->getPath($key);

        if (file_exists($path)) {
            $data = unserialize(file_get_contents($path));

            if ($data['expires_at'] === null || $data['expires_at'] > time()) {
                return $data['value'];
            } else {
                $this->forget($key);
            }
        }

        return null;
    }

    public function many(array $keys)
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }
        return $results;
    }

    public function putMany(array $values, $seconds)
    {
        foreach ($values as $key => $value) {
            $this->put($key, $value, $seconds);
        }
    }

    public function increment($key, $value = 1)
    {
        $current = (int)$this->get($key);
        $newValue = $current + $value;
        $this->put($key, $newValue, 0);
        return $newValue;
    }

    public function decrement($key, $value = 1)
    {
        return $this->increment($key, -$value);
    }

    public function forever($key, $value)
    {
        $this->put($key, $value, 0);
    }

    public function forget($key)
    {
        $path = $this->getPath($key);
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function flush()
    {
        $files = glob($this->directory . '/*');
        foreach ($files as $file) {
            unlink($file);
        }
        return true;
    }

    public function getPrefix()
    {
        return 'file_cache:';
    }

    protected function getPath($key)
    {
        return $this->directory . '/' . md5($this->getPrefix() . $key);
    }
}
