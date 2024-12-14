# Gallery Model

The `Gallery` model is designed to manage collections of images in your application. Each gallery can have a unique title, description, and a set of images associated with it.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each gallery. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text
- **Description:** The title of the gallery. This field provides a name for the gallery, helping users quickly identify its content.

### 3. `slug`
- **Type:** String (Unique)
- **Description:** A URL-friendly version of the gallery title, used for web addressing. This field is unique and helps in SEO optimization.

### 4. `description`
- **Type:** Text (Nullable)
- **Description:** A detailed description of the gallery. This text can provide context or information about the images contained within the gallery.

### 5. `view`
- **Type:** Unsigned Tiny Integer
- **Description:** This field tracks the number of times the gallery has been viewed. The default value is `0`.

### 6. `status`
- **Type:** Unsigned Tiny Integer
- **Description:** This field indicates the current status of the gallery (e.g., active, inactive). The default value is `0`.

### 7. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who created or owns the gallery. This establishes a relationship between the gallery and its creator.

## Image Model

The `Image` model represents individual images associated with a gallery. Multiple images can belong to a single gallery, allowing for dynamic and rich media presentations.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each image. This field is automatically generated and serves as the primary key for the model.

### 2. `gallery_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the gallery to which this image belongs. This establishes a relationship between images and the corresponding gallery.

### 3. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who uploaded or owns the image.

### 4. `title`
- **Type:** Text (Nullable)
- **Description:** An optional title for the image. This field can provide additional context or description of the image.

### 5. `sort`
- **Type:** Unsigned Integer
- **Description:** This field represents the order in which images are displayed within the gallery. The default value is `0`.

### 6. Timestamps
- **Description:** This model will automatically manage `created_at` and `updated_at` timestamps for tracking when images are added or modified.

### Foreign Key Constraints
- The `user_id` in the `images` table references the `id` field in the `users` table to link images to their respective users.
- The `gallery_id` in the `images` table references the `id` field in the `galleries` table to link images to their corresponding galleries.

## Summary

The `Gallery` and `Image` models work together to form a flexible and dynamic image management system. Galleries can contain multiple images, each with detailed information such as titles and sorting orders. This structure enhances user experience by allowing organized and visually appealing presentations of image collections.

---
By implementing this gallery system, you can create rich media experiences in your application, with easy management of images and their associations to galleries.