@props([
    'id' => 'image-field',
    'label' => 'Gambar',
    'fileName' => 'image',
    'existingName' => 'existing_image',
    'removeName' => 'remove_image',
    'currentPath' => null,
    'allowRemove' => true,
    'mediaFiles' => [],
    'focalPointName' => 'focal_point',
    'focalPointValue' => 'center center',
    'focalPoints' => [],
    'altName' => 'image_alt',
    'altValue' => '',
    'showMetaFields' => true,
])

@php
    $previewUrl = $currentPath ? '/storage/' . ltrim($currentPath, '/') : '';
@endphp

<div id="{{ $id }}" data-image-field class="space-y-4 border coastal-hairline bg-[#f8f5ef] p-5 dark:bg-[#162126]">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <label class="text-xs font-semibold tracking-[0.15em] uppercase text-charcoal dark:text-white">
            {{ $label }}
        </label>
        <span class="text-[11px] text-charcoal-soft dark:text-white/55">Format JPG, PNG, WebP (Maks. 5 MB)</span>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-12">
        <div class="sm:col-span-5">
            <div class="relative aspect-[16/10] overflow-hidden border coastal-hairline bg-sand/70 dark:bg-[#0f1619]">
                <img
                    data-image-preview
                    src="{{ $previewUrl }}"
                    alt="Preview {{ $label }}"
                    class="{{ $previewUrl ? '' : 'hidden' }} h-full w-full object-cover"
                    style="object-position: {{ $focalPointValue }};"
                >
                <div
                    data-image-empty
                    class="{{ $previewUrl ? 'hidden' : '' }} flex h-full w-full flex-col items-center justify-center gap-2 p-4 text-center text-xs text-charcoal-soft dark:text-white/50"
                >
                    <i data-lucide="image" class="h-6 w-6 opacity-50"></i>
                    <span>Belum ada gambar dipilih</span>
                </div>
            </div>
        </div>

        <div class="space-y-3 sm:col-span-7">
            <input type="hidden" name="{{ $existingName }}" value="" data-existing-image-input>

            <div>
                <label class="mb-1.5 block text-xs font-medium text-charcoal-soft dark:text-white/75">
                    Unggah Gambar Baru
                </label>
                <input
                    type="file"
                    name="{{ $fileName }}"
                    accept="image/jpeg,image/png,image/webp"
                    data-image-input
                    class="block w-full cursor-pointer border coastal-hairline bg-warm-white px-3 py-2 text-xs text-charcoal file:mr-3 file:border-0 file:bg-ocean file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-ocean-deep dark:bg-[#10171a] dark:text-white/85 dark:file:bg-turquoise-bright dark:file:text-charcoal"
                >
            </div>

            @if(!empty($mediaFiles))
                <div class="flex flex-wrap items-center gap-3">
                    <button
                        type="button"
                        data-open-media-picker
                        class="inline-flex items-center gap-2 rounded-[2px] border coastal-hairline bg-warm-white px-3 py-1.5 text-xs font-medium text-charcoal hover:bg-sand dark:bg-[#10171a] dark:text-white/85 dark:hover:bg-white/10"
                    >
                        <i data-lucide="folder-open" class="h-3.5 w-3.5"></i>
                        <span>Pilih dari Pustaka Media</span>
                    </button>

                    @if($allowRemove && $currentPath)
                        <label class="inline-flex cursor-pointer items-center gap-2 text-xs text-red-700 dark:text-red-300">
                            <input type="checkbox" name="{{ $removeName }}" value="1" class="accent-red-600">
                            <span>Hapus gambar saat ini</span>
                        </label>
                    @endif
                </div>
            @elseif($allowRemove && $currentPath)
                <label class="inline-flex cursor-pointer items-center gap-2 text-xs text-red-700 dark:text-red-300">
                    <input type="checkbox" name="{{ $removeName }}" value="1" class="accent-red-600">
                    <span>Hapus gambar saat ini</span>
                </label>
            @endif

            @if($showMetaFields)
                <div class="grid grid-cols-1 gap-3 pt-1 sm:grid-cols-2">
                    @if(!empty($focalPoints))
                        <div>
                            <label class="mb-1 block text-xs font-medium text-charcoal-soft dark:text-white/75">Titik Fokus (Focal Point)</label>
                            <select
                                name="{{ $focalPointName }}"
                                class="w-full rounded-[2px] border coastal-hairline bg-warm-white px-3 py-2 text-xs text-charcoal dark:bg-[#10171a] dark:text-white"
                            >
                                @foreach($focalPoints as $fp)
                                    <option value="{{ $fp }}" @selected(old($focalPointName, $focalPointValue) === $fp)>{{ $fp }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="mb-1 block text-xs font-medium text-charcoal-soft dark:text-white/75">Teks Alternatif (Alt Text)</label>
                        <input
                            type="text"
                            name="{{ $altName }}"
                            value="{{ old($altName, $altValue) }}"
                            placeholder="Deskripsi singkat foto"
                            class="w-full rounded-[2px] border coastal-hairline bg-warm-white px-3 py-2 text-xs text-charcoal dark:bg-[#10171a] dark:text-white"
                        >
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(!empty($mediaFiles))
        <div
            data-media-picker-modal
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 p-4"
            role="dialog"
            aria-modal="true"
        >
            <div class="max-h-[85vh] w-full max-w-3xl overflow-y-auto border coastal-hairline bg-warm-white p-6 dark:bg-[#121c20]">
                <div class="flex items-center justify-between border-b coastal-hairline pb-3">
                    <h3 class="font-editorial text-xl font-medium">Pilih dari Pustaka Media</h3>
                    <button type="button" data-close-media-picker class="border coastal-hairline p-1.5 hover:bg-sand dark:hover:bg-white/10">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                    @foreach($mediaFiles as $mFile)
                        <button
                            type="button"
                            data-media-pick
                            data-target-field="{{ $id }}"
                            data-media-path="{{ $mFile['path'] }}"
                            data-media-url="{{ $mFile['url'] }}"
                            class="group border coastal-hairline bg-sand/40 p-1.5 text-left hover:border-ocean dark:bg-[#182429] dark:hover:border-turquoise-bright"
                        >
                            <div class="aspect-[4/3] overflow-hidden">
                                <img src="{{ $mFile['url'] }}" alt="{{ $mFile['name'] }}" class="h-full w-full object-cover">
                            </div>
                            <p class="mt-1.5 truncate text-[11px] font-medium">{{ $mFile['name'] }}</p>
                            <p class="text-[10px] text-charcoal-soft dark:text-white/50">{{ $mFile['size_kb'] }} KB</p>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

