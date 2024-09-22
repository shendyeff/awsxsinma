@extends('layouts.master', ['title' => 'Barang Keluar'])

@section('content')
<x-container>
    <div class="col-12">
        <!-- Tombol Cetak PDF di atas judul -->
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('report-daftarBarangKeluar.pdf') }}" class="btn btn-primary">Cetak PDF</a>
        </div>

        <!-- Kartu dengan judul "DAFTAR BARANG KELUAR" -->
        <x-card title="DAFTAR BARANG KELUAR" class="card-body p-0">
            <x-table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Customer</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Kuantitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $i => $transaction)
                    <tr>
                        <td>{{ $i + $transactions->firstItem() }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>
                            <ul>
                                @foreach ($transaction->details as $details)
                                <li>{{ $details->product->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach ($transaction->details as $details)
                                <li>{{ $details->product->category->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach ($transaction->details as $details)
                                <li>{{ $details->quantity }} - {{ $details->product->unit }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="font-weight-bold text-uppercase">
                            Total Barang Keluar
                        </td>
                        <td class="font-weight-bold text-danger text-right">
                            {{ $grandQuantity }} Barang
                        </td>
                    </tr>
                </tbody>
            </x-table>
        </x-card>

        <!-- Pagination -->
        <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
    </div>
</x-container>
@endsection