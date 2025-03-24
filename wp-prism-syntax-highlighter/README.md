# Prism.js 語法高亮功能

這個功能檔案為 WordPress 網站添加 Prism.js 語法高亮功能，適合放置在佈景主題的 `/inc` 目錄下，特別適合開發者和技術部落格使用。

## 功能特點

- 🚀 使用 jsDelivr CDN 載入 Prism.js 1.30.0 版本
- 🎨 採用美觀的 Okaidia 暗色主題
- 🔢 自動為程式碼區塊添加行號
- 📋 內建程式碼複製按鈕功能
- 🔄 自動載入所需的語言支援
- 📱 完全響應式設計，在行動裝置上也能完美顯示
- ⚠️ 內建 CDN 失敗時的本地備份機制

## 安裝方法

1. 將 `prism-syntax-highlighting.php` 檔案上傳到您的 WordPress 主題的 `/inc` 目錄
2. 在主題的 `functions.php` 中添加以下程式碼：
   ```php
	/**
	 * 載入 Prism.js 語法高亮功能
	 */
	$prism_file = get_stylesheet_directory() . '/inc/prism-syntax-highlighting.php';
	if (file_exists($prism_file)) {
		require_once $prism_file;
	}
   ```

## 使用方法

### 方法一：使用 Shortcode

在文章或頁面中使用以下 Shortcode 來插入程式碼區塊：

```
[prism lang="php"]
<?php
echo "Hello World";
?>
[/prism]
```

#### 可用參數

- `lang`: 指定程式語言（預設：markup）
- `line_numbers`: 是否顯示行號（預設：true）

範例：
```
[prism lang="javascript" line_numbers="false"]
function sayHello() {
  console.log("Hello World!");
}
[/prism]
```

### 方法二：使用 HTML 區塊

直接在 WordPress 編輯器中使用 HTML 區塊：

```html
<pre class="line-numbers">
<code class="language-css">
body {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
}
</code>
</pre>
```

### 方法三：使用 WordPress 程式碼區塊

使用 WordPress 內建的程式碼區塊，此功能會自動將其轉換為 Prism.js 格式。

## 支援的語言

此功能使用 Prism.js 的自動載入器，支援超過 200 種程式語言，包括但不限於：

- HTML/XML (`markup`)
- CSS (`css`)
- JavaScript (`javascript`)
- PHP (`php`)
- Python (`python`)
- Java (`java`)
- C/C++ (`c`, `cpp`)
- SQL (`sql`)
- Bash (`bash`)
- Markdown (`markdown`)

完整語言列表請參考 [Prism.js 官方網站](https://prismjs.com/#supported-languages)。

## 本地備份

為確保穩定性，功能內建了 CDN 失敗時的本地備份機制。如需使用此功能，請在主題目錄下創建以下結構：

```
your-theme/
  ├── assets/
  │   └── js/
  │       ├── prism.min.js
  │       ├── prism-line-numbers.min.js
  │       ├── prism-toolbar.min.js
  │       ├── prism-copy-to-clipboard.min.js
  │       ├── prism-autoloader.min.js
  │       └── prism-components/ (放置各語言組件)
```

## 自訂樣式

此功能已內建美觀的樣式，但您也可以在主題的 `style.css` 中覆蓋這些樣式以符合您的網站設計。

## 版本資訊

- 版本：1.0.0
- 發布日期：2025-03-24
- 需求：WordPress 5.0+
- 授權：GPL v2 或更高版本

## 作者

由 Kenming Wang, 使用 Claude 3.7 Sonnet 開發

---

此功能檔案旨在為您的 WordPress 主題添加美觀且實用的程式碼高亮功能，無需安裝額外的外掛。