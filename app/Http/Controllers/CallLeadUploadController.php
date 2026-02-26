<?php

namespace App\Http\Controllers;

use App\Models\CallLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallLeadUploadController extends Controller
{
        public function index()
    {
        $perPage = 25;

        $leadsQuery = \App\Models\CallLead::orderByDesc('id');

        $total = (clone $leadsQuery)->count(); // total rows in DB

        $leads = $leadsQuery->paginate($perPage)->withQueryString();

        return view('user.pages.uploadcsv', compact('leads', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:10240'], // 10MB
        ]);

        $path = $request->file('csv')->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return back()->with('error', 'Unable to read CSV file.');
        }

        $rawHeader = fgetcsv($handle);
        if (!$rawHeader) {
            fclose($handle);
            return back()->with('error', 'CSV file is empty.');
        }

        // Remove UTF-8 BOM from first cell if present (Excel issue)
        if (isset($rawHeader[0])) {
            $rawHeader[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string)$rawHeader[0]);
        }

        // Normalize potential header values
        $normalized = array_map(function ($h) {
            $h = strtolower(trim((string)$h));
            $h = str_replace([' ', '-'], '_', $h);
            return $h;
        }, $rawHeader);

        // Accept common header variations
        $aliases = [
            'firstname' => 'first_name',
            'first' => 'first_name',
            'first_name' => 'first_name',

            'lastname' => 'last_name',
            'last' => 'last_name',
            'last_name' => 'last_name',

            'phone' => 'phone',
            'phonenumber' => 'phone',
            'phone_number' => 'phone',
            'mobile' => 'phone',
        ];

        // Convert normalized header fields to canonical names if they match aliases
        $finalHeader = [];
        foreach ($normalized as $h) {
            $key = str_replace('_', '', $h); // firstname / lastname / phonenumber
            $finalHeader[] = $aliases[$key] ?? $h;
        }

        // Detect whether first row is a header row
        $hasHeader = in_array('first_name', $finalHeader, true)
            && in_array('last_name', $finalHeader, true)
            && in_array('phone', $finalHeader, true);

        $firstDataRow = null;

        if ($hasHeader) {
            // Map header -> index
            $map = array_flip($finalHeader);
        } else {
            // No header: assume fixed order and treat $rawHeader as first data row
            $map = [
                'first_name' => 0,
                'last_name'  => 1,
                'phone'      => 2,
            ];
            $firstDataRow = $rawHeader;
        }

        $created = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            // If no header, process the first row as data
            if ($firstDataRow !== null) {
                $result = $this->importRow($firstDataRow, $map);
                $result ? $created++ : $skipped++;
            }

            // Process remaining rows
            while (($row = fgetcsv($handle)) !== false) {
                $result = $this->importRow($row, $map);
                $result ? $created++ : $skipped++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        } finally {
            fclose($handle);
        }

        return back()->with('success', "Imported successfully. Created: {$created}. Skipped: {$skipped}.");
    }

    /**
     * Import a single CSV row.
     * Returns true if created, false if skipped.
     */
    private function importRow(array $row, array $map): bool
    {
        $first = trim((string)($row[$map['first_name']] ?? ''));
        $last  = trim((string)($row[$map['last_name']] ?? ''));
        $phone = trim((string)($row[$map['phone']] ?? ''));

        if ($first === '' || $last === '' || $phone === '') {
            return false;
        }

        // Minimal phone cleanup (MVP)
        $phone = preg_replace('/\s+/', '', $phone);

        CallLead::create([
            'first_name' => $first,
            'last_name'  => $last,
            'phone'      => $phone,
            'status'     => 'pending',
            'call_date'  => null,
        ]);

        return true;
    }
}