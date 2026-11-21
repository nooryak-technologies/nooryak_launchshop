<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class PorductOrderExport implements FromCollection, WithHeadings, WithMapping
{
    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->orders;
    }

    public function map($orders): array
    {
        return [
            $orders->order_number,
            $orders->billing_fname,
            $orders->billing_email,
            $orders->billing_number,
            $orders->billing_city,
            $orders->billing_country,
            $orders->shipping_fname,
            $orders->shipping_email,
            $orders->shipping_number,
            $orders->shipping_city,
            $orders->shipping_country,
            ucfirst($orders->method),
            $orders->shipping_method ? $orders->shipping_method : '-',
            $orders->payment_status,
            $orders->order_status,
            '₹' . number_format($orders->cart_total, 2) . ' INR',
            '₹' . number_format($orders->discount, 2) . ' INR',
            '₹' . number_format($orders->tax, 2) . ' INR',
            '₹' . number_format($orders->shipping_charge, 2) . ' INR',
            '₹' . number_format($orders->total, 2) . ' INR',
            $orders->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Billing Name',
            'Billing Email',
            'Billing Phone',
            'Billing City',
            'Billing Country',
            'Shipping Name',
            'Shipping Email',
            'Shipping Phone',
            'Shipping City',
            'Shipping Country',
            'Gateway',
            'Shipping Method',
            'Payment Status',
            'Order Status',
            'Cart Total',
            'Discount',
            'GST Tax',
            'Shipping Charge',
            'Total',
            'Date'
        ];
    }
}
