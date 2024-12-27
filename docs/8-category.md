# Category Model

The `Category` model is used to categorize products within your application. This model allows for a structured classification system where you can create parent and child categories, enabling a nested hierarchy for better organization of your products.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each category. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** Text
- **Description:** The name of the category. This is the title that will be displayed to users, indicating the type of products contained within.

### 3. `slug`
- **Type:** String (Max Length: 128)
- **Description:** A URL-friendly version of the category name. It must be unique to each category and is used in web addresses to identify the category without using special characters or spaces.

### 4. `subtitle`
- **Type:** Text (Nullable)
- **Description:** A secondary title providing additional context about the category. This field is optional and can be left empty.

### 5. `icon`
- **Type:** String (Nullable)
- **Description:** A link or path to an icon representing the category. This could be an image or an icon file that visually represents the type of products in the category. This field is optional.

### 6. `description`
- **Type:** Text (Nullable)
- **Description:** A detailed explanation of the category, including information about the products it contains. This field can help users understand what to expect from the category and is optional.

### 7. `sort`
- **Type:** Integer
- **Description:** A numeric value that determines the display order of the category in lists. Categories with lower numbers will appear first. The default value is `0`.

### 8. `image`
- **Type:** String (Max Length: 2048) (Nullable)
- **Description:** A link to a main image for the category. This image represents the category visually. It’s optional and can be left empty.

### 9. `svg`
- **Type:** String (Max Length: 2048) (Nullable)
- **Description:** A link to an SVG (Scalable Vector Graphics) file that can be used for more sophisticated and customizable graphics related to the category. This field is optional and provides a way for users to include vector images.

### 10. `bg`
- **Type:** String (Max Length: 2048) (Nullable)
- **Description:** A link to a background image for the category. This can be used as a design element in the category's layout. This field is optional.

### 11. `parent_id`
- **Type:** Unsigned Integer (Nullable)
- **Description:** This field indicates the ID of the parent category if this category is a sub-category (nested). If a category does not have a parent, this field can be null. This allows for the creation of nested categories.

### 12. `theme`
- **Type:** JSON (Nullable)
- **Description:** This field allows for customization of the category’s theme. Various settings related to the appearance and layout of the category can be stored in JSON format. This field is optional.

### 13. `canonical`
- **Type:** Text (Nullable)
- **Description:** This field is used for SEO (Search Engine Optimization) purposes. It helps in transferring the search engine authority of the category to another page, enhancing the SEO potential of that category. This is particularly useful for managing duplicate content.

### 14. `hide`
- **Type:** Boolean
- **Description:** This field is used to hide the category in the site menu. Essentially, if this option is set to `false`, the category will be displayed as a submenu in the menu. However, if it is set to `true`, it will be hidden from display. The default value is `false`.

---
By utilizing this `Category` model, you can effectively organize your product categories in a structured way, enhancing user experience and improving SEO, while offering flexibility with images and icons.
