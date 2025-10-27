# VAT ID Configuration

The VAT ID (Value Added Tax Identification Number / Umsatzsteuer-Identifikationsnummer) is now configurable through the WordPress Customizer instead of being hardcoded in the imprint pages.

## How to Configure

### In WordPress Admin Panel

1. **Go to**: Appearance → Customize
2. **Navigate to**: Contact Information section
3. **Find**: "VAT ID / USt-IdNr." field
4. **Enter your VAT ID**: For example, `DE123456789`
5. **Click**: "Publish" to save

## Where It Appears

The VAT ID will automatically appear on both imprint pages:
- **German**: `/impressum` (Imprint - German)
- **English**: `/en/imprint` (Imprint - English)

### Display Format

**German (Impressum):**
```
Umsatzsteuer-ID
Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:
DE123456789
```

**English (Imprint):**
```
VAT ID
Value Added Tax Identification Number according to § 27 a Value Added Tax Act:
DE123456789
```

## Fallback Behavior

If no VAT ID is entered in the customizer:
- **German page** shows: `[Ihre USt-IdNr. hier einfügen]`
- **English page** shows: `[Insert your VAT ID here]`

This makes it clear to site administrators that the field needs to be filled.

## Technical Details

### Files Modified

1. **inc/customizer.php**
   - Added `vat_id` setting and control in the Contact Information section

2. **functions.php**
   - Added `vat_id` to the `le_custom_get_contact_data()` function return array

3. **page-imprint-de.php**
   - Updated VAT ID section to use `$contact_data['vat_id']`

4. **page-imprint-en.php**
   - Updated VAT ID section to use `$contact_data['vat_id']`

### Usage in Templates

To access the VAT ID in any template:

```php
$contact_data = le_custom_get_contact_data();
$vat_id = $contact_data['vat_id'];

if (!empty($vat_id)) {
    echo esc_html($vat_id);
}
```

## Benefits

✅ **Easy to Update**: Change VAT ID without editing code  
✅ **Multilingual**: Automatically displays on both language versions  
✅ **Centralized**: One place to manage this information  
✅ **No Code Required**: Site administrators can update it directly  
✅ **Safe**: Properly sanitized and escaped for security  

## Example VAT ID Formats

- **Germany**: `DE123456789`
- **Austria**: `ATU12345678`
- **Switzerland**: `CHE-123.456.789 MWST`
- **Netherlands**: `NL123456789B01`

Simply enter your country-specific VAT ID format in the customizer field.
