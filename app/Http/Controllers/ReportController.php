<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Expense;

class ReportController extends Controller
{
    public function daily(){
        $date = $request->date ?? Carbon::today()->format('Y-m-d');

        $appointments = Appointment::with('pet')
            ->whereDate('appointment_date', $date)
            ->where('status', 'Completada')
            ->get();

        $total = $appointments->sum('price');
        
        return view('reports.daily', compact('appointments', 'date', 'total'));
    }

    public function dailyAjax(Request $request)
    {
        $date = $request->date;

        $appointments = Appointment::with('pet.client')
            ->whereDate('appointment_date', $date)
            ->where('status', 'Completada')
            ->get();

        $total = $appointments->sum('price');

       $payments = $appointments
        ->where('status', 'Completada')
        ->groupBy(function ($item) {

            if (in_array($item->payment_method, ['Nequi', 'Llave_nequi'])) {
                return 'Nequi';
            }

            if (in_array($item->payment_method, ['Daviplata', 'Llave_daviplata'])) {
                return 'Daviplata';
            }

            return $item->payment_method;
        })
        ->map(function ($items) {
            return $items->sum('price');
        });
        
        return response()->json([
            'appointments' => $appointments,
            'total' => number_format($total,0,',','.'),
            'payments' => $payments
        ]);
    }

    public function expense(){
        $expenses = Expense::get();

        return view('reports.expenses', compact('expenses'));
    }

    public function store_expense(Request $request)
    {
        $rules = [
            'description' => 'required',
            'amount' => 'required',
            'expense_date' => 'required',
        ];

        $messages = [
            'description.required' => 'La descripción es obligatoria',
            'amount.required' => 'El precio es obligatorio',
            'expense_date.required' => 'La fecha es obligatoria',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $expense = new Expense();
            $expense->description = $validatedData['description'];
            $expense->amount = $validatedData['amount'];
            $expense->expense_date = $validatedData['expense_date'];
            $expense->save();

            DB::commit();

            return redirect()->route('report.expenses')->with('success', 'Gasto creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear el gasto');
        }
    }

    public function update_expense(Request $request)
    {
        $rules = [
            'description' => 'required',
            'amount' => 'required',
            'expense_date' => 'required',
        ];

        $messages = [
            'description.required' => 'La descripción es obligatoria',
            'amount.required' => 'El precio es obligatorio',
            'expense_date.required' => 'La fecha es obligatoria',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $expense = Expense::findOrFail($request->input('id'));
            $expense->description = $validatedData['description'];
            $expense->amount = $validatedData['amount'];
            $expense->expense_date = $validatedData['expense_date'];
            $expense->save();

            DB::commit();

            return redirect()->route('report.expenses')->with('success', 'Gasto editado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al editar el gasto');
        }
    }

    public function delete_expense($id){
        try {
            DB::beginTransaction();

            $expense = Expense::findOrFail($id);
            $expense->delete();

            DB::commit();

            return redirect()->route('report.expenses')->with('success', 'Gasto eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar el gasto');
        }
    }

    public function monthly(Request $request)
    {
        $month = $request->month ?? now()->format('m');
        $year  = $request->year ?? now()->format('Y');

        // INGRESOS
        $appointments = Appointment::whereMonth('appointment_date', $month)
            ->whereYear('appointment_date', $year)
            ->where('status', 'Completada')
            ->get();

        $total = $appointments->sum('price');
        $count = $appointments->count();

        // GASTOS DEL MES
        $expenses = Expense::whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->get();

        $totalExpenses = $expenses->sum('amount');

        // GANANCIA
        $profit = $total - $totalExpenses;

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        $dailyTotals = [];
        $dailyExpenses = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {

            // ingresos por día
            $incomeDay = Appointment::whereDay('appointment_date', $day)
                ->whereMonth('appointment_date', $month)
                ->whereYear('appointment_date', $year)
                ->where('status', 'Completada')
                ->sum('price');

            // gastos por día
            $expenseDay = Expense::whereDay('expense_date', $day)
                ->whereMonth('expense_date', $month)
                ->whereYear('expense_date', $year)
                ->sum('amount');

            $dailyTotals[]   = $incomeDay;
            $dailyExpenses[] = $expenseDay;
        }

        $payments = Appointment::whereMonth('appointment_date', $month)
        ->whereYear('appointment_date', $year)
        ->where('status', 'Completada')
        ->selectRaw("
            CASE
                WHEN payment_method IN ('Nequi', 'Llave_nequi') THEN 'Nequi'
                WHEN payment_method IN ('Daviplata', 'Llave_daviplata') THEN 'Daviplata'
                ELSE payment_method
            END as payment_group,
            SUM(price) as total
        ")
        ->groupBy('payment_group')
        ->pluck('total', 'payment_group');

        return view('reports.monthly', compact(
            'month',
            'year',
            'total',
            'count',
            'totalExpenses',
            'profit',
            'dailyTotals',
            'dailyExpenses',
            'daysInMonth',
            'payments'
        ));
    }
    public function finance(Request $request)
    {
        $year = $request->year ?? now()->year;

        $income = Appointment::whereYear('appointment_date', $year)
            ->where('status','Completada')
            ->sum('price');

        $expenses = Expense::whereYear('expense_date', $year)
            ->sum('amount');

        $profit = $income - $expenses;

        $monthlyIncome = [];
        $monthlyExpenses = [];

        for($month=1;$month<=12;$month++){

            $monthlyIncome[] = Appointment::whereYear('appointment_date',$year)
                ->whereMonth('appointment_date',$month)
                ->where('status','Completada')
                ->sum('price');

            $monthlyExpenses[] = Expense::whereYear('expense_date',$year)
                ->whereMonth('expense_date',$month)
                ->sum('amount');
        }

        return view('reports.finance', compact(
            'year',
            'income',
            'expenses',
            'profit',
            'monthlyIncome',
            'monthlyExpenses'
        ));
    }
}
