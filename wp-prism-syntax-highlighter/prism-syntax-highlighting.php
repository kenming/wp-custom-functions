<?php
/**
 * Prism.js 語法高亮功能
 *
 * 使用 CDN 載入最新版本的 Prism.js，包含行號插件和 Solarized Light 主題
 *
 * @package Bricks-Child
 * @author  Claude 3.7 Sonnet
 * @version 1.0.0 (2025-03-24)
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
        
        // 新增自訂 CSS 以優化顯示效果
        $custom_css = '
        /* 確保程式碼區塊能夠水平捲動而不換行 */
        pre[class*="language-"] {
            overflow: auto;
            max-height: 800px; /* 設定最大高度，超過則捲動 */
            margin: 1.5em 0;
            border-radius: 5px;
        }
        
        /* 優化行號顯示 */
        .line-numbers .line-numbers-rows {
            border-right: 1px solid #ddd;
            padding-right: 10px;
        }
        
        /* 自訂複製按鈕樣式 */
        div.code-toolbar > .toolbar {
            opacity: 0.3;
            transition: opacity 0.3s ease-in-out;
            right: 1.2em !important;
        }
        
        div.code-toolbar:hover > .toolbar {
            opacity: 1;
        }
        
        div.code-toolbar > .toolbar > .toolbar-item > button {
            color: #fff;
            background: #3a3a3a;
            border-radius: 3px;
            padding: 5px 10px;
            font-size: 0.8em;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        div.code-toolbar > .toolbar > .toolbar-item > button:hover {
            background: #555;
        }
        
        /* 複製成功提示樣式 */
        div.code-toolbar > .toolbar > .toolbar-item > span.copy-success {
            color: #fff;
            background: #4caf50;
            border-radius: 3px;
            padding: 5px 10px;
            font-size: 0.8em;
        }
        
        /* 確保程式碼區塊在行動裝置上也能正常顯示 */
        @media (max-width: 767px) {
            pre[class*="language-"] {
                font-size: 14px;
                padding: 1em;
            }
            
            div.code-toolbar > .toolbar {
                opacity: 1;
            }
            
            div.code-toolbar > .toolbar > .toolbar-item > button {
                padding: 3px 8px;
                font-size: 0.7em;
            }
        }
        ';
        
        wp_add_inline_style('prism-css', $custom_css);
        
        // 新增初始化腳本
        $init_script = '
        // 自動為所有 pre > code 元素添加 line-numbers 類別
        document.addEventListener("DOMContentLoaded", function() {
            // 為所有程式碼區塊添加行號
            document.querySelectorAll("pre:not(.no-line-numbers)").forEach(function(pre) {
                pre.classList.add("line-numbers");
            });
            
            // 設定 Autoloader 的語言路徑
            if (Prism.plugins.autoloader) {
                Prism.plugins.autoloader.languages_path = "https://cdn.jsdelivr.net/npm/prismjs@latest/components/";
            }
            
            // 重新高亮所有程式碼區塊
            Prism.highlightAll();
        });
        ';
        
        wp_add_inline_script('prism-autoloader', $init_script);
    //}
}
add_action('wp_enqueue_scripts', 'add_prism_js_highlighting');

/**
 * 自動將 WordPress 內建的程式碼區塊轉換為 Prism.js 格式
 */
function convert_to_prism_format($content) {
    // 尋找 <pre><code> 組合但沒有 language- 類別的區塊
    $pattern = '/<pre><code>(.*?)<\/code><\/pre>/s';
    $replacement = '<pre><code class="language-markup">$1</code></pre>';
    $content = preg_replace($pattern, $replacement, $content);
    
    return $content;
}
add_filter('the_content', 'convert_to_prism_format');

/**
 * 新增簡短程式碼以便在文章中輕鬆插入程式碼區塊
 * 使用方式: [prism lang="php"]<?php echo "Hello World"; ?>[/prism]
 */
function prism_code_shortcode($atts, $content = null) {
    $attributes = shortcode_atts(array(
        'lang' => 'markup', // 預設語言
        'line_numbers' => 'true', // 是否顯示行號
    ), $atts);
    
    $language = esc_attr($attributes['lang']);
    $line_numbers_class = ($attributes['line_numbers'] === 'true') ? ' line-numbers' : '';
    
    // 處理程式碼內容，確保 HTML 實體被正確編碼
    $content = htmlspecialchars(trim($content), ENT_QUOTES);
    
    return '<pre class="' . $line_numbers_class . '"><code class="language-' . $language . '">' . $content . '</code></pre>';
}
add_shortcode('prism', 'prism_code_shortcode');