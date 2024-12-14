# Invoice, Order, and Quantity Models

The `Invoice`, `Order`, and `Quantity` models work together to facilitate order processing, invoicing, and inventory management within your application. These models enable the recording of customer transactions, tracking of orders, and management of stock quantities.

## Invoice Model

The `Invoice` model represents a record of a completed transaction between the customer and the business, detailing the items purchased and the associated costs.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each invoice. This field is automatically generated and serves as the primary key for the model.

### 2. `customer_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the customer associated with this invoice. This establishes a foreign key relationship with the `Customer` model.

### 3. `status`
- **Type:** Enum
- **Description:** The current status of the invoice, defined in the `Invoice` model's class variable `$invoiceStatus`. The default is "PENDING".

### 4. `total_price`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The total amount due on the invoice. The default value is `0`, and this field can be `NULL` until calculated.

### 5. `count`
- **Type:** Integer (Nullable)
- **Description:** The total number of items included in the invoice. The default value is `0`.

### 6. `meta`
- **Type:** JSON (Nullable)
- **Description:** Additional metadata related to the invoice, useful for storing extra information in JSON format.

### 7. `discount_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of any discount applied to the invoice. This establishes a foreign key relationship with the `Discount` model.

### 8. `desc`
- **Type:** Text (Nullable)
- **Description:** A description or notes about the invoice. This field is optional.

### 9. `hash`
- **Type:** String (Max Length: 32) (Nullable, Unique)
- **Description:** A unique hash identifier for the invoice, used for tracking and referencing.

### 10. `transport_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the transport method used for the invoice. This establishes a foreign key relationship with the `Transport` model.

### 11. `transport_price`
- **Type:** Unsigned Big Integer
- **Description:** The cost associated with the transport method. Default value is `0`.

### 12. `credit_price`
- **Type:** Unsigned Big Integer
- **Description:** The amount of credit applied to this invoice. Default value is `0`.

### 13. `reserve`
- **Type:** Boolean
- **Description:** Indicates whether the items on the invoice are reserved. Default value is `0`.

### 14. `invoice_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** This field can be used for linking to other invoices, creating relationships between them.

### 15. `address_alt`
- **Type:** String (Nullable)
- **Description:** An alternative address for delivery or billing purposes.

### 16. `address_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the associated address for delivery, establishing a foreign key relationship with the `Address` model.

### 17. `tracking_code`
- **Type:** String (Nullable)
- **Description:** A code used for tracking shipment of the order associated with the invoice.

## Summary

The `Invoice` model provides a structured representation of a financial transaction, including customer details, status, payment information, and associated products.

---

## Order Model

The `Order` model represents a specific item or service being purchased within an invoice, linking the invoice to products.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each order. This field is automatically generated and serves as the primary key for the model.

### 2. `invoice_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the invoice associated with this order. Establishes a foreign key relationship with the `Invoice` model.

### 3. `product_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the product being ordered. Establishes a foreign key relationship with the `Product` model.

### 4. `quantity_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the specific quantity or stock item. This is optional and can be used for stock management.

### 5. `count`
- **Type:** Integer (Nullable)
- **Description:** The quantity of the product being ordered. The default value is `1`.

### 6. `price_total`
- **Type:** Unsigned Integer
- **Description:** The total price for the ordered product, typically calculated as `quantity * unit price`.

### 7. `data`
- **Type:** JSON (Nullable)
- **Description:** This field allows for flexible storage of additional information related to the order, in JSON format.

## Summary

The `Order` model provides a detailed structure for managing individual items within an invoice, allowing for clear tracking of purchases.

---

## Quantity Model

The `Quantity` model is designed to manage inventory levels for specific products, allowing for precise tracking of stock.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each quantity record. This field is automatically generated and serves as the primary key for the model.

### 2. `product_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the product associated with this quantity record. Establishes a foreign key relationship with the `Product` model.

### 3. `count`
- **Type:** Unsigned Integer
- **Description:** The current stock level of the product. The default value is `0`.

### 4. `price`
- **Type:** Unsigned Big Integer
- **Description:** The price of the product associated with this quantity record. The default value is `0`.

### 5. `image`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of an associated image for the product. This field is optional.

### 6. `data`
- **Type:** Long Text (Nullable)
- **Description:** Additional data related to the inventory record, allowing for flexible storage of information.

## Summary

The `Quantity` model allows for effective inventory management by tracking stock levels, prices, and additional information related to specific products.

---

### Relationships Overview

- The `Invoice` model is linked to multiple `Order` records through the `invoice_id`.
- Each `Order` can reference a specific `Product` and potentially a `Quantity`.
- The `Quantity` model is related to `Products` to accurately reflect inventory levels.

By integrating the `Invoice`, `Order`, and `Quantity` models, your application can handle full e-commerce functionalities, including invoicing, order tracking, and stock management.