# Gallery Block - Image Replace Feature

## Overview

The gallery block now includes the ability to replace individual images within a gallery without having to remove and re-upload them. This enhancement provides a more user-friendly experience when managing gallery content.

## Features

### Image Replace Functionality

- **Replace Button**: Each image in the gallery editor now displays a "Replace" button when hovered over
- **Seamless Replacement**: Click the "Replace" button to open the media library and select a new image
- **Caption Preservation**: When replacing an image, the existing caption is preserved unless the new image has its own caption
- **Instant Preview**: The replaced image appears immediately in the editor

### User Interface

- **Intuitive Controls**: Replace and Remove buttons appear on hover over each gallery image
- **Professional Styling**: Buttons are styled to match WordPress admin interface
- **Responsive Design**: Controls work properly on all screen sizes

## How to Use

### Replacing an Image

1. Edit a page or post containing a gallery block
2. Hover over the image you want to replace
3. Click the blue "Replace" button that appears in the top-right corner
4. Select a new image from the media library
5. The image will be replaced immediately while preserving the caption

### Managing Gallery Images

- **Add Images**: Use the "Select Treatment Images" or "Add More Images" button
- **Replace Images**: Use the "Replace" button on individual images
- **Remove Images**: Use the red "Remove" button on individual images
- **Edit Captions**: Click in the caption field below each image to edit

## Technical Implementation

### Files Modified

- `assets/js/gallery-inserter.js` - Added replace functionality to the block editor
- `assets/css/gallery-block.css` - Added styling for image controls
- `assets/css/gallery-block-editor.css` - Added editor-specific styling
- `inc/gallery-block.php` - Enhanced to include editor CSS

### New Functions

- `replaceImage(index, newImage)` - Handles image replacement logic
- Enhanced image control layout with replace button

### CSS Classes

- `.gallery-image-controls` - Container for replace/remove buttons
- `.replace-image-button` - Styling for the replace button
- `.remove-image-button` - Styling for the remove button

## Browser Compatibility

The replace feature is compatible with all modern browsers and WordPress versions 5.0+.

## Best Practices

### Image Selection

- Choose high-quality images with appropriate aspect ratios
- Ensure images are optimized for web use
- Use consistent styling across gallery images

### Captions

- Write descriptive captions for accessibility
- Keep captions concise but informative
- Use consistent caption formatting

### Performance

- The lazy loading feature continues to work with replaced images
- Lightbox functionality is automatically updated for new images
- Image optimization recommendations remain the same

## Troubleshooting

### Common Issues

1. **Replace button not appearing**: Ensure you're in edit mode and hovering over the image
2. **Media library not opening**: Check WordPress permissions and browser console for errors
3. **Image not updating**: Clear browser cache and refresh the editor

### Support

For additional support or feature requests, refer to the theme documentation or contact the development team.
