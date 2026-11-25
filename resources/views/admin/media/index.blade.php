@extends('layouts.admin')

@section('title', 'Pustaka Media')
@section('page-title', 'Pustaka & Pengelolaan Media')

@section('content')
    <div class="mb-8 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24]">
        <h2 class="font-editorial text-xl font-medium">Unggah Gambar ke Pustaka Aplikasi</h2>
        <p class="mt-1 text-xs text-charcoal-soft dark:text-white/60">
            Gambar yang diunggah di sini dapat langsung dipilih saat mengisi Hero, Spot Wisata, Aktivitas, UMKM, Galeri, atau Background Website.
        </p>

        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mt-4 flex flex-wrap items-end gap-4">
            @csrf
            <div class="min-w-[240px] flex-1">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Pilih File Gambar (JPG, PNG, WebP)</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required class="block w-full border coastal-hairline bg-white px-3 py-2 text-xs dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Kategori Folder</label>
                <select name="folder" class="rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-xs dark:bg-[#10171a]">
                    <option value="uploads">Umum (uploads)</option>
                    <option value="heroes">Hero</option>
                    <option value="spots">Spot Wisata</option>
                    <option value="activities">Aktivitas</option>
                    <option value="umkm">UMKM</option>
                    <option value="gallery">Galeri</option>
                    <option value="settings">Pengaturan</option>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-5 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                <i data-lucide="upload" class="h-4 w-4"></i>
                <span>Unggah Gambar</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($files as $file)
            <article class="flex flex-col justify-between border coastal-hairline bg-warm-white dark:bg-[#141f24]">
                <div>
                    <div class="aspect-[16/10] overflow-hidden border-b coastal-hairline bg-sand">
                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <div class="p-4 text-xs">
                        <p class="truncate font-semibold text-charcoal dark:text-white">{{ $file['name'] }}</p>
                        <p class="mt-0.5 font-mono text-[11px] text-charcoal-soft dark:text-white/55">{{ $file['path'] }} · {{ $file['size_kb'] }} KB</p>

                        <div class="mt-3">
                            @if(!empty($file['used_in']))
                                <p class="text-[10px] font-semibold tracking-wider uppercase text-muted-green dark:text-turquoise-bright">Digunakan pada:</p>
                                <ul class="mt-1 space-y-0.5 text-[11px] text-charcoal-soft dark:text-white/70">
                                    @foreach($file['used_in'] as $ref)
                                        <li class="truncate">- {{ $ref }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="inline-block bg-sand px-2 py-0.5 text-[10px] font-medium text-charcoal-soft dark:bg-white/10 dark:text-white/60">
                                    Tidak digunakan di konten manapun
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t coastal-hairline px-4 py-3">
                    <a href="{{ $file['url'] }}" target="_blank" rel="noopener noreferrer" class="text-xs font-medium text-ocean hover:underline dark:text-turquoise-bright">
                        Lihat Ukuran Penuh
                    </a>

                    @if(empty($file['used_in']))
                        <form method="POST" action="{{ route('admin.media.destroy') }}" data-confirm="Hapus permanen file '{{ $file['name'] }}' dari storage?">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="path" value="{{ $file['path'] }}">
                            <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">
                                Hapus File
                            </button>
                        </form>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-full border coastal-hairline bg-warm-white p-10 text-center text-sm text-charcoal-soft dark:bg-[#141f24] dark:text-white/60">
                Belum ada file gambar di direktori media aplikasi.
            </div>
        @endforelse
    </div>
@endsection

