# WordPress 自訂功能集合

這個資料夾包含了各種為 WordPress 網站開發的自訂功能模組，每個功能都獨立封裝，便於維護和重用。

## 功能模組列表

| 功能名稱 | 說明 | 版本 | 最後更新 |
|---------|------|-----|---------|
| [Prism 語法高亮](./wp-prism-syntax-highlighter/) | 為文章中的程式碼區塊提供語法高亮功能 | 1.0.2 | 2025-03-25 |

## 使用方法

1. 將 `wp-custom-functions` 資料夾上傳到您的 WordPress 主題目錄
2. 在主題的 `functions.php` 中添加以下程式碼：

## 新增功能模組

要新增功能模組，請遵循以下步驟：

1. 在 `wp-custom-functions` 目錄下創建新的資料夾，命名格式為 `wp-[功能名稱]`
2. 在資料夾中創建主要 PHP 檔案和 README.md 說明文件
3. 在主 README.md 中更新功能列表
4. 在主題的 `functions.php` 中添加對應的 require_once 語句，範例如下：

```php
// 添加新的功能模組 (例如: wp-prism-syntax-highlighter)
require_once $custom_functions_dir . 'wp-prism-syntax-highlighter/prism-syntax-highlighting.php';
```

## 作者

**開發者：** [Kenming Wang]  
**網站：** [https://www.kenming.idv.tw]  
**Email：** [kenming.wang@gmail.com]  
**GitHub：** [kenming](https://github.com/kenming)

## 授權

MIT License

Copyright (c) 2025 [Kenming Wang]
