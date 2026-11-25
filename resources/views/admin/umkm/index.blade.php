@extends('layouts.admin')

@section('title', 'Kelola UMKM Lokal')
@section('page-title', 'Direktori UMKM & Kuliner Lokal')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-charcoal-soft dark:text-white/70">Kelola data pedagang, warung pesisir, dan usaha mikro sekitar Pantai Selat Baru.</p>
        <a href="{{ route('admin.umkm.create') }}" class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-4 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah UMKM</span>
        </a>
    </div>

    <div class="overflow-x-auto border coastal-hairline bg-warm-white dark:bg-[#141f24]">
        <table class="w-full text-left text-sm">
            <thead class="border-b coastal-hairline bg-sand/50 text-[11px] font-semibold tracking-wider uppercase text-charcoal-soft dark:bg-[#182429] dark:text-white/65">
                <tr>
                    <th class="px-4 py-3.5">Foto</th>
                    <th class="px-4 py-3.5">Nama Usaha</th>
                    <th class="px-4 py-3.5">Jenis Produk</th>
                    <th class="px-4 py-3.5">Kontak</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y coastal-hairline">
                @forelse($umkmList as $item)
                    <tr class="hover:bg-sand/25 dark:hover:bg-white/5">
                        <td class="px-4 py-3">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->business_name }}" class="h-12 w-18 border coastal-hairline object-cover">
                            @else
                                <span class="inline-flex h-12 w-18 items-center justify-center border coastal-hairline bg-sand/40 text-[10px] text-charcoal-soft dark:bg-[#182429] dark:text-white/50">Belum Ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $item->business_name }}</p>
                            <p class="mt-0.5 text-xs text-charcoal-soft dark:text-white/60">{{ $item->location_note ?: '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-xs">{{ $item->product_type }}</td>
                        <td class="px-4 py-3 text-xs">{{ $item->contact_info ?: 'Belum diisi' }}</td>
                        <td class="px-4 py-3 text-xs">
                            <span class="inline-block px-2 py-0.5 text-[11px] font-semibold {{ $item->is_active ? 'bg-muted-green/15 text-muted-green dark:bg-turquoise-bright/15 dark:text-turquoise-bright' : 'bg-charcoal/10 text-charcoal-soft dark:bg-white/10 dark:text-white/50' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.umkm.edit', $item) }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Edit</a>
                                <form method="POST" action="{{ route('admin.umkm.destroy', $item) }}" data-confirm="Hapus data UMKM '{{ $item->business_name }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-charcoal-soft dark:text-white/60">Belum ada data UMKM.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

