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