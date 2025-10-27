# Hero Media Update - Image and Video Support

## Overview

The hero section has been enhanced to support both image and video backgrounds, allowing clients to choose their preferred media type. Videos automatically play in loop without sound for a professional background effect.

## New Features

### 1. Media Type Selection

- **Toggle Switch**: "Use Background Media" checkbox to enable/disable custom backgrounds
- **Media Type Dropdown**: Choose between "Image" or "Video"
- **Dynamic Form Fields**: Relevant upload fields show/hide based on selection

### 2. Video Support

- **Auto-play**: Videos start automatically when page loads
- **Loop**: Videos play continuously in the background
- **Muted**: No sound (required for autoplay in modern browsers)
- **Mobile Optimized**: Uses `playsinline` attribute for mobile compatibility

### 3. Vanilla JavaScript

- **No jQuery Dependency**: Replaced jQuery with pure JavaScript
- **Better Performance**: Faster execution and smaller bundle size
- **Modern Code**: Uses ES6+ features and event listeners

## Technical Implementation

### Files Modified

#### `inc/hero-section.php`

- Updated form fields to support media type selection
- Added video upload field and preview
- Modified background style generation for video support
- Updated display function to render video backgrounds

#### `assets/js/hero-section-admin.js`

- Complete rewrite in vanilla JavaScript
- Added media type switching logic
- Separate handlers for image and video uploads
- Dynamic form field visibility management

### Database Changes

New meta fields added:

- `_hero_use_background_media` - Boolean toggle for media usage
- `_hero_media_type` - String ('image' or 'video')
- `_hero_background_video` - Video URL string

### Video Implementation

```html
<video
  class="absolute inset-0 w-full h-full object-cover"
  autoplay
  muted
  loop
  playsinline
>
  <source src="video-url.mp4" type="video/mp4" />
</video>
```

**Video Attributes:**

- `autoplay` - Starts playing automatically
- `muted` - No sound (required for autoplay)
- `loop` - Plays continuously
- `playsinline` - Plays inline on mobile devices

## Usage Instructions

### For Clients

1. **Enable Media**: Check "Use Background Media" in Hero Section Settings
2. **Choose Type**: Select "Image" or "Video" from dropdown
3. **Upload Media**: Click "Choose Image" or "Choose Video" button
4. **Preview**: See preview of selected media
5. **Remove**: Use "Remove" button to clear selection

### For Developers

#### Adding Video Support to Custom Pages

```php
// Get hero data
$hero_data = le_custom_get_hero_data($post_id);

// Check if video background is set
if (!empty($hero_data['use_background_media']) &&
    $hero_data['media_type'] === 'video' &&
    !empty($hero_data['background_video'])) {

    // Add video element
    echo '<video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>';
    echo '<source src="' . esc_url($hero_data['background_video']) . '" type="video/mp4">';
    echo '</video>';
}
```

#### Customizing Video Behavior

```javascript
// In your custom JavaScript
document.addEventListener("DOMContentLoaded", function () {
  const video = document.querySelector(".hero-background-video");
  if (video) {
    // Pause video on user interaction
    video.addEventListener("click", function () {
      if (video.paused) {
        video.play();
      } else {
        video.pause();
      }
    });
  }
});
```

## Browser Compatibility

### Supported Browsers

- **Chrome 50+**: Full video autoplay support
- **Firefox 50+**: Full video autoplay support
- **Safari 10+**: Full video autoplay support
- **Edge 79+**: Full video autoplay support

### Mobile Devices

- **iOS Safari**: Video plays inline with `playsinline` attribute
- **Android Chrome**: Full support for autoplay muted videos
- **Mobile Firefox**: Full support for autoplay muted videos

### Fallback Behavior

- If video fails to load: Falls back to background color
- If autoplay is blocked: Video remains paused (user can click to play)
- If video format not supported: Shows fallback text

## Performance Considerations

### Video Optimization

- **Format**: Use MP4 with H.264 codec for best compatibility
- **Size**: Keep videos under 10MB for faster loading
- **Resolution**: 1920x1080 or lower for web backgrounds
- **Duration**: 10-30 seconds for looped backgrounds

### Loading Strategy

- Videos load asynchronously
- Background color shows while video loads
- No impact on page load performance

## Troubleshooting

### Common Issues

1. **Video Not Playing**

   - Check if browser blocks autoplay
   - Ensure video is muted
   - Verify video format is MP4

2. **Video Not Looping**

   - Check if `loop` attribute is present
   - Verify video file is not corrupted

3. **Mobile Video Issues**
   - Ensure `playsinline` attribute is set
   - Test on actual mobile device

### Debug Mode

Enable WordPress debug mode to see any JavaScript errors:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Future Enhancements

### Planned Features

- **Multiple Video Formats**: Support for WebM and OGV
- **Video Controls**: Optional play/pause controls
- **Video Preloading**: Preload video for smoother playback
- **Responsive Videos**: Different video sizes for different screen sizes

### Customization Options

- **Video Start Time**: Set custom start position
- **Video End Time**: Set custom end position for loop
- **Video Speed**: Control playback speed
- **Video Quality**: Auto-switch quality based on connection

## Migration Notes

### From Previous Version

- Existing image backgrounds continue to work
- No data migration required
- New fields are optional and have defaults

### Backward Compatibility

- All existing hero section functionality preserved
- Old image-only code still works
- Gradual migration to new system possible
