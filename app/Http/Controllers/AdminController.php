<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Make sure this is added
use App\Models\Submission;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function createAssessor()
    {
        // Generate the next password based on the latest user
        $lastUser = User::latest('id')->first();
        $nextId = $lastUser ? $lastUser->id + 1 : 1;
        $defaultPassword = 'AS' . $nextId . '_123';

        return view('admin.create_assessor', compact('defaultPassword'));
    }

    public function approveReject()
    {
        return view('admin.approve-reject');
    }

    public function submissionOversight(Request $request)
    {
        $query = Submission::query()->with(['student']);

        // Filter
        if ($filter = $request->string('filter')->toString()) {
            match ($filter) {
                'pending'  => $query->where('status', 'pending'),
                'approved' => $query->where('status', 'approved'),
                'rejected' => $query->where('status', 'rejected'),
                // Treat flagged as any submission with a flag_reason
                'flagged'  => $query->whereNotNull('flag_reason')->where('flag_reason', '!=', ''),
                default    => null,
            };
        }

        // Search (title or student name)
        if ($term = $request->string('q')->toString()) {
            $query->where(function ($w) use ($term) {
                $w->where('document_title', 'like', "%{$term}%")
                  ->orWhereHas('student', function ($s) use ($term) {
                      $s->where('name', 'like', "%{$term}%")
                        ->orWhere('student_id', 'like', "%{$term}%");
                  });
            });
        }

        // Sort
        if ($sort = $request->string('sort')->toString()) {
            match ($sort) {
                'title'    => $query->orderBy('document_title'),
                'student'  => $query->join('students', 'submissions.student_id', '=', 'students.id')
                                     ->orderBy('students.name')
                                     ->select('submissions.*'),
                'category' => $query->orderBy('slea_section'),
                'status'   => $query->orderBy('status'),
                'date'     => $query->orderByDesc('submitted_at'),
                default    => $query->latest('submitted_at'),
            };
        } else {
            $query->latest('submitted_at');
        }

        $submissions = $query->paginate(10)->withQueryString();

        return view('admin.submission-oversight', compact('submissions'));
    }

    /**
     * Download a small placeholder PDF to demonstrate export.
     */
    public function exportSamplePdf(Request $request)
    {
        // Build the same filtered dataset as the panel, but limit to current page
        $query = Submission::query()->with(['student']);

        if ($filter = $request->string('filter')->toString()) {
            match ($filter) {
                'pending'  => $query->where('status', 'pending'),
                'approved' => $query->where('status', 'approved'),
                'rejected' => $query->where('status', 'rejected'),
                'flagged'  => $query->whereNotNull('flag_reason')->where('flag_reason', '!=', ''),
                default    => null,
            };
        }

        if ($term = $request->string('q')->toString()) {
            $query->where(function ($w) use ($term) {
                $w->where('document_title', 'like', "%{$term}%")
                  ->orWhereHas('student', function ($s) use ($term) {
                      $s->where('name', 'like', "%{$term}%")
                        ->orWhere('student_id', 'like', "%{$term}%");
                  });
            });
        }

        if ($sort = $request->string('sort')->toString()) {
            match ($sort) {
                'title'    => $query->orderBy('document_title'),
                'student'  => $query->join('students', 'submissions.student_id', '=', 'students.id')
                                     ->orderBy('students.name')
                                     ->select('submissions.*'),
                'category' => $query->orderBy('slea_section'),
                'status'   => $query->orderBy('status'),
                'date'     => $query->orderByDesc('submitted_at'),
                default    => $query->latest('submitted_at'),
            };
        } else {
            $query->latest('submitted_at');
        }

        $page = max(1, (int) $request->input('page', 1));
        $perPage = 10;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page)->withQueryString();
        $items = $paginator->items();

        // Render with Dompdf from a Blade view
        $html = view('admin.pdf.submissions', [
            'submissions' => $items,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="submission-export.pdf"',
        ]);
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    public function finalReview()
    {
        // For now, return the view without data
        // Later you can add logic to fetch students for final review from database
        return view('admin.final-review');
    }

    public function awardReport()
    {
        // For now, return the view without data
        // Later you can add logic to fetch award report data from database
        return view('admin.award-report');
    }

    /**
     * Export award report as PDF
     */
    public function exportAwardReport()
    {
        // Sample data matching the view
        $btvtedStudents = [
            ['id' => 1, 'name' => 'John Smith', 'student_id' => '2021-001', 'program' => 'BTVTED', 'points' => 85, 'status' => 'Tracking'],
            ['id' => 2, 'name' => 'Sarah Wilson', 'student_id' => '2021-002', 'program' => 'BTVTED', 'points' => 92, 'status' => 'For Final Review'],
            ['id' => 3, 'name' => 'Michael Brown', 'student_id' => '2021-003', 'program' => 'BTVTED', 'points' => 78, 'status' => 'SLEA Qualified'],
            ['id' => 4, 'name' => 'Lisa Garcia', 'student_id' => '2021-004', 'program' => 'BTVTED', 'points' => 89, 'status' => 'Tracking'],
            ['id' => 5, 'name' => 'David Lee', 'student_id' => '2021-005', 'program' => 'BTVTED', 'points' => 76, 'status' => 'For Final Review'],
            ['id' => 6, 'name' => 'Maria Rodriguez', 'student_id' => '2021-006', 'program' => 'BTVTED', 'points' => 94, 'status' => 'SLEA Qualified'],
            ['id' => 7, 'name' => 'James Wilson', 'student_id' => '2021-007', 'program' => 'BTVTED', 'points' => 82, 'status' => 'Tracking'],
            ['id' => 8, 'name' => 'Anna Martinez', 'student_id' => '2021-008', 'program' => 'BTVTED', 'points' => 87, 'status' => 'For Final Review'],
            ['id' => 9, 'name' => 'Robert Kim', 'student_id' => '2021-009', 'program' => 'BTVTED', 'points' => 91, 'status' => 'SLEA Qualified'],
            ['id' => 10, 'name' => 'Jennifer Chen', 'student_id' => '2021-010', 'program' => 'BTVTED', 'points' => 83, 'status' => 'Tracking']
        ];

        $bpedStudents = [
            ['id' => 11, 'name' => 'Emily Davis', 'student_id' => '2021-011', 'program' => 'BPED', 'points' => 88, 'status' => 'Tracking'],
            ['id' => 12, 'name' => 'David Miller', 'student_id' => '2021-012', 'program' => 'BPED', 'points' => 95, 'status' => 'SLEA Qualified'],
            ['id' => 13, 'name' => 'Lisa Anderson', 'student_id' => '2021-013', 'program' => 'BPED', 'points' => 82, 'status' => 'For Final Review'],
            ['id' => 14, 'name' => 'Mark Thompson', 'student_id' => '2021-014', 'program' => 'BPED', 'points' => 90, 'status' => 'SLEA Qualified'],
            ['id' => 15, 'name' => 'Rachel Green', 'student_id' => '2021-015', 'program' => 'BPED', 'points' => 79, 'status' => 'Tracking'],
            ['id' => 16, 'name' => 'Kevin White', 'student_id' => '2021-016', 'program' => 'BPED', 'points' => 86, 'status' => 'For Final Review'],
            ['id' => 17, 'name' => 'Amanda Taylor', 'student_id' => '2021-017', 'program' => 'BPED', 'points' => 93, 'status' => 'SLEA Qualified'],
            ['id' => 18, 'name' => 'Chris Johnson', 'student_id' => '2021-018', 'program' => 'BPED', 'points' => 81, 'status' => 'Tracking'],
            ['id' => 19, 'name' => 'Nicole Brown', 'student_id' => '2021-019', 'program' => 'BPED', 'points' => 89, 'status' => 'For Final Review'],
            ['id' => 20, 'name' => 'Ryan Davis', 'student_id' => '2021-020', 'program' => 'BPED', 'points' => 84, 'status' => 'Tracking']
        ];

        $allStudents = array_merge($btvtedStudents, $bpedStudents);

        // Render with Dompdf from a Blade view
        $html = view('admin.pdf.award-report', [
            'allStudents' => $allStudents,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="award-report-export.pdf"',
        ]);
    }

    public function systemMonitoring()
    {
        // Placeholder view for system monitoring and logs
        return view('admin.system-monitoring');
    }

    /**
     * Manage Account – list, filter, sort, search
     */
    public function manageAccount(Request $request)
    {
        $q = User::query();

        // Search
        if ($term = $request->string('q')->toString()) {
            $q->where(function ($w) use ($term) {
                $w->where('email', 'like', "%{$term}%")
                  ->orWhere('name',  'like', "%{$term}%");
            });
        }

        // Filter
        if ($filter = $request->string('filter')->toString()) {
            match ($filter) {
                'active'   => $q->where('is_disabled', false),
                'disabled' => $q->where('is_disabled', true),
                'new'      => $q->where('created_at', '>=', now()->subDays(7)),
                default    => null,
            };
        }

        // Sort
        if ($sort = $request->string('sort')->toString()) {
            match ($sort) {
                'name'       => $q->orderBy('name'),
                'date'       => $q->orderByDesc('created_at'),
                'status'     => $q->orderBy('is_disabled'),
                'last_login' => $q->orderByDesc('last_login_at'),
                default      => $q->latest('created_at'),
            };
        } else {
            $q->latest('created_at');
        }

        $users = $q->paginate(10);

        // IMPORTANT: this returns the blade below
        return view('admin.manage-account', compact('users'));
    }

    /**
     * Toggle enable/disable
     */
    public function toggleUser(User $user)
    {
        $user->is_disabled = ! (bool) $user->is_disabled;
        $user->save();

        $message = $user->is_disabled ? 'User disabled successfully.' : 'User enabled successfully.';

        if (request()->ajax()) {
            return response()->json(['message' => $message, 'status' => $user->is_disabled ? 'disabled' : 'active']);
        }

        return back()->with('status', $message);
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        $userName = $user->name ?? $user->email;
        $user->delete();

        $message = "User '{$userName}' deleted successfully.";

        if (request()->ajax()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('status', $message);
    }
}