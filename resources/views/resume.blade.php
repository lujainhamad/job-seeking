<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->title ?? 'Resume' }} - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #2c3e50;
            font-size: 1.5em;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .about {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin-bottom: 20px;
        }
        
        .fields {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .field {
            flex: 1;
            background: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
        }
        
        .field-label {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .experience-item, .education-item, .skill-item, .language-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
        }
        
        .experience-header, .education-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .experience-title, .education-title {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
        }
        
        .experience-company, .education-institution {
            color: #3498db;
            font-weight: bold;
        }
        
        .experience-dates, .education-dates {
            color: #7f8c8d;
            font-style: italic;
        }
        
        .experience-description, .education-description {
            color: #555;
            line-height: 1.5;
        }
        
        .skills-grid, .languages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        
        .skill-item, .language-item {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 3px solid #3498db;
        }
        
        @media print {
            body {
                max-width: none;
                margin: 0;
                padding: 15px;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        @if($user->logo)
            <img src="{{ asset('storage/' . $user->logo) }}" alt="Profile Photo" class="user-avatar">
        @endif
        <h1>{{ $user->name }}</h1>
        <div class="contact-info">
            <div class="contact-item">
                <strong>📧</strong> {{ $user->email }}
            </div>
            <div class="contact-item">
                <strong>📱</strong> {{ $user->phone }}
            </div>
            <div class="contact-item">
                <strong>🎂</strong> {{ \Carbon\Carbon::parse($user->birthdate)->format('M d, Y') }}
            </div>
        </div>
    </div>

    @if($resume)
        @if($resume->about)
            <div class="section">
                <h2 class="section-title">About</h2>
                <div class="about">
                    {{ $resume->about }}
                </div>
            </div>
        @endif

        @if($resume->main_field || $resume->second_field)
            <div class="section">
                <h2 class="section-title">Fields of Expertise</h2>
                <div class="fields">
                    @if($resume->main_field)
                        <div class="field">
                            <div class="field-label">Primary Field:</div>
                            <div>{{ $resume->main_field }}</div>
                        </div>
                    @endif
                    @if($resume->second_field)
                        <div class="field">
                            <div class="field-label">Secondary Field:</div>
                            <div>{{ $resume->second_field }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($resume->experiences && count($resume->experiences) > 0)
            <div class="section">
                <h2 class="section-title">Work Experience</h2>
                @foreach($resume->experiences as $experience)
                    <div class="experience-item">
                        <div class="experience-header">
                            <div>
                                <div class="experience-title">{{ $experience->name }}</div>
                            </div>
                            <div class="experience-dates">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                            </div>
                        </div>
                        @if($experience->description)
                            <div class="experience-description">{{ $experience->description }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->educations && count($resume->educations) > 0)
            <div class="section">
                <h2 class="section-title">Education</h2>
                @foreach($resume->educations as $education)
                    <div class="education-item">
                        <div class="education-header">
                            <div>
                                <div class="education-title">{{ $education->name }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->skills && count($resume->skills) > 0)
            <div class="section">
                <h2 class="section-title">Skills</h2>
                <div class="skills-grid">
                    @foreach($resume->skills as $skill)
                        <div class="skill-item">{{ $skill->name }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($resume->languages && count($resume->languages) > 0)
            <div class="section">
                <h2 class="section-title">Languages</h2>
                <div class="languages-grid">
                    @foreach($resume->languages as $language)
                        <div class="language-item">{{ $language->name }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="section">
            <h2 class="section-title">No Resume Found</h2>
            <p>No resume has been created yet. Please create a resume to view it here.</p>
        </div>
    @endif
</body>
</html> 