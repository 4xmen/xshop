# Area & Theme Part

The `areas` table defines the different design environments available within the website. Each of these areas can contain specific components known as "theme parts," which are essentially the building blocks for various pages across the site.

## Areas Table

### Fields

- **id**:
    - A unique identifier for each area, allowing the system to reference and manage them effectively.

- **name**:
    - A string representing the name of the area, which must be unique to avoid confusion.

- **max**:
    - This tiny integer indicates the maximum number of allowed theme parts within this area. For instance, if the value is `1`, only one theme part can be assigned.

- **icon**:
    - An optional string for the icon associated with the area, which can be used for visual representation in the user interface.

- **valid_segments**:
    - A JSON field that specifies which segments from the website can load within this area. This ensures flexibility and specificity in the content shown.

- **preview**:
    - This optional string contains a link to a preview of the area, such as a route name (e.g., `client.welcome`), helping users visualize what the area will look like.

- **use_default**:
    - A boolean indicating whether to use the default header and footer for this area or to create custom versions. A value of `true` means that the default header and footer will be utilized.

- **sort**:
    - An integer determining the order in which this area is displayed relative to others.

## Parts Table

The `parts` table acts as a child of the `areas` table, defining the specific segments and their configurations within each area.

### Fields

- **id**:
    - A unique identifier for each part.

- **area_id**:
    - A foreign key linking the part to a specific area. This enables the system to group parts together logically.

- **segment**:
    - A string representing one of the allowed segments for the area. It defines what specific type of content is included in this part.

- **part**:
    - A string that indicates the specific theme part used in this segment, determining how the page will be rendered visually.

- **data**:
    - A JSON field that contains additional configuration and settings relevant to the theme part, such as customization options or parameters.

- **sort**:
    - An integer specifying the order of the part within its area, which can be adjusted based on user preference.

- **custom**:
    - An optional string that indicates whether this part is customized for a specific category, group, post, or another unique element.

## Understanding Areas and Theme Parts

The website consists of multiple areas, each of which a developer can configure through the control panel. In the control panel, developers have the ability to specify which theme parts should be included in each area. This provides flexibility and customization to the design of various pages on the site.

It's important to note that the options for managing these areas and theme parts are exclusively available for users with the developer role. This ensures that only authorized users can make changes that affect the overall structure and presentation of the website.