# Group Model

The `Group` model is designed to categorize content in your application. It allows for hierarchical organization, meaning you can create groups within groups, providing a nested structure. This feature is particularly useful for organizing posts, articles, or any content that requires classification.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each group. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** Text
- **Description:** The name of the group. This is a descriptive title that will be displayed to users.

### 3. `slug`
- **Type:** String (Max Length: 128)
- **Description:** A URL-friendly version of the group name. It should be unique for each group and is used in web addresses to identify the group without using special characters or spaces.

### 4. `subtitle`
- **Type:** Text (Nullable)
- **Description:** A secondary title that provides additional context about the group. This field is optional and can be left empty.

### 5. `description`
- **Type:** Text (Nullable)
- **Description:** A detailed description of the group. This may include information about the purpose of the group or what content can be found within it. This field is also optional.

### 6. `image`
- **Type:** String (Max Length: 2048) (Nullable)
- **Description:** A link to an image that represents the group. This could be a logo or any other visual representation. This field is optional.

### 7. `bg`
- **Type:** String (Max Length: 2048) (Nullable)
- **Description:** A link to a background image for the group. This image can be used as a design element in the group’s layout. This field is also optional.

### 8. `sort`
- **Type:** Integer
- **Description:** A numeric value that determines the display order of the group in a list. Groups with lower numbers will appear first. The default value is `0`.

### 9. `parent_id`
- **Type:** Unsigned Integer (Nullable)
- **Description:** This field indicates the ID of the parent group if the current group is a sub-group (nested). If a group doesn't have a parent, this field can be null. It allows for the creation of nested categories.

### 10. `theme`
- **Type:** JSON (Nullable)
- **Description:** This field allows for customization of the group’s theme. You can store various settings related to the group’s appearance and layout in JSON format. This is optional and can be left empty.

### 11. `canonical`
- **Type:** Text (Nullable)
- **Description:** This field is used for SEO (Search Engine Optimization) purposes. It helps in directing the search engine’s authority of a group to another page, enhancing the SEO power of that group. This is particularly useful for managing duplicate content.


### 12. `hide`
- **Type:** Boolean
- **Description:** This field is used to hide the category in the site menu. Essentially, if this option is set to `false`, the group will be displayed as a submenu in the menu. However, 
- if it is set to `true`, it will be hidden from display.  The default value is `false`.

---
By utilizing this `Group` model, you can effectively organize your content in a way that is user-friendly and conducive to SEO, providing a better experience for your users.
