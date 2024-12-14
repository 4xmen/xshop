# Advertise

The `Adv` model represents advertisements displayed within your application. These ads can promote products, services, or special offers, and have specific functionalities based on the number of clicks they receive.

## Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each advertisement. This field is automatically generated and serves as the primary key for the model.

### 2. `title`
- **Type:** String
- **Description:** The title of the advertisement, used to describe its content or purpose. This field is required.

### 3. `expire`
- **Type:** Date
- **Description:** The expiration date of the advertisement. Once the date is reached, the ad may no longer be displayed, depending on the application logic.

### 4. `image`
- **Type:** String
- **Description:** The URL or path to the image associated with the advertisement. This field is required, as it provides the visual context for the ad.

### 5. `max_click`
- **Type:** Unsigned Integer
- **Description:** The maximum number of clicks allowed for the advertisement. If this value is reached, the advertisement will no longer be shown. A value of `0` means there is no maximum limit, allowing the ad to be displayed indefinitely.

### 6. `click`
- **Type:** Unsigned Integer
- **Description:** The current number of clicks received by the advertisement. This value is incremented each time the ad is clicked. It allows the application to track engagement.

### 7. `status`
- **Type:** Boolean
- **Description:** Indicates the active status of the advertisement. A value of `0` means the ad is inactive and should not be displayed, while a value of `1` signifies that it is active.

### 8. `link`
- **Type:** String
- **Description:** The URL that users will be redirected to when they click the advertisement. This field is required, as it provides the target destination for clicks.

### 9. `user_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the user who created or owns this advertisement, establishing a foreign key relationship with the `User` model.

## Summary

The `Adv` model is designed to manage advertisement content within your application, providing essential fields to control display, engagement, and limitations based on user interactions. It allows for dynamic promotion while ensuring efficient tracking of user engagement through click counts.

---

### Functionality Overview

- **Display Logic:** An advertisement will be displayed as long as its `max_click` limit is not reached, or if `max_click` is set to `0`.
- **Engagement Tracking:** The application can track how many times the advertisement has been clicked and can adjust its status accordingly.

This model enables effective advertising management, supporting both textual and visual content to enhance your application's marketing efforts.