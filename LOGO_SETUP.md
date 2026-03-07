# Logo Setup Guide - TwendeeTickets

## 📁 Logo Storage Location
Your logos are stored in: `public/images/logo/`

## 🎨 Supported Logo Files
The system automatically detects and uses logos in this order:
1. `logo.png` (recommended for best quality)
2. `logo.jpg` (JPEG format support)
3. `logo.jpeg` (JPEG format support) 
4. `logo.svg` (recommended for scalability)
5. Falls back to default icon if no logo found

## 📏 Recommended Logo Sizes
- **Desktop Navigation**: Height 32px, width auto
- **Mobile Navigation**: Height 24px, width auto  
- **Admin Sidebar**: Height 32px, width auto
- **Footer**: Height 32px, width auto

## 🔄 How to Change Your Logo

### Option 1: Replace the SVG Logo
1. Place your logo file as `public/images/logo/logo.svg`
2. The system will automatically detect and use it

### Option 2: Use JPEG Logo
1. Place your logo file as `public/images/logo/logo.jpg` or `logo.jpeg`
2. The system will automatically detect and use it

### Option 3: Use PNG Logo
1. Place your logo file as `public/images/logo/logo.png`
2. The system will prioritize PNG over other formats

### Option 4: Multiple Formats
1. Place multiple logo files in the directory
2. System priority: `logo.png` → `logo.jpg` → `logo.jpeg` → `logo.svg`

## 🎯 Logo Requirements
- **Format**: PNG, JPG, JPEG, SVG, or ICO
- **Background**: Transparent background recommended
- **Size**: Between 100px - 400px width
- **Aspect Ratio**: Square or slightly rectangular works best

## 📍 Where Your Logo Appears
- **Public Site**: Navigation bar and footer
- **Admin Panel**: Sidebar header
- **Responsive**: Automatically adapts to mobile/desktop

## 🚀 Quick Setup
1. Add your logo file to `public/images/logo/`
2. Name it `logo.png` or `logo.svg`
3. Refresh your browser
4. Logo will appear automatically!

## 📝 Current Status
- ✅ Logo directory created
- ✅ Sample SVG logo included
- ✅ Admin layout updated
- ✅ Public layout updated
- ✅ Fallback system in place

## 🎨 Sample Logo Included
A sample EventHub logo (`logo.svg`) is already included. Replace it with your own logo!
