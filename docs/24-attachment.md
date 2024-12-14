# Attachment Model

The `Attachment` model is designed to manage files and documents associated with your application. These attachments can be linked to various content types (such as posts, products, etc.) or stand alone, providing users with downloadable resources.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each attachment. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text
- **Description:** The title of the attachment, offering a brief description of its content. This field is required.

### 3. `slug`
- **Type:** String (Unique)
- **Description:** A unique identifier used in the URL, which helps to easily reference the attachment. This field must be unique across all attachments.

### 4. `subtitle`
- **Type:** Text
- **Description:** A secondary description that provides additional context about the attachment. This field is required.

### 5. `body`
- **Type:** Text
- **Description:** The main content associated with the attachment, which can provide more detailed information or instructions related to the attachment.

### 6. `file`
- **Type:** String (Nullable, Max Length: 2048)
- **Description:** The path or URL to the actual file for download. This field is optional, allowing for attachments without a file.

### 7. `ext`
- **Type:** String (Nullable)
- **Description:** The file extension of the attachment (e.g., .pdf, .docx). This field is optional and can be used to determine the file type.

### 8. `downloads`
- **Type:** Unsigned Big Integer
- **Description:** The total number of times the attachment has been downloaded. The default value is `0`, and it can be used for tracking engagement.

### 9. `is_fillable`
- **Type:** Boolean
- **Description:** This field indicates whether the attachment should be shown in the main attachments list. A value of `false` means the attachment will not be visible in the general attachment list, and will only be displayed within related content (like a post). The default value is `true`, allowing visibility by default.

### 10. `size`
- **Type:** Unsigned Big Integer
- **Description:** The size (in bytes) of the attachment file. The default value is `0`.

### 11. `attachable`
- **Type:** Morph (Nullable)
- **Description:** This polymorphic relation allows the attachment to belong to various models (e.g., posts, products). If an attachment is not linked to any model, this field can be null.

## Summary

The `Attachment` model serves as a versatile tool for managing downloadable files within your application, enabling users to access additional resources related to specific content. It provides detailed tracking of downloads and allows for selective visibility based on the `is_fillable` attribute.

---

### Functionality Overview

- **Conditional Listing:** If `is_fillable` is set to `false`, the attachment will not appear in the general attachment listing; instead, it will be accessible only through the related content.
- **Extensibility:** The `attachable` field supports polymorphic relationships, allowing flexibility in linking attachments to various content types within the application.

This model is essential for managing attachments efficiently, ensuring a seamless user experience when accessing additional resources.