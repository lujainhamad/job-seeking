# Database Seeders Documentation

This document describes the seeders created for the job-seeking application.

## Overview

The seeders create a complete test environment with:
- **3 Companies** with realistic data
- **6 Job Offers** (2 per company) with varied requirements
- **3 Users** for testing
- **3 Resumes** with experiences, skills, and languages
- **9 Job Applications** with different statuses and interview dates
- **Job-Skill-Language relationships** for compatibility testing

## Seeders Created

### 1. CompanySeeder
Creates 3 companies with realistic business data.

**Companies Created:**
- **TechCorp Solutions** - Technology company
- **Global Innovations Ltd** - Innovation-focused company  
- **Digital Dynamics** - Digital services company

**Login Credentials:**
- Email: `hr@techcorp.com`, `careers@globalinnovations.com`, `jobs@digitaldynamics.com`
- Password: `password123` (for all companies)

### 2. UserSeeder
Creates 3 users for testing the application.

**Users Created:**
- **John Smith** - `john.smith@email.com`
- **Sarah Johnson** - `sarah.johnson@email.com`
- **Michael Chen** - `michael.chen@email.com`

**Login Credentials:**
- Password: `password123` (for all users)

### 3. ResumeSeeder
Creates 3 resumes (1 per user) with comprehensive experience, skills, and language data.

**Resumes Created:**

#### John Smith - Senior Software Engineer
- **Title:** Senior Software Engineer Resume
- **Main Field:** Software Development
- **Second Field:** Web Development
- **Experience:** 3 positions (Senior Software Engineer, Full Stack Developer, Junior Developer)
- **Skills:** JavaScript, React, Node.js, TypeScript, Git, Docker, MongoDB, Express.js
- **Languages:** English, Spanish
- **Education:** Computer Science, Software Engineering

#### Sarah Johnson - Data Scientist
- **Title:** Data Scientist Resume
- **Main Field:** Data Science
- **Second Field:** Machine Learning
- **Experience:** 2 positions (Data Scientist, Data Analyst)
- **Skills:** Python, R, Machine Learning, Statistics, SQL, Tableau, Pandas, Scikit-learn
- **Languages:** English, French
- **Education:** Data Science, Statistics

#### Michael Chen - Product Manager
- **Title:** Product Manager Resume
- **Main Field:** Product Management
- **Second Field:** Business Strategy
- **Experience:** 3 positions (Senior Product Manager, Product Manager, Business Analyst)
- **Skills:** Product Strategy, User Research, Agile, Analytics, Communication, JIRA, Figma, SQL
- **Languages:** English, German
- **Education:** Business Administration, Marketing

### 4. JobSeeder
Creates 6 job offers (2 per company) with realistic job requirements.

**Jobs Created:**

#### TechCorp Solutions:
1. **Senior Software Engineer**
   - Salary: $120,000
   - Experience: 5 years
   - Level: Senior
   - Requirements: JavaScript, React, Node.js, microservices

2. **Junior Frontend Developer**
   - Salary: $65,000
   - Experience: 1 year
   - Level: Junior
   - Requirements: HTML, CSS, JavaScript, React

#### Global Innovations Ltd:
3. **Data Scientist**
   - Salary: $95,000
   - Experience: 3 years
   - Level: Middle
   - Requirements: Python, R, Machine Learning, Statistics

4. **Product Manager**
   - Salary: $110,000
   - Experience: 4 years
   - Level: Senior
   - Requirements: Product Strategy, User Research, Agile

#### Digital Dynamics:
5. **DevOps Engineer**
   - Salary: $85,000
   - Experience: 3 years
   - Level: Middle
   - Requirements: AWS, Docker, Kubernetes, CI/CD

6. **UX/UI Designer**
   - Salary: $75,000
   - Experience: 2 years
   - Level: Middle
   - Requirements: Figma, Adobe Creative Suite, User Research

### 5. JobRelationsSeeder
Establishes relationships between jobs and their required skills/languages.

**Features:**
- Links jobs to relevant skills based on job title
- Links jobs to required languages
- Creates realistic job requirements for compatibility testing

### 6. JobApplicationSeeder
Creates job applications with different statuses and interview dates.

**Applications Created:**

#### John Smith (Software Engineer)
- **Senior Software Engineer at TechCorp** - Approved, Interview in 7 days
- **Junior Frontend Developer at TechCorp** - Rejected
- **DevOps Engineer at Digital Dynamics** - Pending, Interview in 14 days

#### Sarah Johnson (Data Scientist)
- **Data Scientist at Global Innovations** - Approved, Interview in 5 days
- **Product Manager at Global Innovations** - Pending, Interview in 10 days
- **UX/UI Designer at Digital Dynamics** - Rejected

#### Michael Chen (Product Manager)
- **Product Manager at Global Innovations** - Approved, Interview in 3 days
- **Senior Software Engineer at TechCorp** - Rejected
- **DevOps Engineer at Digital Dynamics** - Pending, Interview in 12 days

**Application Statuses:**
- **Approved:** 3 applications (with interview dates)
- **Pending:** 3 applications (with future interview dates)
- **Rejected:** 3 applications (no interview dates)

## Running the Seeders

### Run All Seeders:
```bash
php artisan db:seed
```

### Run Individual Seeders:
```bash
php artisan db:seed --class=CompanySeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ResumeSeeder
php artisan db:seed --class=JobSeeder
php artisan db:seed --class=JobRelationsSeeder
php artisan db:seed --class=JobApplicationSeeder
```

### Fresh Database with Seeders:
```bash
php artisan migrate:fresh --seed
```

## Seeder Dependencies

The seeders must be run in the following order:
1. `AdminSeeder` (existing)
2. `EducationSeeder` (existing)
3. `SkillSeeder` (existing)
4. `LanguageSeeder` (existing)
5. `CompanySeeder` (new)
6. `UserSeeder` (new)
7. `ResumeSeeder` (new)
8. `JobSeeder` (new)
9. `JobRelationsSeeder` (new)
10. `JobApplicationSeeder` (new)

## Data Structure

### Companies
- Name, email, password, address, active status

### Users
- Name, email, password, birthdate, phone

### Resumes
- User relationship, title, about section
- Main and secondary fields of expertise
- Multiple work experiences with descriptions
- Skills, languages, and education relationships

### Jobs
- Company relationship, education requirement
- Job title, salary, experience requirements
- Job type, level, gender preferences
- Application deadlines and requirements
- Weight factors for compatibility calculation

### Job Relationships
- Skills required for each job
- Languages required for each job

### Job Applications
- User-job relationships with application status
- Initial salary expectations
- Interview status (pending, approved, rejected)
- Interview dates for approved applications
- Employee approval status

## Testing Compatibility

With this data, you can test:
- Resume compatibility calculations
- Job matching algorithms
- User-company interactions
- Job application processes
- Interview scheduling and management
- Application status tracking
- Resume HTML view and PDF download functionality
- Complete end-to-end job application workflow

## Notes

- All passwords are set to `password123` for easy testing
- Companies are set as active by default
- Job deadlines are set to future dates
- Skills and languages are matched to realistic job requirements
- Weight factors are configured for the compatibility algorithm 