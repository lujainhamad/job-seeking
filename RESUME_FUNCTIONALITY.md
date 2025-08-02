# Resume HTML View and PDF Download Functionality

This document describes the new resume functionality that allows users to view their resume in HTML format and download it as a PDF.

## Features

- **HTML View**: Professional resume display in web browser
- **PDF Download**: Automatic PDF generation and download
- **Professional Design**: Clean, modern layout suitable for job applications
- **Complete Information**: Displays all resume sections
- **Print-Friendly**: Optimized CSS for printing and PDF generation
- **Responsive**: Works well on different screen sizes

## Routes

### Web Routes (with authentication)
- `GET /resume/view` - Display resume in HTML format
- `GET /resume/download` - Download resume as PDF

### API Routes (with authentication)
- `GET /api/resumes/my-cv` - Get resume data as JSON (existing)
- `GET /api/resumes/view` - Get HTML view
- `GET /api/resumes/download-pdf` - Download PDF

## Implementation Details

### Controller Methods

The `ResumeController` has been extended with two new methods:

1. **`viewHtml()`**: Returns the resume data in HTML format
2. **`downloadPdf()`**: Generates and downloads a PDF file

### View Template

The resume is displayed using the `resources/views/resume.blade.php` template, which includes:

- Professional styling with CSS
- User profile information (name, email, phone, birthdate)
- Resume sections (about, fields, experience, education, skills, languages)
- Print-optimized CSS
- Responsive design

### PDF Generation

PDF generation is handled by the `barryvdh/laravel-dompdf` package, which:

- Converts HTML to PDF
- Maintains styling and layout
- Generates professional-looking documents
- Automatically downloads files with descriptive names

## Usage Examples

### View Resume in Browser
```bash
# Requires authentication
GET /resume/view
```

### Download PDF
```bash
# Requires authentication
GET /resume/download
```

### API Usage
```javascript
// Get HTML view
fetch('/api/resumes/view', {
    headers: {
        'Authorization': 'Bearer ' + token
    }
})

// Download PDF
fetch('/api/resumes/download-pdf', {
    headers: {
        'Authorization': 'Bearer ' + token
    }
})
```

## Dependencies

- `barryvdh/laravel-dompdf` - For PDF generation
- Laravel Sanctum - For authentication

## Installation

The DomPDF package has been installed and configured. The configuration file is available at `config/dompdf.php`.

## Customization

### Styling
The resume appearance can be customized by modifying the CSS in `resources/views/resume.blade.php`.

### PDF Options
PDF generation options can be configured in `config/dompdf.php`.

### Content
The resume content is pulled from the database using the existing models and relationships.

## Security

- All routes require authentication
- Users can only access their own resume data
- PDF files are generated on-demand and not stored permanently

## Testing

A test page is available at `/test-resume` for development purposes. This should be removed in production.

## Notes

- The existing `/api/resumes/my-cv` endpoint continues to work as before
- The new functionality is additive and doesn't break existing features
- All resume data is loaded with relationships (experiences, educations, skills, languages)
- The PDF filename includes the user's name and current date for easy identification 