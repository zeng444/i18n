<?php

namespace Janfish\Internationalization;

/**
 * 语言包管理
 * Author:Robert
 *
 * Class Internationalization
 * @package Janfish\Internationalization
 */
class Locale
{

    /**
     * Author:Robert
     *
     * @var array
     */
    private static $files = [];

    /**
     * Author:Robert
     *
     * @var mixed
     */
    private $_langBasePath;

    /**
     * Author:Robert
     *
     * @var mixed
     */
    private $_langFile = 'Common';

    /**
     * @var string
     */
    private $_lang = 'zh';

    /**
     * Lang constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['langPath'])) {
            $this->_langBasePath = $options['langPath'];
        }
        if (isset($options['defaultFile'])) {
            $this->_langFile = $options['defaultFile'];
        }
        if (isset($options['defaultLang'])) {
            $this->_lang = $options['defaultLang'];
        }
    }

    /**
     * Author:Robert
     *
     * @param string $lang
     */
    public function changeLang(string $lang)
    {
        $this->_lang = $lang;
    }


    /**
     * Author:Robert
     *
     * @return string
     */
    public function current()
    {
        return $this->_lang;
    }

    /**
     * Author:Robert
     *
     * @param string|null $name
     * @return mixed
     * @throws \Exception
     */
    public function load(string $name = null)
    {
        $name = $name ?: $this->_langFile;
        $currentLang = self::current();
        $fileKey = "$currentLang:$name";
        if (isset(self::$files[$fileKey])) {
            return self::$files[$fileKey];
        }
        $path = $this->_langBasePath.'/'.$currentLang.'/'.$name.'.php';
        if (!file_exists($path)) {
            throw new \Exception('不存在的语言配置文件');
        }
        self::$files[$fileKey] = require_once $path;
        return self::$files[$fileKey];
    }

    /**
     * Author:Robert
     *
     * @param string $key
     * @param string|null $name
     * @return string
     * @throws \Exception
     */
    public function get(string $key, string $name = null): string
    {
        $variables = $this->load($name);
        return $variables[$key] ?? $key;
    }
}