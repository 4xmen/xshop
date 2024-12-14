# State and City Models

The `State` and `City` models are designed to manage geographical data within your application. These models allow for the organization of locations, enabling functionalities related to regional management of users, services, or logistics.

## State Model

The `State` model represents a geographical region within a country and serves as a parent for the `City` model.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each state. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** Text
- **Description:** The name of the state. This field is required.

### 3. `lat`
- **Type:** Double
- **Description:** The latitude coordinate of the state, which can be useful for mapping and geographical calculations.

### 4. `lng`
- **Type:** Double
- **Description:** The longitude coordinate of the state, complementing the latitude for precise geographical representation.

### 5. `country`
- **Type:** Text
- **Description:** The name of the country that the state belongs to. This field is essential for understanding the geographical context of the state.

## Summary

The `State` model provides a structured representation of states within a country, including essential geographical coordinates and country affiliation.

---

## City Model

The `City` model represents urban areas within a state and establishes a relationship with the `State` model.

### Fields Description

### 1. `id`
- **Type:** Integer
- **Description:** A unique identifier for each city. This field is automatically generated and serves as the primary key for the model.

### 2. `name`
- **Type:** Text
- **Description:** The name of the city. This field is required.

### 3. `lat`
- **Type:** Double (Nullable)
- **Description:** The latitude coordinate of the city, which can be useful for mapping and location services.

### 4. `lng`
- **Type:** Double (Nullable)
- **Description:** The longitude coordinate of the city, providing necessary details for accurate location mapping.

### 5. `state_id`
- **Type:** Unsigned Big Integer
- **Description:** The ID of the state to which this city belongs. This establishes a foreign key relationship with the `State` model, linking cities to their respective states.

## Summary

The `City` model complements the `State` model by providing a detailed structure for managing cities within specific states. It allows for clear organization of geographical data, essential for functionalities requiring location-based services.

---

### Relationship Between State and City

- Each `State` can have multiple associated `City` records, establishing a one-to-many relationship.
- The `City` model includes a foreign key (`state_id`) that links each city to its respective state.

By integrating the `State` and `City` models, your application can effectively manage geographical data, facilitating the organization of regional information for users and services.