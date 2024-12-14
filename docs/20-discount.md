# Discount Model

The `Discount` model is designed to manage discounts applied to products or for general usage within your application. It supports various types of discounts, including specific product discounts and overarching discounts applicable to multiple products.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each discount. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text (Nullable)
- **Description:** The title of the discount. This field provides a brief name or reference for the discount, helping users quickly understand its purpose.

### 3. `body`
- **Type:** LongText (Nullable)
- **Description:** A detailed description of the discount. This text can include terms, conditions, or specifics regarding how the discount is applied.

### 4. `product_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the product to which the discount applies. If this field is null, it indicates that the discount applies generally to multiple products rather than a specific one.

### 5. `type`
- **Type:** Enum
- **Description:** This field specifies the type of discount being applied. It can include values like percentage discounts, fixed amount discounts, or special promotional discounts, as defined in `App\Models\Discount::$doscount_type`.

### 6. `code`
- **Type:** String (Max Length: 100) (Nullable)
- **Description:** A unique code that can be used to apply the discount at checkout. This code may be required for specific discounts and is optional for general discounts. The default value is `null`.

### 7. `amount`
- **Type:** Unsigned Big Integer
- **Description:** The value of the discount, which can represent either a fixed amount (e.g., $20 off) or a percentage (e.g., 20%) depending on the `type` of discount selected. This field is mandatory.

### 8. `expire`
- **Type:** DateTime (Nullable, Default: null)
- **Description:** This field represents the expiration date and time for the discount. If set, the discount will no longer be valid after this date. It's optional, and discounts may be permanent if this field is left null.

## Summary

The `Discount` model provides flexible discount management, allowing users to create discounts that can be specific to particular products or universally applicable. It accommodates various discount types with the option for unique codes and expiration dates, ensuring versatility in promotional strategies.

---
By implementing the `Discount` model, you can effectively manage discounts across your e-commerce application, targeting specific products or creating larger promotional campaigns easily.