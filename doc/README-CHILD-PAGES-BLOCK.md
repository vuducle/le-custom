# Child Pages Block

A custom Gutenberg block that automatically displays child pages with their title, featured image, excerpt, and link. Perfect for parent pages like "Services" (Leistungen) that need to show all their child pages.

## Features

- **Automatic Child Page Detection**: Automatically displays all published child pages of the current page
- **Drag & Drop**: Simple to use in the Gutenberg editor - just drag and drop the block
- **Customizable Layout**: Choose between grid or list layout
- **Flexible Display Options**:
  - Show/hide featured images
  - Show/hide excerpts
  - Adjust excerpt length
  - Configure number of columns (for grid layout)
- **Sorting Options**: Order by menu order, title, date created, or date modified
- **Responsive Design**: Adapts to all screen sizes
- **Theme Color Integration**: Uses your theme's primary color for hover effects
- **Smooth Animations**: Cards animate on load and have smooth hover effects

## How to Use

### Adding the Block

1. Edit a page that has child pages (e.g., `/leistungen`)
2. Click the **+** button to add a new block
3. Search for "Child Pages" or find it in the **Widgets** category
4. Click to add the block

The block will automatically display all child pages of the current page.

### Configuring the Block

Once added, you can configure the block using the **Block Settings** panel on the right:

#### Layout Settings
- **Layout**: Choose between Grid or List view
- **Columns**: (Grid only) Select 1-4 columns

#### Display Settings
- **Show Featured Image**: Toggle to show/hide the featured image
- **Show Excerpt**: Toggle to show/hide the page excerpt
- **Excerpt Length**: Adjust the number of words in the excerpt (10-50 words)

#### Sorting
- **Order By**: 
  - Menu Order (default - respects page order set in admin)
  - Title (alphabetical)
  - Date Created
  - Date Modified
- **Order**: Ascending or Descending

## Use Cases

### 1. Services/Leistungen Page
Create a parent page "Leistungen" with child pages for each service:
```
/leistungen (Parent)
  ├── /leistungen/zahnreinigung (Child)
  ├── /leistungen/implantate (Child)
  ├── /leistungen/bleaching (Child)
  └── /leistungen/kieferorthopaedie (Child)
```

Add the Child Pages block to the `/leistungen` page, and it will automatically display all 4 services with their images and descriptions.

### 2. Team Members
```
/team (Parent)
  ├── /team/dr-mueller (Child)
  ├── /team/dr-schmidt (Child)
  └── /team/assistant-weber (Child)
```

### 3. Location/Practice Information
```
/standorte (Parent)
  ├── /standorte/berlin (Child)
  ├── /standorte/hamburg (Child)
  └── /standorte/muenchen (Child)
```

## Requirements

For best results, make sure each child page has:

1. **Featured Image**: Set a featured image for each child page
2. **Excerpt**: Add a custom excerpt or let WordPress generate one automatically
3. **Menu Order**: Set the menu order in **Page Attributes** if you want custom ordering

## Styling

The block uses:
- Tailwind CSS classes for responsive layout
- Theme's primary and secondary colors for hover effects
- Custom animations for smooth transitions
- Shadow effects for depth

### Customization

If you need to customize the styling, edit:
- `/assets/css/child-pages-block.css` - Frontend styles

## Technical Details

### File Structure
```
inc/child-pages-block.php           # PHP backend logic
assets/js/child-pages-block.js      # Gutenberg block registration
assets/css/child-pages-block.css    # Block styles
```

### Block Attributes
```javascript
{
  layout: 'grid' | 'list',
  columns: 1-4,
  showImage: boolean,
  showExcerpt: boolean,
  excerptLength: 10-50,
  orderBy: 'menu_order' | 'title' | 'date' | 'modified',
  order: 'ASC' | 'DESC'
}
```

### WordPress Functions Used
- `WP_Query` - Queries child pages
- `get_the_ID()` - Gets current page ID
- `has_post_thumbnail()` - Checks for featured image
- `the_post_thumbnail()` - Displays featured image
- `wp_trim_words()` - Trims excerpt to specified length

## Troubleshooting

### No child pages showing?
- Make sure the current page has child pages
- Check that child pages are published (not drafts)
- Verify page hierarchy in **Pages > All Pages**

### Images not appearing?
- Set featured images for child pages
- Make sure "Show Featured Image" is enabled in block settings

### Wrong order?
- Check the sorting settings in block settings
- For custom order, set **Menu Order** in **Page Attributes** for each child page

## Example Configuration

**Recommended settings for Services page:**
- Layout: Grid
- Columns: 3
- Show Featured Image: Yes
- Show Excerpt: Yes
- Excerpt Length: 20 words
- Order By: Menu Order
- Order: Ascending

This creates a clean 3-column grid showing all services with images and short descriptions.
