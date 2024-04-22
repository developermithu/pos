<?php

namespace App\Services;

use App\Enums\PaymentPaidBy;
use App\Enums\SalePaymentStatus;
use App\Enums\SaleStatus;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleService
{
    public function deleteSale(Sale $sale)
    {
        DB::beginTransaction();

        try {
            // Increase product quantity if the sale product is not delivered
            if ($sale->status !== SaleStatus::DELIVERED) {
                $sale->items->each(function ($item) {
                    $item->product->increment('qty', $item->qty);
                });
            }

             // If paid by deposit
            if ($sale->payment_status === SalePaymentStatus::PAID && $sale->paid_amount === $sale->total && $sale->payments->isEmpty()) {
                $sale->customer->decrement('expense', $sale->paid_amount);
            }

            $sale->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function restoreSale(Sale $sale)
    {
        DB::beginTransaction();

        try {
            // First restore the sale then manipulate items
            $sale->restore();

             // If paid by deposit
            if ($sale->payment_status === SalePaymentStatus::PAID && $sale->paid_amount === $sale->total && $sale->payments->isEmpty()) {
                $sale->customer->increment('expense', $sale->paid_amount);
            }

            if ($sale->status !== SaleStatus::DELIVERED) {
                $sale->items->each(function ($item) {
                    $item->product->decrement('qty', $item->qty);
                });
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function forceDeleteSale(Sale $sale)
    {
        DB::beginTransaction();

        try {
            // Delete associated payments
            $sale->payments()->forceDelete();
            $sale->forceDelete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    // public function bulkDeleteSales(array $saleIds)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Increase product quantity if the sale product is not delivered
    //         Sale::whereIn('id', $saleIds)->get()->each(function ($sale) {
    //             if ($sale->status !== SaleStatus::DELIVERED) {
    //                 $sale->items->each(function ($item) {
    //                     $item->product->increment('qty', $item->qty);
    //                 });
    //             }
    //         });

    //         // Delete the selected sales
    //         Sale::destroy($saleIds);

    //         DB::commit();

    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage());

    //         return false;
    //     }
    // }

    public function destroySalePayment(Payment $payment)
    {
        DB::beginTransaction();

        try {
            $paymentable = $payment->paymentable;

            // Subtract the payment amount from the sale
            $paymentable->paid_amount -= $payment->amount;

            // Update payment_status based on paid_amount
            if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
                $paymentable->payment_status = SalePaymentStatus::PARTIAL->value;
            } elseif ($paymentable->paid_amount == 0) {
                $paymentable->payment_status = SalePaymentStatus::DUE->value;
            } elseif ($paymentable->paid_amount === $paymentable->total) {
                $paymentable->payment_status = SalePaymentStatus::PAID->value;
            }

            if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
                $paymentable->customer->decrement('expense', $payment->amount);
            }

            // Save the changes to the paymentable model
            $paymentable->save();

            // Delete the payment
            $payment->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function restoreSalePayment(Payment $payment)
    {
        DB::beginTransaction();

        try {
            $paymentable = $payment->paymentable;

            // Check if restoring the payment won't clear the entire balance
            if ($paymentable->total >= $paymentable->paid_amount + $payment->amount) {

                // Addition of the payment amount to the purchase
                $paymentable->paid_amount += $payment->amount;

                // Update payment_status based on paid_amount
                if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
                    $paymentable->payment_status = SalePaymentStatus::PARTIAL->value;
                } elseif ($paymentable->paid_amount == 0) {
                    $paymentable->payment_status = SalePaymentStatus::DUE->value;
                } elseif ($paymentable->paid_amount === $paymentable->total) {
                    $paymentable->payment_status = SalePaymentStatus::PAID->value;
                }

                if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
                    $paymentable->customer->increment('expense', $payment->amount);
                }

                // Save the changes
                $paymentable->save();
                $payment->restore();

                DB::commit();

                return true;
            } else {
                DB::rollBack();

                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }
}
