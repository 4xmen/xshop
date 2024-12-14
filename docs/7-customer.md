# Customer Model

The `Customer` model is designed to manage customer information in your application. It stores essential personal information and enables various functionalities related to customer accounts.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each customer. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** String (Max Length: 255) (Nullable)
- **Description:** The full name of the customer. This field is optional and can be left blank.

### 3. `email`
- **Type:** String (Unique) (Nullable)
- **Description:** The email address of the customer. This field must be unique and is used for authentication and communication purposes.

### 4. `email_verified_at`
- **Type:** Timestamp (Nullable)
- **Description:** This field stores the timestamp when the customer's email address was verified. It can be `NULL` until verified.

### 5. `password`
- **Type:** String (Nullable)
- **Description:** The customer's hashed password for authentication. This field is optional and can be set during account creation.

### 6. `mobile`
- **Type:** String (Max Length: 15) (Unique) (Nullable)
- **Description:** The mobile phone number of the customer. This field must be unique and is optional.

### 7. `dob`
- **Type:** Date (Nullable)
- **Description:** The date of birth of the customer. This field is optional and can be left blank.

### 8. `sms`
- **Type:** String (Max Length: 10) (Nullable)
- **Description:** This field stores the last authentication code sent via SMS for verification purposes.

### 9. `code`
- **Type:** String (Max Length: 10) (Nullable)
- **Description:** A field that can be used for various purposes, including managing verification codes or promotions.

### 10. `colleague`
- **Type:** Boolean
- **Description:** Indicates whether the customer is a colleague (true/false). The default value is `false`.

### 11. `description`
- **Type:** Text (Nullable)
- **Description:** Additional details about the customer, meant for administrative purposes.

### 12. `credit`
- **Type:** Big Integer
- **Description:** This field tracks the customer's credit balance within the system. It allows for dynamic credit management based on orders and refunds. The default value is `0`.

### 13. `sex`
- **Type:** Enum (Options: `MALE`, `FEMALE`) (Nullable)
- **Description:** The gender of the customer. This field is optional.

### 14. `height`
- **Type:** Integer (Nullable)
- **Description:** The height of the customer in centimeters. This field is optional.

### 15. `weight`
- **Type:** Decimal (Nullable)
- **Description:** The weight of the customer in kilograms. This field is optional.

### 16. `avatar`
- **Type:** String (Nullable)
- **Description:** The file path or URL to the customer's avatar image. This field is optional.

### 17. `card`
- **Type:** JSON (Nullable)
- **Description:** This field stores the customer's bank card number and related information in a JSON format. It is optional.

### 18. `rememberToken`
- **Type:** String
- **Description:** This field is used for "remember me" functionality during authentication, storing a token for persistent login.

## Summary

The `Customer` model provides a detailed and organized structure for managing customer information, including personal details, login credentials, and financial data. It supports functionalities such as credit management and SMS verification.

---

## Address Model

The `Address` model is designed to manage multiple addresses associated with each customer. It allows for the storage of detailed address information, including geographical coordinates and postal codes.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each address. This field is automatically generated and serves as the primary key for the model.

### 2. `address`
- **Type:** Text
- **Description:** The full address of the customer. This field is required and stores detailed address information.

### 3. `customer_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the customer associated with this address. This establishes a relationship between the `Address` and `Customer` models.

### 4. `lat`
- **Type:** Double (Nullable)
- **Description:** The latitude coordinate of the address, useful for map integrations. This field is optional.

### 5. `lng`
- **Type:** Double (Nullable)
- **Description:** The longitude coordinate of the address, useful for map integrations. This field is optional.

### 6. `state_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the state associated with the address. This field can be set to `NULL` if not applicable.

### 7. `city_id`
- **Type:** Unsigned Big Integer (Nullable)
- **Description:** The ID of the city associated with the address. This field can also be set to `NULL`.

### 8. `data`
- **Type:** JSON (Nullable)
- **Description:** This field can store any additional, custom data related to the address in JSON format, providing flexibility in data management.

### 9. `zip`
- **Type:** String (Nullable)
- **Description:** The postal code for the address. This field is optional and can be used for shipping and verification purposes.

## Summary

The `Address` model enhances the `Customer` model by allowing customers to store multiple addresses with detailed information. This setup supports various functionalities such as shipping and billing address management, which can be crucial for e-commerce applications.

---
By integrating the `Customer` and `Address` models into your application, you can establish comprehensive customer management, ensuring efficient handling of personal and logistical information.