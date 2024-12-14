# GFX (Graphical Interface) Configuration

The `gfxes` table is a vital component of the website's graphical interface settings. It stores various design parameters that determine how the site looks and feels. Users can think of these settings as the foundational elements that shape their experience when using the site.

## GFX Table

### Fields

- **id**:
    - A unique identifier for each design setting. This number helps the system manage and reference each setting efficiently.

- **key**:
    - A unique string that represents a specific design aspect (e.g., background color). This is how the system recognizes and uses the setting.

- **label**:
    - A user-friendly name for the design setting. This is what you will see as a description and helps you understand what each setting controls (e.g., "Background Color").

- **system**:
    - A boolean value indicating whether the setting is part of the core system design. A value of `1` means that it is a predefined system setting, while `0` would mean it is user-defined or customizable.

- **value**:
    - A long text field that contains the actual value for the setting. This could be a color code, font style, or other relevant design information.

### Design Parameters

Here are some of the key design settings stored in the `gfxes` table, along with their explanations:

- **Background Color (`background`)**:
    - This setting defines the overall background color of the website, providing a base tone for all other design elements. For example, a light gray color (`#eeeeee`) can create a soft and inviting atmosphere.

- **Primary Color (`primary`)**:
    - This is the main color used for buttons, links, and other significant elements throughout the site. It is often the color that stands out the most, helping to guide users' attention. An example primary color would be a vibrant teal (`#03b2b5`).

- **Secondary Color (`secondary`)**:
    - This color complements the primary color and is used for secondary actions or highlights. It can provide additional visual interest, such as a shade of blue (`#0064c2`).

- **Text Color (`text`)**:
    - This setting determines the color of the text displayed on the site. For readability, a dark color, such as black (`#111111`), is usually chosen.

- **Theme Mode (`dark`)**:
    - This setting indicates whether the website should use a light or dark theme. A value of `0` may imply a light-themed interface, while `1` could be used for a darker background.

- **Border Radius (`border-radius`)**:
    - This controls the roundness of the corners for elements such as buttons and cards. A value like `7px` gives a soft, rounded appearance.

- **Shadow (`shadow`)**:
    - This setting adds depth to elements by applying a shadow effect. For instance, a shadow value of `2px 2px 4px #777777` can create a subtle 3D look, enhancing the visual hierarchy.

- **Container (`container`)**:
    - This defines the layout structure of the main content area. The value `container` refers to a predefined layout style used to improve spacing and alignment.

- **Font (`font`)**:
    - This specifies the font style used throughout the website. Using a font like `Vazir` can help maintain consistency and improve the overall aesthetics of the text.

---

By managing these graphical settings, the website's design can be customized to create a unique and engaging user experience. Users should appreciate how these elements combine to create an inviting and recognizable brand identity, enhancing overall satisfaction and usability.