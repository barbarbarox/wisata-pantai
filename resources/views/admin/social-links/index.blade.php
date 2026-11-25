@extends('layouts.admin')

@section('title', 'Kelola Media Sosial')
@section('page-title', 'Tautan Media Sosial')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-charcoal-soft dark:text-white/70">Kelola tautan kanal resmi yang ditampilkan pada bagian footer website.</p>
        <a href="{{ route('admin.social-links.create') }}" class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-4 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah Tautan</span>
        </a>
    </div>

    <div class="overflow-x-auto border coastal-hairline bg-warm-white dark:bg-[#141f24]">
        <table class="w-full text-left text-sm">
            <thead class="border-b coastal-hairline bg-sand/50 text-[11px] font-semibold tracking-wider uppercase text-charcoal-soft dark:bg-[#182429] dark:text-white/65">
                <tr>
                    <th class="px-4 py-3.5">Platform</th>
                    <th class="px-4 py-3.5">Label</th>
                    <th class="px-4 py-3.5">URL</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y coastal-hairline">
                @forelse($socialLinks as $social)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $social->platform }}</td>
                        <td class="px-4 py-3 text-xs">{{ $social->label }}</td>
                        <td class="px-4 py-3 text-xs text-ocean underline dark:text-turquoise-bright">
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer">{{ $social->url }}</a>
                        </td>
                        <td class="px-4 py-3 text-xs">{{ $social->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.social-links.edit', $social) }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Edit</a>
                                <form method="POST" action="{{ route('admin.social-links.destroy', $social) }}" data-confirm="Hapus tautan '{{ $social->platform }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-charcoal-soft dark:text-white/60">Belum ada tautan media sosial.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

