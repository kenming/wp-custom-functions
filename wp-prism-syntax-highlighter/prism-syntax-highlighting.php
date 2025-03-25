<?php
/**
 * Prism.js 語法高亮功能
 *
 * 使用 CDN 載入最新版本的 Prism.js，包含行號插件和 Solarized Light 主題
 *
 * @package Bricks-Child
 * @author  Claude 3.7 Sonnet
 * @version 1.0.2 (2025-03-25)
 */

// 如果直接訪問此檔案，則退出
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 新增 Prism.js 語法高亮功能
 * - 使用 jsDelivr CDN 載入最新版本
 * - 採用 Solarized Light 主題
 * - 啟用行號插件
 */
function add_prism_js_highlighting() {
    //if ( is_single() && strpos( get_the_content(), '<pre>' ) !== false ) {
        // 設定 Prism.js 版本
        $prism_version = '1.30.0';
        
        // 使用 jsDelivr 的 Prism.js CDN，指定固定版本
        $prism_base_url = 'https://cdn.jsdelivr.net/npm/prismjs@' . $prism_version;
        $prism_css_url = $prism_base_url . '/themes/prism-okaidia.min.css';
        $prism_js_url = $prism_base_url . '/prism.min.js';
        $prism_line_numbers_css_url = $prism_base_url . '/plugins/line-numbers/prism-line-numbers.min.css';
        $prism_line_numbers_js_url = $prism_base_url . '/plugins/line-numbers/prism-line-numbers.min.js';
        // 添加複製到剪貼簿插件
        $prism_copy_to_clipboard_url = $prism_base_url . '/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js';
        $prism_toolbar_css_url = $prism_base_url . '/plugins/toolbar/prism-toolbar.min.css';
        $prism_toolbar_js_url = $prism_base_url . '/plugins/toolbar/prism-toolbar.min.js';
        $prism_autoloader_url = $prism_base_url . '/plugins/autoloader/prism-autoloader.min.js';
        
        // 使用固定版本號，提高穩定性
        $version = $prism_version;
        
        // 註冊和載入 CSS
        wp_enqueue_style('prism-css', $prism_css_url, array(), $version);
        wp_enqueue_style('prism-line-numbers', $prism_line_numbers_css_url, array('prism-css'), $version);
        wp_enqueue_style('prism-toolbar', $prism_toolbar_css_url, array('prism-css'), $version);
        
        // 註冊和載入 JS (放在頁面底部)
        wp_enqueue_script('prism-js', $prism_js_url, array(), $version, true);
        wp_enqueue_script('prism-line-numbers', $prism_line_numbers_js_url, array('prism-js'), $version, true);
        wp_enqueue_script('prism-toolbar', $prism_toolbar_js_url, array('prism-js'), $version, true);
        wp_enqueue_script('prism-copy-to-clipboard', $prism_copy_to_clipboard_url, array('prism-js', 'prism-toolbar'), $version, true);        
        wp_enqueue_script('prism-autoloader', $prism_autoloader_url, array('prism-js'), $version, true);
        
        // 如果 CDN 載入失敗，使用本地備份版本
        wp_add_inline_script('prism-js', '
        if (typeof Prism === "undefined") {
            console.log("Prism.js CDN 載入失敗，嘗試使用本地版本");
            
            // 載入本地 Prism 核心
            var localScript = document.createElement("script");
            localScript.src = "' . get_stylesheet_directory_uri() . '/assets/js/prism.min.js";
            localScript.onload = function() {
                console.log("本地 Prism.js 核心載入成功");
                
                // 載入本地行號插件
                var lineNumbersScript = document.createElement("script");
                lineNumbersScript.src = "' . get_stylesheet_directory_uri() . '/assets/js/prism-line-numbers.min.js";
                document.body.appendChild(lineNumbersScript);

                // 載入本地工具列插件
                var toolbarScript = document.createElement("script");
                toolbarScript.src = "' . get_stylesheet_directory_uri() . '/assets/js/prism-toolbar.min.js";
                document.body.appendChild(toolbarScript);
                
                // 載入本地複製到剪貼簿插件
                var copyScript = document.createElement("script");
                copyScript.src = "' . get_stylesheet_directory_uri() . '/assets/js/prism-copy-to-clipboard.min.js";
                document.body.appendChild(copyScript);                
                
                // 載入本地自動載入器插件
                var autoloaderScript = document.createElement("script");
                autoloaderScript.src = "' . get_stylesheet_directory_uri() . '/assets/js/prism-autoloader.min.js";
                autoloaderScript.onload = function() {
                    // 設定 Autoloader 的語言路徑為本地路徑
                    if (Prism.plugins.autoloader) {
                        Prism.plugins.autoloader.languages_path = "' . get_stylesheet_directory_uri() . '/assets/js/prism-components/";
                    }
                    
                    // 初始化 Prism
                    initializePrism();
                };
                document.body.appendChild(autoloaderScript);
            };
            localScript.onerror = function() {
                console.error("本地 Prism.js 也無法載入，語法高亮功能可能無法正常工作");
            };
            document.body.appendChild(localScript);
        }
        
        function initializePrism() {
            // 為所有程式碼區塊添加行號
            document.querySelectorAll("pre:not(.no-line-numbers)").forEach(function(pre) {
                pre.classList.add("line-numbers");
            });
            
            // 重新高亮所有程式碼區塊
            if (typeof Prism !== "undefined") {
                Prism.highlightAll();
            }
        }
        ');
                
        // 註冊和載入自訂 CSS
        wp_enqueue_style(
            'prism-custom-css',
            get_stylesheet_directory_uri() . '/assets/css/prism-custom.css',
            array('prism-css', 'prism-line-numbers', 'prism-toolbar'),
            $version
        );
        
        // 新增初始化腳本
        $init_script = '
        document.addEventListener("DOMContentLoaded", function() {
            // 為所有程式碼區塊添加行號
            document.querySelectorAll("pre:not(.no-line-numbers)").forEach(function(pre) {
                pre.classList.add("line-numbers");
            });
            
            // 初始化 Prism
            if (typeof Prism !== "undefined") {
                Prism.highlightAll();
            }
        });
        ';
        
        wp_add_inline_script('prism-js', $init_script);
    //}
}
add_action('wp_enqueue_scripts', 'add_prism_js_highlighting');

/**
 * 註冊 Prism.js 短代碼
 * 
 * 用法:
 * [prism lang="php" line_numbers="true" highlight="1,3-5" filename="example.php"]程式碼內容[/prism]
 */
function prism_shortcode($atts, $content = null) {
    // 提取屬性
    $attributes = shortcode_atts(array(
        'lang' => 'markup',
        'line_numbers' => 'true',
        'highlight' => '',
        'filename' => '',
        'start' => '1',  // 起始行號
    ), $atts);
    
    // 移除 WordPress 自動添加的 HTML 標籤
    $content = preg_replace('/<br\s*\/?>/i', '', $content);
    $content = preg_replace('/<\/?p>/i', '', $content);
    
    // 處理程式碼，移除首尾的空白
    $content = trim($content);
    
    // 建立 CSS 類別
    $classes = 'language-' . esc_attr($attributes['lang']);
    
    // 建立 data 屬性
    $data_attr = '';
    if ($attributes['line_numbers'] === 'true') {
        $classes .= ' line-numbers';
        if ($attributes['start'] !== '1') {
            $data_attr .= ' data-start="' . esc_attr($attributes['start']) . '"';
        }
    }
    
    if (!empty($attributes['highlight'])) {
        $data_attr .= ' data-line="' . esc_attr($attributes['highlight']) . '"';
    }
    
    // 檔案名稱顯示
    $filename_html = '';
    if (!empty($attributes['filename'])) {
        $filename_html = '<div class="code-filename">' . esc_html($attributes['filename']) . '</div>';
    }
    
    // 確保 Prism.js 被載入
    add_prism_js_highlighting();
    
    // 輸出 HTML
    return $filename_html . '<pre class="' . $classes . '"' . $data_attr . '><code class="' . $classes . '">' . 
           esc_html($content) . '</code></pre>';
}
add_shortcode('prism', 'prism_shortcode');

/**
 * 防止 WordPress 自動添加 p 標籤到短代碼內容
 */
function prism_shortcode_fix($content) {
    $array = array(
        '<p>[prism' => '[prism',
        'prism]</p>' => 'prism]',
        '<p></pre>' => '</pre>',
        '<pre><br />' => '<pre>',
    );
    return strtr($content, $array);
}
add_filter('the_content', 'prism_shortcode_fix');

/**
 * 在 Gutenberg 編輯器中添加 Prism.js 支援
 * 目前並未實作
 */
/*
function add_prism_to_gutenberg() {
    // 只在編輯器中載入
    if (!is_admin()) {
        return;
    }
    
    // 註冊和載入編輯器樣式
    wp_enqueue_style(
        'prism-editor-css',
        get_stylesheet_directory_uri() . '/assets/css/prism-editor.css',
        array(),
        '1.0.0'
    );
    
    // 添加編輯器腳本
    wp_enqueue_script(
        'prism-editor-js',
        get_stylesheet_directory_uri() . '/assets/js/prism-editor.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        '1.0.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'add_prism_to_gutenberg');
*/