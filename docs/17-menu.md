# Menu and Item Models

The `Menu` and `Item` models work together to create a flexible navigation structure for your application. This setup allows users to define menus and populate them with items that can either link to dynamic content (e.g., categories) or direct URLs.

## Menu Model

The `Menu` model represents a collection of `Item` entries that are displayed to users as navigation options.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each menu. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** String
- **Description:** The name of the menu (e.g., "Main Menu", "Footer Menu"). This field is required.

### 3. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who created or owns this menu, establishing a foreign key relationship with the `User` model.

### 4. `softDeletes`
- **Type:** Timestamp
- **Description:** A field used for soft deleting menus, allowing you to retain records without permanently removing them. This provides the ability to restore deleted menus.

### 5. `timestamps`
- **Type:** Timestamps
- **Description:** Automatically managed fields for tracking when the menu was created and last updated.

## Summary

The `Menu` model serves as a foundational component for organizing navigation within your application, linking users to various items.

---

## Item Model

The `Item` model represents individual entries within a `Menu`, which can either link to a specific content type (like a `Category`) or redirect to a specified URL.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each item. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text
- **Description:** The title of the item (e.g., "Products", "Contact Us"). This field is required.

### 3. `menuable_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** This field represents the ID of the associated model that the item links to (like a `Category`). It's set to `NULL` if linking directly via a URL.

### 4. `menuable_type`
- **Type:** String (Nullable)
- **Description:** This enables polymorphic behavior, indicating the type of model the item references (e.g., `Category`). It's used in conjunction with `menuable_id`.

### 5. `kind`
- **Type:** String (Nullable)
- **Description:** Specifies the nature of the item; can be `module` if it links to another model (e.g., category) or `direct` for a direct URL link.

### 6. `meta`
- **Type:** Text (Nullable)
- **Description:** Allows for storing additional metadata related to the item, useful for links or dynamic behaviors.

### 7. `parent`
- **Type:** Unsigned Integer (Nullable)
- **Description:** Represents the ID of the parent item if this item is a sub-item, enabling hierarchical item structures. Default is `NULL`.

### 8. `sort`
- **Type:** Unsigned Integer
- **Description:** A numeric value used to control the display order of menu items. Lower values appear first—the default is `0`.

### 9. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who created or owns this item, establishing a foreign key relationship with the `User` model.

### 10. `menu_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the associated menu to which this item belongs, establishing a foreign key relationship with the `Menu` model.

### Foreign Key Relationships

- **user_id:** References the `User` model.
- **menu_id:** References the `Menu` model.

## Summary

The `Item` model structures individual components of a menu, allowing for flexibility in navigation and direct linking, ultimately enhancing the user experience within the application.

---

### Relationships Overview

- Each `Menu` can contain multiple `Item` entries.
- Each `Item` can link to a `Category` or have a direct URL, as defined by `menuable_id`, `menuable_type`, and `kind`.
- Items can be organized hierarchically through the `parent` field.

By utilizing both the `Menu` and `Item` models, your application can achieve dynamic and organized navigation, catering to various user needs.