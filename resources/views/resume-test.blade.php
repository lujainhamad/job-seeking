<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .button:hover {
            background: #2980b9;
        }
        .button.download {
            background: #27ae60;
        }
        .button.download:hover {
            background: #229954;
        }
        .info {
            background: #e8f4fd;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }
        .code {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resume Functionality Test</h1>
        
        <div class="info">
            <h3>Available Routes:</h3>
            <ul>
                <li><strong>HTML View:</strong> <code>/resume/view</code> (requires authentication)</li>
                <li><strong>PDF Download:</strong> <code>/resume/download</code> (requires authentication)</li>
                <li><strong>API Endpoints:</strong> 
                    <ul>
                        <li><code>GET /api/resumes/my-cv</code> - Get resume data as JSON</li>
                        <li><code>GET /api/resumes/view</code> - HTML view</li>
                        <li><code>GET /api/resumes/download-pdf</code> - PDF download</li>
                    </ul>
                </li>
            </ul>
        </div>

        <h2>How to Use:</h2>
        
        <h3>1. View Resume as HTML</h3>
        <p>To view your resume in HTML format, make a GET request to:</p>
        <div class="code">GET /resume/view</div>
        <p>This will display your resume in a professional HTML format that can be printed or saved as PDF using browser print functionality.</p>
        
        <h3>2. Download Resume as PDF</h3>
        <p>To download your resume as a PDF file, make a GET request to:</p>
        <div class="code">GET /resume/download</div>
        <p>This will generate a PDF file with your resume data and automatically download it.</p>
        
        <h3>3. API Usage</h3>
        <p>For programmatic access, use the API endpoints with proper authentication:</p>
        <div class="code">
            // Get resume data as JSON<br>
            GET /api/resumes/my-cv<br><br>
            
            // Get HTML view<br>
            GET /api/resumes/view<br><br>
            
            // Download PDF<br>
            GET /api/resumes/download-pdf
        </div>

        <h2>Features:</h2>
        <ul>
            <li><strong>Professional Design:</strong> Clean, modern layout suitable for job applications</li>
            <li><strong>Complete Information:</strong> Displays all resume sections including personal info, experience, education, skills, and languages</li>
            <li><strong>Print-Friendly:</strong> Optimized CSS for printing and PDF generation</li>
            <li><strong>Responsive:</strong> Works well on different screen sizes</li>
            <li><strong>Customizable:</strong> Easy to modify the design by editing the CSS in the view</li>
        </ul>

        <h2>Authentication Required:</h2>
        <p>All resume routes require user authentication. Make sure you're logged in before accessing these endpoints.</p>

        <div class="info">
            <h3>Note:</h3>
            <p>This test page is for development purposes only. In production, you should remove the test route and ensure all resume access is properly authenticated.</p>
        </div>
    </div>
</body>
</html> 