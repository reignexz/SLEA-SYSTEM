<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Submission;
use App\Models\Document;
use App\Models\User;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample students
        $students = [
            [
                'student_id' => '2021-12345',
                'name' => 'DELA CRUZ, Juan M.',
                'email' => 'juan.delacruz@student.edu',
                'program' => 'Bachelor of Science in Computer Science',
                'year_level' => '4th Year',
                'contact_number' => '09123456789',
            ],
            [
                'student_id' => '2021-67890',
                'name' => 'SANTOS, Maria A.',
                'email' => 'maria.santos@student.edu',
                'program' => 'Bachelor of Science in Business Administration',
                'year_level' => '3rd Year',
                'contact_number' => '09123456788',
            ],
            [
                'student_id' => '2021-54321',
                'name' => 'GARCIA, Pedro L.',
                'email' => 'pedro.garcia@student.edu',
                'program' => 'Bachelor of Science in Engineering',
                'year_level' => '4th Year',
                'contact_number' => '09123456787',
            ],
            [
                'student_id' => '2021-98765',
                'name' => 'RODRIGUEZ, Ana S.',
                'email' => 'ana.rodriguez@student.edu',
                'program' => 'Bachelor of Arts in Psychology',
                'year_level' => '3rd Year',
                'contact_number' => '09123456786',
            ],
            [
                'student_id' => '2021-11111',
                'name' => 'MARTINEZ, Carlos R.',
                'email' => 'carlos.martinez@student.edu',
                'program' => 'Bachelor of Science in Information Technology',
                'year_level' => '4th Year',
                'contact_number' => '09123456785',
            ],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Get the first user as assessor (your teammate will handle user creation)
        $assessor = User::first();
        if (!$assessor) {
            // Create a basic user if none exists
            $assessor = User::create([
                'name' => 'Sample User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'position' => 'Assessor',
                'phone' => '09123456784',
            ]);
        }

        // Create sample submissions
        $submissions = [
            [
                'student_id' => Student::where('student_id', '2021-12345')->first()->id,
                'assigned_assessor_id' => $assessor->id,
                'document_title' => 'Leadership Portfolio',
                'slea_section' => 'Leadership Excellence',
                'subsection' => 'Student Leadership',
                'role_in_activity' => 'President',
                'activity_date' => '2024-01-10',
                'organizing_body' => 'Student Council',
                'description' => 'Served as President of the Student Council for the academic year 2023-2024. Led various initiatives including campus improvements and student welfare programs.',
                'submitted_at' => now()->subDays(2),
            ],
            [
                'student_id' => Student::where('student_id', '2021-67890')->first()->id,
                'assigned_assessor_id' => $assessor->id,
                'document_title' => 'Community Service Report',
                'slea_section' => 'Community Engagement',
                'subsection' => 'Volunteer Work',
                'role_in_activity' => 'Coordinator',
                'activity_date' => '2024-01-09',
                'organizing_body' => 'Community Outreach',
                'description' => 'Coordinated community service activities including feeding programs and environmental clean-up drives.',
                'submitted_at' => now()->subDays(1),
            ],
            [
                'student_id' => Student::where('student_id', '2021-54321')->first()->id,
                'assigned_assessor_id' => $assessor->id,
                'document_title' => 'Academic Excellence Portfolio',
                'slea_section' => 'Academic Excellence',
                'subsection' => 'Research',
                'role_in_activity' => 'Lead Researcher',
                'activity_date' => '2024-01-08',
                'organizing_body' => 'Research Department',
                'description' => 'Conducted research on sustainable engineering practices and presented findings at regional conference.',
                'submitted_at' => now()->subHours(6),
            ],
            [
                'student_id' => Student::where('student_id', '2021-98765')->first()->id,
                'assigned_assessor_id' => $assessor->id,
                'document_title' => 'Leadership Development Plan',
                'slea_section' => 'Leadership Excellence',
                'subsection' => 'Leadership Training',
                'role_in_activity' => 'Facilitator',
                'activity_date' => '2024-01-07',
                'organizing_body' => 'Leadership Institute',
                'description' => 'Facilitated leadership training workshops for incoming student leaders.',
                'submitted_at' => now()->subHours(3),
            ],
            [
                'student_id' => Student::where('student_id', '2021-11111')->first()->id,
                'assigned_assessor_id' => $assessor->id,
                'document_title' => 'Innovation Project Proposal',
                'slea_section' => 'Innovation & Creativity',
                'subsection' => 'Project Development',
                'role_in_activity' => 'Project Lead',
                'activity_date' => '2024-01-06',
                'organizing_body' => 'Innovation Lab',
                'description' => 'Led development of a mobile application for campus navigation and information system.',
                'submitted_at' => now()->subHours(1),
            ],
        ];

        foreach ($submissions as $submissionData) {
            $submission = Submission::create($submissionData);
            
            // Create sample documents for each submission
            $documentTypes = ['pdf', 'jpg', 'png'];
            $fileNames = [
                'portfolio_document.pdf',
                'certificate.jpg',
                'evidence_photo.png',
                'report_document.pdf'
            ];
            
            // Create 1-3 documents per submission
            $numDocuments = rand(1, 3);
            for ($i = 0; $i < $numDocuments; $i++) {
                $fileType = $documentTypes[array_rand($documentTypes)];
                $fileName = $fileNames[array_rand($fileNames)];
                
                Document::create([
                    'submission_id' => $submission->id,
                    'original_filename' => $fileName,
                    'stored_filename' => 'sample_' . $submission->id . '_' . $i . '.' . $fileType,
                    'file_path' => 'submissions/sample_' . $submission->id . '_' . $i . '.' . $fileType,
                    'file_type' => $fileType,
                    'file_size' => rand(100000, 5000000), // 100KB to 5MB
                    'mime_type' => $fileType === 'pdf' ? 'application/pdf' : 'image/' . $fileType,
                ]);
            }
        }
    }
}
