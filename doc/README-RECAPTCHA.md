# reCAPTCHA v3 Integration Guide

## Overview
The theme now includes reCAPTCHA v3 integration for the contact forms to provide spam protection while maintaining a smooth user experience.

## Setup Instructions

### 1. Get reCAPTCHA Keys
1. Go to [Google reCAPTCHA Console](https://www.google.com/recaptcha/admin)
2. Click "+" to create a new site
3. Choose **reCAPTCHA v3**
4. Add your domain(s) (e.g., `yourdomain.com`, `www.yourdomain.com`)
5. Accept the terms and submit
6. Copy both the **Site Key** and **Secret Key**

### 2. Configure in WordPress Admin
1. Go to **Appearance → Customize** in your WordPress admin
2. Navigate to **Contact Information** section
3. Enter your keys:
   - **reCAPTCHA Site Key**: Your public site key
   - **reCAPTCHA Secret Key**: Your private secret key (kept secure)
   - **reCAPTCHA Score Threshold**: Set between 0.0-1.0 (default: 0.5)
     - Higher values (0.7-1.0) = More strict (may block some humans)
     - Lower values (0.3-0.5) = More lenient (may allow some bots)

### 3. How It Works

#### For Users:
- **Invisible protection**: No "I'm not a robot" checkbox
- **Seamless experience**: Forms work normally
- **Automatic verification**: Happens in the background

#### For Admins:
- **Score-based filtering**: Each submission gets a score (0.0 = bot, 1.0 = human)
- **Customizable threshold**: Adjust sensitivity based on your needs
- **Fallback protection**: Works with or without reCAPTCHA configured

### 4. Testing

#### Local Development:
- reCAPTCHA works on `localhost` for testing
- Add `localhost` to your reCAPTCHA domain list

#### Live Site:
- Ensure your domain is added to reCAPTCHA settings
- Test form submissions
- Check server logs for any verification issues

### 5. Score Threshold Guidelines

| Score Range | Recommendation | Use Case |
|-------------|----------------|----------|
| 0.9 - 1.0   | Very Strict    | High-security sites |
| 0.7 - 0.8   | Strict         | Most business sites |
| 0.5 - 0.6   | Balanced       | **Default recommendation** |
| 0.3 - 0.4   | Lenient        | High-traffic sites |
| 0.1 - 0.2   | Very Lenient   | Accessibility priority |

### 6. Troubleshooting

#### Common Issues:
1. **"Security check failed"**:
   - Check that domain is added to reCAPTCHA console
   - Verify keys are correctly entered
   - Ensure site is accessible from internet

2. **Forms not submitting**:
   - Check browser console for JavaScript errors
   - Verify reCAPTCHA script is loading
   - Test with reCAPTCHA disabled

3. **Too many legitimate submissions blocked**:
   - Lower the score threshold
   - Check reCAPTCHA analytics for patterns

#### Debug Mode:
- reCAPTCHA includes analytics in Google reCAPTCHA console
- Monitor submission patterns and adjust threshold accordingly

### 7. Backup Plan
If reCAPTCHA is not configured or fails:
- Forms still work with WordPress nonce protection
- No user-facing errors
- Graceful fallback to standard security measures

## Files Modified
- `inc/customizer.php` - Admin settings
- `inc/contact-form-handler.php` - Server-side verification
- `functions.php` - Script loading
- `assets/js/theme.js` - Client-side integration
- `page-contact-de.php` & `page-contact-en.php` - Contact forms

## Security Notes
- Secret key is never exposed to front-end
- Verification happens server-side
- Scores are logged for monitoring
- Graceful degradation if service unavailable