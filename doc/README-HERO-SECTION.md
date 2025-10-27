# Hero Section Editor

This feature allows clients to easily customize the hero section content and background for both German and English landing pages.

## How to Use

### 1. Access the Hero Section Settings

1. Go to **Pages** in your WordPress admin
2. Edit either the **German** (`/de`) or **English** (`/en`) landing page
3. Scroll down to find the **"Hero Section Settings"** meta box

### 2. Edit Hero Content

The hero section editor includes the following fields:

#### Content Fields:

- **Hero Title**: Main heading text
- **Hero Subtitle**: Subtitle text below the main heading
- **Primary Button Text**: Text for the main call-to-action button
- **Primary Button URL**: Link for the primary button (can be anchor links like `#termin`)
- **Secondary Button Text**: Text for the secondary button
- **Secondary Button URL**: Link for the secondary button

#### Background Image Settings:

- **Use Background Image**: Checkbox to enable custom background image
- **Background Image**: Upload or choose an image for the hero background

### 3. Default Values

The system automatically provides appropriate default values:

#### German Page (`/de`):

- Title: "Willkommen in unserer Zahnarztpraxis"
- Subtitle: "Professionelle Zahnmedizin mit modernster Technologie und persönlicher Betreuung für Ihre Zahngesundheit."
- Primary Button: "Termin vereinbaren" → `#termin`
- Secondary Button: "Unsere Leistungen" → `#leistungen`

#### English Page (`/en`):

- Title: "Welcome to Our Dental Practice"
- Subtitle: "Professional dentistry with state-of-the-art technology and personalized care for your oral health."
- Primary Button: "Book Appointment" → `#appointment`
- Secondary Button: "Our Services" → `#services`

### 4. Background Image Features

When a background image is uploaded and enabled:

- The image covers the entire hero section
- A semi-transparent dark overlay is added for better text readability
- Text colors automatically change to white for better contrast
- The secondary button styling adapts to work with the background image

### 5. Tips for Best Results

#### Text Content:

- Keep titles concise and impactful
- Subtitle should be 1-2 sentences maximum
- Button text should be action-oriented

#### Background Images:

- Use high-resolution images (minimum 1920x1080px)
- Choose images with good contrast
- Avoid busy or cluttered images that make text hard to read
- Dental/medical themed images work well

#### Button URLs:

- Use anchor links (e.g., `#termin`, `#leistungen`) to link to sections on the same page
- Use full URLs (e.g., `https://example.com/contact`) for external links
- Use `tel:+49123456789` for phone numbers
- Use `mailto:info@example.com` for email addresses

## Technical Details

- All content is stored as custom post meta
- Images are handled through WordPress Media Library
- Content is properly sanitized and escaped for security
- The system works independently for German and English pages
- Changes are saved automatically when the page is updated

## Troubleshooting

### Image Not Showing:

- Ensure "Use Background Image" is checked
- Verify the image was uploaded successfully
- Check that the image URL is valid

### Text Not Updating:

- Make sure to click "Update" or "Publish" after making changes
- Clear any caching plugins if changes don't appear immediately
- Check that you're editing the correct page (German vs English)

### Buttons Not Working:

- Verify the URL format is correct
- For anchor links, ensure the target section exists on the page
- Test the links in a new browser tab
