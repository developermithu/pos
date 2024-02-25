<?php

namespace App\Services;

use App\Enums\PaymentPaidBy;
use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    public function deletePurchase(Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            // Decrease product quantity
            // if ($purchase->status === PurchaseStatus::RECEIVED) {
            //     $purchase->items->each(function ($item) {
            //         $item->product->decrement('qty', $item->qty);
            //     });
            // }

            $purchase->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function restorePurchase(Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            // First restore the purchase then manipulate items
            $purchase->restore();

            // if ($purchase->status === PurchaseStatus::RECEIVED) {
            //     $purchase->items->each(function ($item) {
            //         $item->product->increment('qty', $item->qty);
            //     });
            // }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function forceDeletePurchase(Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            // Delete associated payments
            $purchase->payments()->forceDelete();
            $purchase->forceDelete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function bulkDeletePurchases(array $purchaseIds)
    {
        DB::beginTransaction();

        try {
            // Decrease product quantity
            // Purchase::whereIn('id', $purchaseIds)->get()->each(function ($purchase) {
            //     if ($purchase->status === PurchaseStatus::RECEIVED) {
            //         $purchase->items->each(function ($item) {
            //             $item->product->decrement('qty', $item->qty);
            //         });
            //     }
            // });

            // Delete the selected purchases
            Purchase::destroy($purchaseIds);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function destroyPurchasePayment(Payment $payment)
    {
        DB::beginTransaction();

        try {
            $paymentable = $payment->paymentable;

            // Subtract the payment amount from the purchase
            $paymentable->paid_amount -= $payment->amount;

            // Update payment_status based on paid_amount
            if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
                $paymentable->payment_status = PurchasePaymentStatus::PARTIAL->value;
            } elseif ($paymentable->paid_amount == 0) {
                $paymentable->payment_status = PurchasePaymentStatus::UNPAID->value;
            } elseif ($paymentable->paid_amount === $paymentable->total) {
                $paymentable->payment_status = PurchasePaymentStatus::PAID->value;
            }

            if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
                $paymentable->supplier->decrement('expense', $payment->amount);
            }

            // Save the changes
            $paymentable->save();
            $payment->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return false;
        }
    }

    public function restorePurchasePayment(Payment $payment)
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
                    $paymentable->payment_status = PurchasePaymentStatus::PARTIAL->value;
                } elseif ($paymentable->paid_amount == 0) {
                    $paymentable->payment_status = PurchasePaymentStatus::UNPAID->value;
                } elseif ($paymentable->paid_amount === $paymentable->total) {
                    $paymentable->payment_status = PurchasePaymentStatus::PAID->value;
                }

                if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
                    $paymentable->supplier->increment('expense', $payment->amount);
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
