# Multi Languages Config

The application supports a multi-language configuration to cater to diverse user bases. The language settings must be enabled in the `.env` file to utilize this functionality. The following environment variables should be configured:

```bash
XLANG_ACTIVE=true
XLANG_MAIN=fa
```

- **XLANG_ACTIVE**: This setting must be set to `true` to enable multi-language support within the application.
- **XLANG_MAIN**: This specifies the main language of the application, in this case, Persian (`fa`).

## xlangs Table

The `xlangs` table stores essential information about each supported language in the application. Its structure includes:

### Fields

- **id**:
    - A unique identifier for each language entry. This number is automatically generated and used as the primary key.

- **name**:
    - A string field that describes the name of the language (e.g., "English", "فارسی").

- **tag**:
    - A unique string field representing the language tag (e.g., `en`, `fa`). This tag is used for programmatic identification of the language.

- **rtl**:
    - A boolean field that indicates whether the language is right-to-left (true) or left-to-right (false). This is particularly relevant for languages like Persian or Arabic.

- **is_default**:
    - A boolean field to indicate if the language is the default language of the application. This should align with `XLANG_MAIN`, ensuring that the specified main language is correctly marked.

- **img**:
    - An optional string field that can store the URL/path to a flag image representing the language, which can be displayed in the UI for language selection.

- **emoji**:
    - An optional string field that can hold an emoji representation of the language, enhancing visual appeal and user experience.

- **sort**:
    - A tiny integer field to define the order in which languages are displayed in listings, allowing customization of the language selection interface.

## Additional Features

The application also integrates artificial intelligence for translation purposes. You can leverage an API to translate the content of the website, ensuring that users can access information in their preferred language.

When a new language is added by the administrator, a corresponding JSON file must be created. The text in this file should be translated using AI or manually to ensure consistency and accuracy across the application. This streamlined approach facilitates quick integration of new languages while maintaining high-quality translations.

---

This document outlines the multi-language configuration of the application, detailing both the configuration requirements and the structure of the `xlangs` table. It emphasizes the importance of supporting multiple languages and the functionalities offered by AI translation capabilities.
