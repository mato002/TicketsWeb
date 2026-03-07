<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['event', 'user'])
            ->whereNotNull('payment_details')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(20);

        // Calculate statistics
        $allTransactions = Booking::whereNotNull('payment_details')->get();
        $totalTransactions = $allTransactions->count();
        $totalRevenue = $allTransactions->where('status', 'confirmed')->sum('total_amount');
        $pendingTransactions = $allTransactions->where('status', 'pending')->count();
        $refundedTransactions = $allTransactions->where('status', 'cancelled')->count();

        return view('admin.payments.index', compact(
            'transactions',
            'totalTransactions',
            'totalRevenue',
            'pendingTransactions',
            'refundedTransactions'
        ));
    }

    public function details($transactionId)
    {
        $transaction = Booking::with(['event', 'user'])
            ->findOrFail($transactionId);

        $paymentDetails = json_decode($transaction->payment_details ?? '{}', true);

        return view('admin.payments.details', compact('transaction', 'paymentDetails'));
    }

    public function receipt($transactionId)
    {
        $transaction = Booking::with(['event', 'user'])
            ->findOrFail($transactionId);

        $paymentDetails = json_decode($transaction->payment_details ?? '{}', true);

        return view('admin.payments.receipt', compact('transaction', 'paymentDetails'));
    }

    public function info($transactionId)
    {
        $transaction = Booking::findOrFail($transactionId);

        return response()->json([
            'amount' => $transaction->total_amount,
            'status' => $transaction->status,
            'payment_method' => $transaction->payment_method
        ]);
    }

    public function markAsCompleted(Request $request, $transactionId)
    {
        $transaction = Booking::findOrFail($transactionId);

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending transactions can be marked as completed.'
            ], 400);
        }

        try {
            $transaction->update([
                'status' => 'confirmed',
                'confirmed_at' => now()
            ]);

            Log::info('Transaction marked as completed by admin', [
                'transaction_id' => $transactionId,
                'admin_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaction marked as completed successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to mark transaction as completed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction status.'
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $query = Booking::with(['event', 'user'])
            ->whereNotNull('payment_details')
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        $csvData = [];
        $csvData[] = [
            'Transaction ID',
            'Booking Reference',
            'Customer Name',
            'Customer Email',
            'Event',
            'Amount',
            'Payment Method',
            'Status',
            'Date'
        ];

        foreach ($transactions as $transaction) {
            $paymentDetails = json_decode($transaction->payment_details ?? '{}', true);
            $csvData[] = [
                $transaction->transaction_id ?? $transaction->mpesa_receipt ?? 'N/A',
                $transaction->booking_reference,
                $transaction->customer_name,
                $transaction->customer_email,
                $transaction->event->title ?? 'N/A',
                $transaction->total_amount,
                $transaction->payment_method ?? 'credit_card',
                $transaction->status,
                $transaction->created_at->format('Y-m-d H:i:s')
            ];
        }

        $filename = 'payment_transactions_' . date('Y-m-d_H-i-s') . '.csv';
        
        $handle = fopen('php://output', 'w');
        fputcsv($handle, $csvData[0]);
        
        for ($i = 1; $i < count($csvData); $i++) {
            fputcsv($handle, $csvData[$i]);
        }
        
        fclose($handle);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        exit;
    }
}
