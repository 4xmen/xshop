# Post Model

The `Post` model is designed to represent articles or blog posts within your application. It supports rich content management, allowing users to create and organize written content effectively.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each post. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** Text
- **Description:** The title of the post. This is a descriptive heading that will be displayed to users and is crucial for attracting readers.

### 3. `slug`
- **Type:** String
- **Description:** A URL-friendly version of the post title. It must be unique for each post and is used in web addresses to identify the post without using special characters or spaces.

### 4. `subtitle`
- **Type:** Text
- **Description:** A secondary heading that provides additional context about the post. This field is typically used to give a brief overview or highlight aspects of the content.

### 5. `body`
- **Type:** Text
- **Description:** The main content of the post. This is where the detailed text, images, and other media go, forming the bulk of the article.

### 6. `group_id`
- **Type:** Unsigned Big Integer
- **Description:** This field indicates the ID of the group to which the post belongs. It helps in categorizing posts within specific groups for better organizational structure.

### 7. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** This field stores the ID of the user who created the post. It links the post to its author, allowing for user management and attribution.

### 8. `status`
- **Type:** Unsigned Tiny Integer
- **Description:** This field indicates the status of the post (e.g., draft, published, archived). The default value is `0`, typically representing a draft.

### 9. `view`
- **Type:** Unsigned Integer
- **Description:** A numeric counter that tracks the number of views the post has received. The default value is `0`.

### 10. `is_pinned`
- **Type:** Boolean
- **Description:** This field indicates whether the post is pinned to the top of the list. If true, it will be prominently displayed, making it more visible. The default value is `0`.

### 11. `hash`
- **Type:** String (Max Length: 14)
- **Description:** A unique hash string for the post that can be used for quick retrieval or identification purposes. This field is unique for each post.

### 12. `like`
- **Type:** Unsigned Integer
- **Description:** A counter that tracks the number of likes the post has received. The default value is `0`, meaning no likes yet.

### 13. `dislike`
- **Type:** Unsigned Integer
- **Description:** A counter that tracks the number of dislikes the post has received. Like the likes counter, the default is `0`.

### 14. `icon`
- **Type:** String (Max Length: 128) (Nullable)
- **Description:** A link or path to an icon that can represent the post. This is optional and can be used for better visual representation.

### 15. `table_of_contents`
- **Type:** Boolean
- **Description:** This field indicates whether the post has a table of contents. If true, a table of contents will be generated, making navigation easier. The default value is `0`.

### 16. `theme`
- **Type:** JSON (Nullable)
- **Description:** This field allows for customization of the post’s theme. Various settings related to the appearance and layout of the post can be stored in JSON format. This field is optional.

### 17. `canonical`
- **Type:** Text (Nullable)
- **Description:** This field is used for SEO (Search Engine Optimization) purposes. It helps search engines identify the main version of the content, aiding in avoiding duplicate content issues. This field is optional.

### 18. `keyword`
- **Type:** Text (Nullable)
- **Description:** This is a critical keyword for SEO purposes. It is recommended by the Laravel editor to enhance search visibility, similar to what tools like Yoast offer. This field helps users identify valuable keywords that can optimize their posts for search engines. It’s optional, but using relevant keywords can significantly improve discoverability.

---
By utilizing this `Post` model, users can create and manage blog posts or articles effectively, while also enabling SEO best practices to enhance visibility and reader engagement.