# Product Model

The `Product` model is designed to represent items for sale within your application. It includes essential fields for describing products, managing their inventory, and associating them with multiple categories.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each product. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** Text
- **Description:** The name of the product. This title is what users will see when browsing products.

### 3. `slug`
- **Type:** String
- **Description:** A unique URL-friendly version of the product name that can be used in web addresses. This field is indexed to improve lookup performance.

### 4. `description`
- **Type:** LongText (Nullable)
- **Description:** A detailed description of the product. This text provides users with comprehensive information about the features and specifications.

### 5. `table`
- **Type:** LongText (Nullable)
- **Description:** This field can be used to store tabular data about the product, such as specifications or comparisons.

### 6. `excerpt`
- **Type:** Text (Nullable)
- **Description:** A brief summary of the product. This will appear on the product page under the product name and is useful for SEO purposes.

### 7. `sku`
- **Type:** String (Nullable, Unique)
- **Description:** SKU refers to a Stock-keeping Unit, which is a unique identifier for each distinct product. This helps in inventory management.

### 8. `virtual`
- **Type:** Boolean (Nullable)
- **Description:** This field indicates whether the product is a non-physical item (e.g., a service) that does not require shipping. The default value is `false`.

### 9. `downloadable`
- **Type:** Boolean (Nullable)
- **Description:** Indicates if purchasing the product grants the customer access to a downloadable file, such as software. The default value is `false`.

### 10. `price`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The selling price of the product. This field is indexed to improve lookup performance.

### 11. `buy_price`
- **Type:** Unsigned Big Integer
- **Description:** The cost price of the product, which is used to calculate the gross margin. The default value is `0`.

### 12. `category_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the main category to which this product belongs.

### 13. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who created or owns the product.

### 14. `on_sale`
- **Type:** Boolean (Nullable)
- **Description:** This field indicates whether the product is currently on sale. The default value is `true`.

### 15. `stock_quantity`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The number of items available in stock for the product. The default is `0`.

### 16. `stock_status`
- **Type:** Enum
- **Description:** This field represents the availability status of the product and can take one of the following values: 'IN_STOCK', 'OUT_STOCK', or 'BACK_ORDER'. The default value is set to `IN_STOCK`.

### 17. `rating_count`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The number of ratings given to the product. The default value is `0`.

### 18. `average_rating`
- **Type:** Decimal (3, 2) (Unsigned, Nullable)
- **Description:** The average rating of the product, calculated from the ratings received. The default is `0.00`.

### 19. `status`
- **Type:** Unsigned Tiny Integer
- **Description:** This field indicates the current status of the product. The default value is `0`.

### 20. `view`
- **Type:** Unsigned Big Integer
- **Description:** This field tracks the number of times the product has been viewed. The default value is `0`.

### 21. `sell`
- **Type:** Unsigned Big Integer
- **Description:** This field tracks the total number of sales for this product. The default is `0`.

### 22. `image_index`
- **Type:** Unsigned Tiny Integer
- **Description:** This field is used to specify which image to display for the product when there are multiple images associated.

### 23. `theme`
- **Type:** JSON (Nullable)
- **Description:** This field allows for customization of the product’s theme. Various design settings can be stored in JSON format. This field is optional.

### 24. `canonical`
- **Type:** Text (Nullable)
- **Description:** This field is used for SEO purposes, to indicate the canonical URL for the product to prevent duplicate content issues.

### 25. `keyword`
- **Type:** Text (Nullable)
- **Description:** A crucial keyword for SEO purposes, aiding in the product's search visibility. It is recommended to use relevant keywords to optimize the product for search engines.

## Intermediary Table: `category_product`

The `category_product` table serves as a many-to-many relationship bridge between products and categories. This means that a single product can belong to multiple categories, and a single category can have multiple products associated with it. The table consists of two foreign keys: `category_id`, which references the `id` field in the `categories` table, and `product_id`, which references the `id` field in the `products` table. Both foreign keys are set to delete the associated records from this table if either the product or category is deleted, ensuring data integrity.

---
By utilizing the `Product` model in conjunction with the `category_product` intermediary table, you can effectively manage and organize your products while allowing for flexibility in categorization.