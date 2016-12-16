<?php
/**
 * 解析内容源代码中的 Github Gist 链接
 *
 * @package Github Gist
 * @version 0.0.1
 * @author Simple Code
 * @link http://typecho.org
 */
class GithubGist implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('GithubGist', 'parse');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('GithubGist', 'parse');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('GithubGist', 'parse');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {}

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    /**
     * 解析
     *
     * @access public
     * @param array $matches 解析值
     * @return string
     */
    public static function parseCallback($matches)
    {
        return '<script src="//tool.fengqi.me/gist.php?gist=' . urlencode($matches[1]) . '.js"></script>';
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return string
     */
    public static function parse($text, $widget, $lastResult)
    {
        $text = empty($lastResult) ? $text : $lastResult;

        if ($widget instanceof Widget_Archive || $widget instanceof Widget_Abstract_Comments) {
            return preg_replace_callback("/(https:\/\/gist.github.com\/[a-zA-Z0-9]+\/[a-zA-Z0-9]+)/i", array('GithubGist', 'parseCallback'), $text);
        }
        else {
            return $text;
        }
    }
}
