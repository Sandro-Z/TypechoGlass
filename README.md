# AeroGlass for Typecho

TypechoGlass 是一套面向 Typecho 1.3 的苹果风格主题，强调毛玻璃、高斯模糊、纯色、亮暗双模式和高扩展性。

演示站点：https://sandroz.com

## 主题能力

- 苹果风格 glassmorphism 视觉
- 亮色 / 暗色 / 跟随系统
- 首页、归档、文章、页面、404、友情链接页、时间归档页
- Typecho 后台自定义 Logo、社交链接、额外导航、背景图、强调色、分页数量
- 首页、分类、标签、搜索分页
- Links Plus 友链插件适配
- 文章封面、自定义副标题、推荐标记、关闭目录选项

## 安装

1. `cd /path/to/typecho/data/themes&&git clone https://github.com/Sandro-Z/TypechoGlass.git`(请将`/path/to/typecho/data`改为你的typecho配置文件位置)
2. 后台启用 `TypechoGlass`
3. 按需在主题设置里填写 Logo、社交链接、背景图等
4. 友情链接页可创建一个独立页面并选择 `友情链接页` 模板
5. 若使用 Links Plus，可一并复制 `usr/plugins/Links/templates/aeroglass` 到插件模板目录

## 友情链接页的两种用法

### 用法一：Links Plus 插件
在页面正文中使用插件提供的 `<links>...</links>` 或插件输出模板，本主题会自动套用玻璃风格。


### 用法二：页面自定义字段
在友情链接页的 `linksJson` 字段里填写：

```json
[
  {
    "name": "Typecho",
    "url": "https://typecho.org",
    "description": "Typecho 官方站点",
    "image": ""
  }
]
```

## 推荐页面

- `友情链接页`：使用 `page-links.php`
- `时间归档页`：使用 `page-archive.php`
