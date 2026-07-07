<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Expense;
use App\Models\DepartmentalExpense;
use App\Models\ActivityLog;

class FormsController extends Controller
{
    /**
     * Find the next available ARCS control number for the given month/year
     * by scanning the departmental_expenses table (including soft-deleted
     * rows so numbers are never reused). Shared by the preview endpoint and
     * the actual submit endpoint so the number shown on-screen always
     * matches the number that gets saved.
     */
    private function nextAvailableControlNumber(string $month, string $year): string
    {
        $count = 1;
        while (DepartmentalExpense::withTrashed()->where('control_number', sprintf('ARCS-%s-%03d-%s', $month, $count, $year))->exists()) {
            $count++;
        }
        return sprintf('ARCS-%s-%03d-%s', $month, $count, $year);
    }
    public function index()
    {
        $departments = Department::with('categories')->get();
        $requestorNames = \App\Models\CommissionRequest::whereNotNull('requestor_name')
            ->where('requestor_name', '!=', '')
            ->distinct()
            ->orderBy('requestor_name')
            ->pluck('requestor_name')
            ->toArray();

        // Data needed for the Site Visit Form tab
        try {
            $teams = \App\Models\SalesTeam::orderBy('team_name')->pluck('team_name');
        } catch (\Exception $e) {
            $teams = collect();
        }
        try {
            $properties = \Schema::hasTable('properties') ? \App\Models\Property::orderBy('name')->get() : collect();
        } catch (\Exception $e) {
            $properties = collect();
        }

        return view('forms', compact('departments', 'requestorNames', 'teams', 'properties'));
    }

    public function siteVisit()
    {
        // Site Visit Form now lives as a tab inside the main Forms page
        return redirect()->route('forms', ['tab' => 'site-visit']);
    }

    public function nextControlNumber(Request $request)
    {
        $month = now()->format('m');
        $year  = now()->format('y');

        // Preview only — this scans the same table/logic used at submit
        // time, so the number shown on the form matches what actually gets
        // saved (barring another submission landing in between).
        $controlNumber = $this->nextAvailableControlNumber($month, $year);

        return response()->json(['control_number' => $controlNumber]);
    }

    public function incrementControlNumber(Request $request)
    {
        $key = 'ctrl_num_' . now()->format('Y_m');
        $current = (int)(\DB::table('app_settings')->where('key', $key)->value('value') ?? 0);
        \DB::table('app_settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $current + 1, 'created_at' => now(), 'updated_at' => now()]
        );
        return response()->json(['ok' => true, 'next' => $current + 1]);
    }

    /**
     * Called when the Budget Request Form's "Print and Submit" button is
     * used. Saves the form as a new row in the "All Expenses" table
     * (departmental_expenses) with a freshly-assigned, unique control
     * number, then returns that control number so the front-end can show
     * it on the form before printing.
     */
    public function submitBudgetRequest(Request $request)
    {
        try {
            $validated = $request->validate([
                'requestor_name'          => 'required|string',
                'department'              => 'required|string',
                'category'                => 'required|string',
                'date_requested'          => 'nullable|date',
                'requested_amount'        => 'nullable|numeric|min:0',
                'date_released'           => 'nullable|date',
                'total_expenses'          => 'nullable|numeric|min:0',
                'amount_returned'         => 'nullable|numeric',
                'date_of_amount_returned' => 'nullable|date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        }

        foreach (['date_requested', 'date_released', 'date_of_amount_returned'] as $f) {
            if (empty($validated[$f])) {
                $validated[$f] = null;
            }
        }
        foreach (['total_expenses', 'amount_returned'] as $f) {
            if (empty($validated[$f])) {
                $validated[$f] = null;
            }
        }

        // Liquidated as soon as a total-expenses figure has been filled in
        // on the liquidation report portion of the form.
        $validated['status'] = (!empty($validated['total_expenses']) && $validated['total_expenses'] > 0)
            ? 'LIQUIDATED'
            : 'NOT YET LIQUIDATED';

        if (!empty($validated['total_expenses']) && $validated['total_expenses'] > 0 && !empty($validated['requested_amount'])) {
            $validated['amount_returned'] = $validated['requested_amount'] - $validated['total_expenses'];
        }

        $month = now()->format('m');
        $year  = now()->format('y');

        $departmentalExpense = null;
        $controlNumber = null;

        \DB::transaction(function () use (&$departmentalExpense, &$controlNumber, $validated, $month, $year) {
            $controlNumber = $this->nextAvailableControlNumber($month, $year);
            $data = $validated;
            $data['control_number'] = $controlNumber;
            $departmentalExpense = DepartmentalExpense::create($data);
        });

        ActivityLog::log(
            'create',
            'Departmental Expenses',
            "Budget Request Form submitted: '{$validated['category']}' for {$validated['department']} by {$validated['requestor_name']} (₱" . number_format($validated['requested_amount'] ?? 0, 2) . ") [{$controlNumber}]"
        );

        return response()->json([
            'success'        => true,
            'control_number' => $controlNumber,
            'data'           => $departmentalExpense,
        ]);
    }
}