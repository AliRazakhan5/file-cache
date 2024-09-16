<h1 align="center"><a href="https://github.com/AliRazakhan5/file-cache" target="_blank">File Cache</a></h1>

<p align="center">
<a href="https://github.com/AliRazakhan5/file-cache"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://github.com/AliRazakhan5/file-cache"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://github.com/AliRazakhan5/file-cache"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Package

FileCache is a lightweight, custom file-based caching solution designed for Laravel. It provides an easy and efficient way to cache data on the filesystem, bypassing the need for more complex cache stores like Redis or Memcached. The package is especially useful for smaller applications or environments where disk-based caching is preferred.

## Features

File-Based Caching: Store cache data in the filesystem without relying on external cache servers.

Expiration Support: Set cache expiration times, and automatically remove stale cache entries.

Flexible Cache Management: Easily get, put, forget, and flush cache data with intuitive methods.

Cache Increments & Decrements: Support for numeric cache manipulation.

Forever Caching: Ability to store items indefinitely until explicitly removed.

Simple Integration: Works seamlessly with any Laravel application with minimal setup.

## Installation

To install the package via Composer, run the following command:

composer require ali-raza/file-cache

## Publishing Configuration

After installing the package, publish the configuration file using the following Artisan command:

php artisan vendor:publish --provider="AliRaza\FileCache\Providers\FileCacheServiceProvider"

This will publish a configuration file at config/filecache.php, allowing you to customize the cache directory. Ensure that the service provider is registered automatically. If not, manually add it to the providers array in config/app.php:

// package Service Providers

'providers' => [AliRaza\FileCache\Providers\FileCacheServiceProvider::class,],

## Basic Usage

Here’s an example of how to use FileCache in your Laravel project:

use AliRaza\FileCache\FileCache;

// Create an instance of FileCache

$cache = new FileCache();

// Put an item in the cache

$cache->put('key', 'value', 3600); // Cache for 1 hour

// Get an item from the cache

$value = $cache->get('key');

// Remove an item from the cache

$cache->forget('key');

// Clear all cached items

$cache->flush();

## Configuration

The package allows you to configure the directory where cache files will be stored by editing config/filecache.php:

return ['cache_directory' => storage_path('framework/cache/filecache'),];

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Ali Raza Khan via [araza@polymerhq.io](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
