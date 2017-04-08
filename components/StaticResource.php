<?php

namespace app\components;


use yii\bootstrap\BootstrapPluginAsset;
use yii\web\View;
use yii\web\YiiAsset;

class StaticResource
{

    static $manifestContent;

    /**
     * @param string $staticFile must start with '/'
     * @return string
     */
    private static function src(string $staticFile): string
    {
        if (!YII_DEBUG && defined("STATIC_HOST") && !empty(STATIC_HOST)) {
            $buildDirectory = 'build';

            if (static::$manifestContent === null) {
                $manifestPath = \Yii::getAlias('@webroot/build/rev-manifest.json');
                if (file_exists($manifestPath)) {
                    $content = file_get_contents($manifestPath);
                    if ($content) {
                        static::$manifestContent = json_decode($content, true);
                    }
                }
            }
            if (static::$manifestContent !== null) {
                $_index = substr($staticFile, 1, strlen($staticFile) - 1);
                if (isset(static::$manifestContent[$_index])) {
                    return STATIC_HOST . $buildDirectory . '/' . static::$manifestContent[$_index];
                }
            }
            return STATIC_HOST . $staticFile;
        }
        return $staticFile;
    }

    public static function loadScript(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerJsFile(static::src($path), ['position' => $position, 'depends' => $depends]);
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
        $view->registerCssFile(static::src($path), ['position' => $position, 'depends' => $depends]);
    }

    public static function loadCompressedStyle(View $view, string $path, array $depends = [YiiAsset::class, BootstrapPluginAsset::class], int $position = View::POS_END)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $view->registerCssFile($path, ['position' => $position, 'depends' => $depends]);
    }
}

