<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription Receipt - #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }
        .receipt-title {
            font-size: 18px;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .patient-info, .prescription-info {
            width: 100%;
            border-collapse: collapse;
        }
        .patient-info td, .prescription-info td {
            padding: 5px;
            vertical-align: top;
        }
        .patient-info td:first-child, .prescription-info td:first-child {
            width: 30%;
            font-weight: bold;
        }
        .medicine-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .medicine-table th {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }
        .medicine-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .signature {
            margin-top: 50px;
            width: 100%;
        }
        .signature td {
            text-align: center;
            padding-top: 50px;
        }
        .border-top {
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="hospital-name">RS DELTA SURYA</div>
        <div>Jl. Kesehatan No. 123, Jakarta</div>
        <div>Phone: (021) 12345678 | Email: info@rsdeltasurya.com</div>
        <div class="receipt-title">PRESCRIPTION RECEIPT</div>
    </div>

    <div class="section">
        <div class="section-title">Patient Information</div>
        <table class="patient-info">
            <tr>
                <td>Patient Name:</td>
                <td>{{ $prescription->examination->patient->name }}</td>
            </tr>
            <tr>
                <td>Medical Record Number:</td>
                <td>{{ $prescription->examination->patient->medical_record_number }}</td>
            </tr>
            <tr>
                <td>Date of Birth / Age:</td>
                <td>{{ $prescription->examination->patient->formatted_date_of_birth }} ({{ $prescription->examination->patient->age }} years)</td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>{{ ucfirst($prescription->examination->patient->gender) }}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td>{{ $prescription->examination->patient->address ?? '-' }}</td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>{{ $prescription->examination->patient->phone ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Prescription Information</div>
        <table class="prescription-info">
            <tr>
                <td>Prescription ID:</td>
                <td>#{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td>Examination Date:</td>
                <td>{{ $prescription->examination->formatted_examination_date }}</td>
            </tr>
            <tr>
                <td>Doctor:</td>
                <td>{{ $prescription->doctor->name }}</td>
            </tr>
            <tr>
                <td>Pharmacist:</td>
                <td>{{ $prescription->pharmacist->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Processed Date:</td>
                <td>{{ $prescription->formatted_processed_at ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{{ ucfirst($prescription->status) }}</td>
            </tr>
            <tr>
                <td>Notes:</td>
                <td>{{ $prescription->notes ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Medicine List</div>
        <table class="medicine-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Medicine Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->medicine_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>IDR {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>IDR {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $item->instructions ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                    <td colspan="2"><strong>IDR {{ number_format($prescription->total_price, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Payment Information</div>
        <table class="prescription-info">
            <tr>
                <td>Total Amount:</td>
                <td>IDR {{ number_format($prescription->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Payment Method:</td>
                <td>Cash</td>
            </tr>
            <tr>
                <td>Payment Date:</td>
                <td>{{ now()->format('d F Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="signature">
        <tr>
            <td>
                <div>Pharmacist</div>
                <div class="border-top"></div>
                <div>{{ $prescription->pharmacist->name ?? '_________________' }}</div>
            </td>
            <td>
                <div>Patient/Representative</div>
                <div class="border-top"></div>
                <div>_________________</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        This is a computer-generated receipt. No signature required.<br>
        Receipt generated on: {{ now()->format('d F Y H:i:s') }}<br>
        © {{ date('Y') }} RS Delta Surya. All rights reserved.
    </div>
</body>
</html>
