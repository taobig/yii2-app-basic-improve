<?php

namespace app\components;


use yii\bootstrap\BootstrapPluginAsset;
use yii\web\View;
use yii\web\YiiAsset;

class StaticResource
{

    private static $manifestContent;

    /**
     * @param string $staticFile must start with '/'
     * @return string
     */
    private static function src(string $staticFile): string
    {
        if (!YII_ENV_DEV && defined("STATIC_RESOURCE_HOST")) {
            $buildDirectory = 'build';
            $prefix = empty(STATIC_RESOURCE_HOST) ? '' : rtrim(STATIC_RESOURCE_HOST, '/') . '/';

            if (self::$manifestContent === null) {
                $manifestPath = \Yii::getAlias('@webroot/build/rev-manifest.json');
                if (file_exists($manifestPath)) {
                    $content = file_get_contents($manifestPath);
                    if ($content) {
                        self::$manifestContent = json_decode($content, true);
                    }
                }
            }
            if (self::$manifestContent !== null) {
                $pos = strpos($staticFile, '?');
                $query = ($pos !== false) ? substr($staticFile, $pos) : '';
                $_index = substr($staticFile, 1, strlen($staticFile) - 1 - strlen($query));
                if (isset(self::$manifestContent[$_index])) {
                    return $prefix . $buildDirectory . '/' . self::$manifestContent[$_index] . $query;
                }
            }
        }

        if (defined("STATIC_RESOURCE_VERSION")) {
            $connector = (strpos($staticFile, '?') === false) ? '?' : '&';
            if (YII_ENV_DEV) {
                return $staticFile . $connector . 'v=' . time();
            }
            return $staticFile . $connector . 'v=' . STATIC_RESOURCE_VERSION;
        }

        return $staticFile;
    }

    public static function loadScript(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerJsFile(self::src($path), ['position' => $position, 'depends' => $depends]);
    }

    public static function loadCompressedScript(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerJsFile($path, ['position' => $position, 'depends' => $depends]);
    }

    public static function loadStyle(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerCssFile(self::src($path), ['position' => $position, 'depends' => $depends]);
    }

    public static function loadCompressedStyle(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerCssFile($path, ['position' => $position, 'depends' => $depends]);
    }

    public static function renderScript(string $path)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        return sprintf('<script src="%s"></script>', self::src($path));
    }

    public static function renderStyle(string $path)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        return sprintf('<link rel="stylesheet" href="%s" />', self::src($path));
    }
}

