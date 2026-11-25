@extends('layouts.admin')

@section('title', 'Kelola Aktivitas Wisata')
@section('page-title', 'Aktivitas Wisata')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-charcoal-soft dark:text-white/70">Kelola daftar aktivitas wisata yang dapat dilakukan pengunjung di Pantai Selat Baru.</p>
        <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-4 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah Aktivitas</span>
        </a>
    </div>

    <div class="overflow-x-auto border coastal-hairline bg-warm-white dark:bg-[#141f24]">
        <table class="w-full text-left text-sm">
            <thead class="border-b coastal-hairline bg-sand/50 text-[11px] font-semibold tracking-wider uppercase text-charcoal-soft dark:bg-[#182429] dark:text-white/65">
                <tr>
                    <th class="px-4 py-3.5">Foto</th>
                    <th class="px-4 py-3.5">Judul Aktivitas</th>
                    <th class="px-4 py-3.5">Waktu Ideal</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y coastal-hairline">
                @forelse($activities as $activity)
                    <tr class="hover:bg-sand/25 dark:hover:bg-white/5">
                        <td class="px-4 py-3">
                            @if($activity->image_url)
                                <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" class="h-12 w-18 border coastal-hairline object-cover">
                            @else
                                <span class="inline-flex h-12 w-18 items-center justify-center border coastal-hairline text-xs opacity-50">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $activity->title }}</p>
                            <p class="mt-0.5 text-xs text-charcoal-soft dark:text-white/60">{{ $activity->category }}</p>
                        </td>
                        <td class="px-4 py-3 text-xs">{{ $activity->best_time ?: '-' }}</td>
                        <td class="px-4 py-3 text-xs">
                            <span class="inline-block px-2 py-0.5 text-[11px] font-semibold {{ $activity->is_active ? 'bg-muted-green/15 text-muted-green dark:bg-turquoise-bright/15 dark:text-turquoise-bright' : 'bg-charcoal/10 text-charcoal-soft dark:bg-white/10 dark:text-white/50' }}">
                                {{ $activity->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.activities.edit', $activity) }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Edit</a>
                                <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}" data-confirm="Hapus aktivitas '{{ $activity->title }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-charcoal-soft dark:text-white/60">Belum ada aktivitas terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

