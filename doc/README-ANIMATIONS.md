# AOS Animations Documentation

## Overview

The landing pages now feature smooth AOS (Animate On Scroll) animations throughout all sections, creating a modern and engaging user experience.

## AOS Library Integration

### Hosting Decision: Local vs CDN

We chose **local hosting** for AOS files because:

#### ✅ **Why Local is Better for Medical Websites**

- **Reliability**: 100% uptime guarantee - no external dependencies
- **Privacy**: No third-party requests - better for patient data protection
- **Performance**: Faster loading for your specific region
- **Control**: Full control over the user experience
- **Compliance**: Better for healthcare privacy regulations (GDPR, HIPAA)
- **Offline Capability**: Works even without internet connection

#### 📁 **File Structure**

```
assets/
└── vendor/
    └── aos/
        ├── aos.css (25KB)
        └── aos.js (14KB)
```

### Setup

- **CSS**: `assets/vendor/aos/aos.css` (local)
- **JS**: `assets/vendor/aos/aos.js` (local)
- **Initialization**: In `assets/js/theme.js` with optimized settings

### Configuration

```javascript
AOS.init({
  duration: 800,
  easing: "ease-in-out",
  once: true,
  offset: 100,
  delay: 0,
});
```

## Animation Breakdown by Section

### 🎯 Hero Section

**Location**: Both German and English landing pages

| Element  | Animation | Delay | Duration | Effect                     |
| -------- | --------- | ----- | -------- | -------------------------- |
| Title    | `fade-up` | 100ms | 800ms    | Smooth fade in from bottom |
| Subtitle | `fade-up` | 200ms | 800ms    | Staggered fade in          |
| Buttons  | `fade-up` | 400ms | 800ms    | Final element animation    |

### 🏥 Services Section

**Location**: `template-parts/services-section.php`

| Element          | Animation | Delay         | Duration | Effect                |
| ---------------- | --------- | ------------- | -------- | --------------------- |
| Section Title    | `fade-up` | 100ms         | 800ms    | Header animation      |
| Service Cards    | `fade-up` | 100-400ms     | 800ms    | Staggered card reveal |
| Individual Cards | `fade-up` | Index × 100ms | 800ms    | Sequential animation  |

**Service Card Animation Pattern**:

- Card 1: 100ms delay
- Card 2: 200ms delay
- Card 3: 300ms delay
- Card 4: 400ms delay

### 📖 About Section

**Location**: Both landing pages

| Element         | Animation | Delay               | Duration | Effect                 |
| --------------- | --------- | ------------------- | -------- | ---------------------- |
| Content Blocks  | `fade-up` | Block Index × 200ms | 800ms    | Staggered block reveal |
| Fallback Layout | `fade-up` | 100ms               | 800ms    | Single animation       |

**About Block Animation Pattern**:

- Block 1: 0ms delay
- Block 2: 200ms delay
- Block 3: 400ms delay
- etc.

### 📞 CTA Section

**Location**: `template-parts/cta-section.php`

| Element         | Animation   | Delay | Duration | Effect                    |
| --------------- | ----------- | ----- | -------- | ------------------------- |
| Background Icon | `fade-left` | 300ms | 1000ms   | Icon slides in from right |
| Title           | `fade-up`   | 100ms | 800ms    | Smooth fade in            |
| Description     | `fade-up`   | 200ms | 800ms    | Staggered text reveal     |
| Buttons         | `fade-up`   | 400ms | 800ms    | Final call-to-action      |

## Animation Types Used

### `fade-up`

- **Usage**: Most common animation
- **Effect**: Elements fade in while moving up from below
- **Best for**: Text, cards, sections

### `fade-left`

- **Usage**: Background decorative elements
- **Effect**: Elements slide in from the right
- **Best for**: Icons, decorative graphics

## Performance Optimizations

### 1. Staggered Delays

- Prevents overwhelming the user
- Creates natural reading flow
- Maintains visual hierarchy

### 2. Once-Only Animation

- `once: true` setting
- Animations only trigger once per element
- Improves performance on scroll

### 3. Optimized Timing

- 800ms duration for smooth feel
- 100-400ms delays for natural flow
- 100px offset for optimal trigger timing

## Responsive Behavior

### Mobile Devices

- Animations work on all screen sizes
- Touch scrolling triggers animations
- Performance optimized for mobile

### Desktop

- Smooth scroll animations
- Mouse wheel triggers
- Enhanced visual experience

## Customization Options

### Adding New Animations

```html
<div data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
  Your content here
</div>
```

### Available Animation Types

- `fade-up` - Fade in from bottom
- `fade-down` - Fade in from top
- `fade-left` - Fade in from right
- `fade-right` - Fade in from left
- `zoom-in` - Zoom in effect
- `zoom-out` - Zoom out effect
- `slide-up` - Slide up from bottom
- `slide-down` - Slide down from top

### Timing Parameters

- `data-aos-delay` - Delay before animation starts (ms)
- `data-aos-duration` - Animation duration (ms)
- `data-aos-easing` - Animation easing function

## Browser Support

### Supported Browsers

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

### Fallback Behavior

- Graceful degradation on older browsers
- Content remains visible without animations
- No impact on functionality

## Accessibility Considerations

### Reduced Motion

- Respects `prefers-reduced-motion` media query
- Users can disable animations in browser settings
- Content remains accessible without animations

### Screen Readers

- Animations don't interfere with screen readers
- Content is announced properly
- No accessibility issues

## Troubleshooting

### Common Issues

1. **Animations not working**: Check if AOS is loaded
2. **Performance issues**: Reduce animation complexity
3. **Mobile problems**: Test on actual devices

### Debug Mode

```javascript
AOS.init({
  debug: true,
});
```

## Future Enhancements

### Potential Additions

- Scroll-triggered parallax effects
- Interactive hover animations
- Page transition animations
- Loading state animations

### Performance Monitoring

- Monitor animation performance
- Optimize for slower devices
- Consider user preferences
