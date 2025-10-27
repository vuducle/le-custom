# Quick Edit Meta Description

This feature adds a meta description field to the WordPress quick edit interface for pages, allowing easy editing of SEO meta descriptions with structured data support for subpages.

## Features

### Quick Edit Interface

- **Custom Page Title Field**: Override automatic title generation with custom titles
- **Meta Description Field**: Added to the WordPress quick edit interface for pages
- **Character Counter**: Real-time character count with limits (70 chars for title, 160 for description)
- **Fallback Logic**: Uses hero subtitle or default descriptions if no custom meta description is set
- **Column Display**: Shows meta descriptions in the pages list for easy overview

### Structured Data Support

- **Subpage Structured Data**: Automatically generates appropriate structured data for different page types
- **Contact Pages**: Enhanced with ContactPoint schema
- **Directions Pages**: Includes GeoCoordinates schema
- **Legal Pages**: Proper organization schema for imprint and privacy policy

### Smart Fallbacks

1. **Custom Meta Description**: First priority - manually entered in quick edit
2. **Hero Subtitle**: Second priority - uses hero section subtitle
3. **Default Descriptions**: Final fallback based on page type and language

### Automatic Title Generation

- **Format**: `{Page Title} - {Description} - {Dentist Name}`
- **Custom Override**: Use custom page title field to override automatic generation
- **Length Optimization**: Automatically truncates to stay within SEO limits
- **Smart Fallbacks**: Falls back to shorter formats if title becomes too long
- **Landing Pages**: Optimized for both German (de) and English (en) landing pages
- **Subpages**: Enhanced descriptions for contact, directions, legal pages, etc.

## Usage

### Quick Edit Meta Description

1. **Access Quick Edit**:

   - Go to Pages → All Pages in WordPress admin
   - Hover over any page and click "Quick Edit"
   - You'll see a new "Meta Description" field in the right column

2. **Edit Custom Page Title** (optional):

   - Enter a custom page title (max 70 characters)
   - Leave empty to use automatic title generation
   - Character counter shows remaining characters

3. **Edit Meta Description**:

   - Enter your meta description (max 160 characters)
   - Character counter shows remaining characters
   - Leave empty to use hero subtitle or default description

4. **Save Changes**:
   - Click "Update" to save the meta description
   - The description will be displayed in the "Meta Description" column

### Meta Description Column

The pages list now includes a "Meta Description" column that shows:

- **Custom descriptions**: If manually set via quick edit
- **Hero subtitle**: If no custom description is set
- **Default descriptions**: For pages without hero sections
- **"No description set"**: For pages without any description

## Page Types and Structured Data

### Landing Pages (de/en)

- Uses hero subtitle as meta description
- Includes comprehensive Dentist schema with contact information

### Contact Pages (kontakt/contact)

- Enhanced with ContactPoint schema
- Includes telephone and language availability
- Meta description: Contact information and appointment booking

### Directions Pages (anfahrt/directions)

- Includes GeoCoordinates schema (example coordinates - update with actual location)
- Meta description: Directions and location information

### Legal Pages (impressum/imprint, datenschutz/privacy-policy)

- Proper organization schema
- Legal information and privacy policy references
- Meta description: Legal and privacy information

## Default Meta Descriptions

### German Pages

- **de**: "Professionelle Zahnmedizin mit modernster Technologie und persönlicher Betreuung für Ihre Zahngesundheit."
- **kontakt**: "Kontaktieren Sie uns für einen Termin in unserer Zahnarztpraxis. Wir sind für Sie da."
- **impressum**: "Impressum und rechtliche Informationen unserer Zahnarztpraxis."
- **datenschutz**: "Datenschutzerklärung unserer Zahnarztpraxis."
- **anfahrt**: "So finden Sie uns - Anfahrt und Kontakt zu unserer Zahnarztpraxis."

### English Pages

- **en**: "Professional dental care with modern technology and personal care for your oral health."
- **contact**: "Contact us for an appointment at our dental practice. We are here for you."
- **imprint**: "Imprint and legal information of our dental practice."
- **privacy-policy**: "Privacy policy of our dental practice."
- **directions**: "How to find us - directions and contact to our dental practice."

## Technical Implementation

### Files Added

- `inc/quick-edit-meta.php`: Main functionality for quick edit and structured data
- `assets/js/quick-edit-meta.js`: JavaScript for quick edit interface
- `doc/README-QUICK-EDIT-META.md`: This documentation

### Files Modified

- `functions.php`: Includes the new quick edit functionality
- All page templates: Updated to use `le_custom_get_meta_description()` function
- Landing page templates: Updated to use new meta description function

### Functions Added

- `le_custom_get_meta_description()`: Gets meta description with fallback logic
- `le_custom_get_subpage_structured_data()`: Generates structured data for subpages
- `le_custom_output_subpage_structured_data()`: Outputs structured data for subpages
- Quick edit hooks and AJAX handlers for meta description management

## SEO Benefits

### Meta Descriptions

- **Consistent Length**: All descriptions are limited to 160 characters
- **Relevant Content**: Uses actual page content or appropriate defaults
- **Multilingual Support**: Separate descriptions for German and English pages

### Structured Data

- **Enhanced Search Results**: Rich snippets in search engines
- **Local SEO**: Proper business information for local searches
- **Contact Information**: Easy access to phone, email, and address
- **Opening Hours**: Displayed in search results

### Technical SEO

- **Clean HTML**: Properly escaped and formatted meta tags
- **Performance**: No impact on page load speed
- **Accessibility**: Proper schema markup for screen readers

## Customization

### Adding New Page Types

To add structured data for new page types:

1. **Update Default Descriptions**:

   ```php
   $defaults = [
       'new-page-slug' => 'Description for new page type',
       // ... existing defaults
   ];
   ```

2. **Add Structured Data Logic**:
   ```php
   switch ($page_slug) {
       case 'new-page-slug':
           $structured_data['mainEntity']['@type'] = 'AppropriateSchema';
           // Add specific structured data
           break;
   }
   ```

### Modifying Character Limit

To change the 160 character limit:

1. **Update JavaScript**:

   ```javascript
   var maxLength = 160; // Change this value
   ```

2. **Update PHP Functions**:
   ```php
   $meta_description = substr($meta_description, 0, 160); // Change this value
   ```

### Custom Meta Description Logic

To modify the fallback logic, edit the `le_custom_get_meta_description()` function in `inc/quick-edit-meta.php`.

## Troubleshooting

### Quick Edit Not Working

- Ensure JavaScript is enabled
- Check browser console for errors
- Verify the page is using the correct template

### Meta Descriptions Not Saving

- Check user permissions (must be able to edit posts)
- Verify nonce validation is working
- Check for plugin conflicts

### Structured Data Not Appearing

- Use Google's Rich Results Test to validate
- Check if page is recognized as a subpage
- Verify contact data is properly configured

## Future Enhancements

### Potential Improvements

- **Bulk Edit Support**: Edit meta descriptions for multiple pages at once
- **SEO Analysis**: Character count and keyword suggestions
- **Preview Functionality**: See how meta descriptions appear in search results
- **Advanced Structured Data**: More specific schemas for different content types

### Integration Opportunities

- **Yoast SEO**: Compatibility with popular SEO plugins
- **Google Analytics**: Track meta description performance
- **Schema.org**: Additional schema types for dental practices
