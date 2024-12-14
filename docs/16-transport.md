# Transport M~~odel~~

The `Transport` model represents the various shipping and delivery methods available for fulfilling customer orders. This model is essential for managing the logistics of order fulfillment, including associated costs and default settings for shipping options.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each transport method. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text
- **Description:** The name of the transport method (e.g., "Standard Shipping", "Express Delivery"). This field is required.

### 3. `description`
- **Type:** Text (Nullable)
- **Description:** A detailed description of the transport method, providing additional information to customers. This field is optional.

### 4. `sort`
- **Type:** Unsigned Integer
- **Description:** A numeric value used to determine the order in which transport methods are displayed to customers (e.g., lower numbers appear first). The default value is `0`.

### 5. `is_default`
- **Type:** Boolean
- **Description:** A flag indicating whether this transport method is the default option for customers. The default value is `0`, meaning it's not the default unless specified.

### 6. `price`
- **Type:** Unsigned Integer
- **Description:** The cost associated with using this transport method. The default value is `0`, allowing for free shipping options if necessary.

### 7. `icon`
- **Type:** String (Nullable)
- **Description:** A URL or path to an icon representing the transport method, which can be used in the user interface for better visual representation. This field is optional.

## Summary

The `Transport` model provides a structured approach to managing the various shipping options available to customers, helping to streamline the order fulfillment process and improving user experience by presenting clear, organized transport choices.

---

### Relationships Overview

While the `Transport` model primarily focuses on defining types of delivery methods, it typically establishes relationships with orders and invoices, allowing for seamless tracking of ordered items through their respective shipping methods.