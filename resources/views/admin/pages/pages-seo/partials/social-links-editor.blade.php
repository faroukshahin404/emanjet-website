{{--
    Dynamic social links for PageSeo section_type social-media.
    Uses Font Awesome 6 classes (same as site footer).
--}}
@php
    use App\Support\SocialMediaLinks;

    $arContent = is_array($arContent ?? null) ? $arContent : [];

    $contactLabels = [
        'email' => __('Email'),
        'phone' => __('Phone'),
        'whatsapp' => __('WhatsApp'),
        'complaints_email' => __('Complaints email'),
    ];

    $contactEn = SocialMediaLinks::emptyContactStructure();
    $contactAr = SocialMediaLinks::emptyContactStructure();
    foreach (SocialMediaLinks::contactFieldKeys() as $ckey) {
        if (isset($enContent['contact'][$ckey]) && is_array($enContent['contact'][$ckey])) {
            $contactEn[$ckey] = array_replace($contactEn[$ckey], $enContent['contact'][$ckey]);
        }
        if (isset($arContent['contact'][$ckey]) && is_array($arContent['contact'][$ckey])) {
            $contactAr[$ckey] = array_replace($contactAr[$ckey], $arContent['contact'][$ckey]);
        }
    }

    $contactIconPresets = SocialMediaLinks::contactIconPresetChoices();
    $contactIconPresetValues = array_values($contactIconPresets);

    $presets = SocialMediaLinks::iconPresets();
    $presetValues = array_values($presets);

    $socialRows = $enContent['links'] ?? [];
    if (! is_array($socialRows)) {
        $socialRows = [];
    }
    if (count($socialRows) === 0) {
        foreach (SocialMediaLinks::legacyKeyToIconClass() as $key => $icon) {
            $url = trim((string) ($enContent[$key] ?? ''));
            if ($url !== '') {
                $socialRows[] = [
                    'icon_class' => $icon,
                    'url' => $url,
                    'visible' => true,
                ];
            }
        }
    }
    if (count($socialRows) === 0) {
        $socialRows[] = ['icon_class' => '', 'url' => '', 'visible' => true];
    }
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">

<h5 class="fw-semibold mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
    <i class="bi bi-telephone text-primary" aria-hidden="true"></i>
    {{ __('Contact details') }}
</h5>
<p class="small text-muted mb-3">{{ __('Shown on the contact page and footer. One icon per field; Arabic and English values can differ. Toggle visibility to hide without clearing text.') }}</p>

<div class="border rounded-3 p-3 mb-5 bg-body-secondary bg-opacity-10">
    @foreach (SocialMediaLinks::contactFieldKeys() as $ckey)
        @php
            $ce = $contactEn[$ckey];
            $ca = $contactAr[$ckey];
            $iconVal = old('contact.'.$ckey.'.icon_class', $ce['icon_class'] ?? '');
            $visVal = (bool) old('contact.'.$ckey.'.visible', $ce['visible'] ?? true);
            $enVal = old('contact.'.$ckey.'.en', $ce['value'] ?? '');
            $arVal = old('contact.'.$ckey.'.ar', $ca['value'] ?? '');
            $isCustomIcon = $iconVal !== '' && ! in_array($iconVal, $contactIconPresetValues, true);
        @endphp
        <div class="contact-field-row border rounded-3 p-3 mb-3 bg-white">
            <h6 class="fw-semibold mb-3 text-body">{{ $contactLabels[$ckey] ?? $ckey }}</h6>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small mb-1">{{ __('Icon preset') }}</label>
                    <select class="form-select contact-preset-select">
                        <option value="">{{ __('Choose…') }}</option>
                        @foreach ($contactIconPresets as $plabel => $pclass)
                            <option value="{{ $pclass }}" @selected($iconVal === $pclass)>{{ __($plabel) }}</option>
                        @endforeach
                        <option value="__custom__" @selected($isCustomIcon && $iconVal !== '')>{{ __('Custom class') }}</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label small mb-1">{{ __('Icon CSS class') }}</label>
                    <input type="text" name="contact[{{ $ckey }}][icon_class]" value="{{ $iconVal }}"
                        class="form-control contact-icon-class-input font-monospace"
                        placeholder="fa-solid fa-envelope" autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">{{ __('English') }}</label>
                    <input type="text" name="contact[{{ $ckey }}][en]" value="{{ $enVal }}" class="form-control form-control-sm"
                        dir="ltr" @if ($ckey === 'email' || $ckey === 'complaints_email') autocomplete="email" @endif>
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">{{ __('Arabic') }}</label>
                    <input type="text" name="contact[{{ $ckey }}][ar]" value="{{ $arVal }}" class="form-control form-control-sm"
                        dir="rtl">
                </div>
                <div class="col-12 d-flex align-items-center gap-3 flex-wrap">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="contact[{{ $ckey }}][visible]" value="1" id="contact_vis_{{ $ckey }}"
                            class="form-check-input" @checked($visVal)>
                        <label class="form-check-label small" for="contact_vis_{{ $ckey }}">{{ __('Visible') }}</label>
                    </div>
                    <span class="small text-muted">{{ __('Preview') }}:</span>
                    <span class="contact-preview fs-5"><i class="{{ $iconVal ?: 'fa-solid fa-circle-question' }}" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<h5 class="fw-semibold mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
    <i class="bi bi-share text-primary" aria-hidden="true"></i>
    {{ __('Social networks') }}
</h5>
<div class="alert alert-light border mb-4" role="note">
    <i class="bi bi-share flex-shrink-0 me-2" aria-hidden="true"></i>
    <span class="small text-body-secondary">{{ __('Pick a preset or type a Font Awesome 6 class (e.g. fa-brands fa-facebook-f). Preview updates as you type.') }}</span>
</div>

<div id="social-links-repeater" class="border rounded-3 p-3 mb-4 bg-body-secondary bg-opacity-10">
    <p class="small text-muted mb-3">{{ __('Add or remove social links. Rows need both URL and icon. Use Visible to hide a link from the footer without deleting it.') }}</p>

    @foreach ($socialRows as $i => $row)
        @php
            $iconVal = old('social_links.'.$i.'.icon_class', $row['icon_class'] ?? '');
            $urlVal = old('social_links.'.$i.'.url', $row['url'] ?? '');
            $visVal = (bool) old('social_links.'.$i.'.visible', $row['visible'] ?? true);
            $isCustom = $iconVal !== '' && ! in_array($iconVal, $presetValues, true);
        @endphp
        <div class="social-link-row border rounded p-3 mb-3 bg-white">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small mb-1">{{ __('Icon preset') }}</label>
                    <select class="form-select social-preset-select">
                        <option value="">{{ __('Choose…') }}</option>
                        @foreach ($presets as $label => $cls)
                            <option value="{{ $cls }}" @selected($iconVal === $cls)>{{ $label }}</option>
                        @endforeach
                        <option value="__custom__" @selected($isCustom && $iconVal !== '')>{{ __('Custom class') }}</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label small mb-1">{{ __('Icon CSS class') }}</label>
                    <input type="text" name="social_links[{{ $i }}][icon_class]"
                        value="{{ $iconVal }}"
                        class="form-control social-icon-class-input font-monospace"
                        placeholder="fa-brands fa-facebook-f" autocomplete="off">
                </div>
                <div class="col-md-10">
                    <label class="form-label small mb-1">{{ __('URL') }}</label>
                    <input type="url" name="social_links[{{ $i }}][url]" value="{{ $urlVal }}"
                        class="form-control form-control-sm" placeholder="https://…">
                </div>
                <div class="col-md-2">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="social_links[{{ $i }}][visible]" value="1" id="soc_vis_{{ $i }}"
                            class="form-check-input" @checked($visVal)>
                        <label class="form-check-label small" for="soc_vis_{{ $i }}">{{ __('Visible') }}</label>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center gap-2 flex-wrap">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-social-row">{{ __('Remove') }}</button>
                    <span class="small text-muted">{{ __('Preview') }}:</span>
                    <span class="social-preview text-body fs-5"><i class="{{ $iconVal ?: 'fa-brands fa-circle-question' }}" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    @endforeach

    <button type="button" class="btn btn-sm btn-primary" id="add-social-link">
        <i class="bi bi-plus-lg"></i> {{ __('Add link') }}
    </button>
</div>

<template id="social-link-row-template">
    <div class="social-link-row border rounded p-3 mb-3 bg-white">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small mb-1">{{ __('Icon preset') }}</label>
                <select class="form-select social-preset-select">
                    <option value="">{{ __('Choose…') }}</option>
                    @foreach ($presets as $label => $cls)
                        <option value="{{ $cls }}">{{ $label }}</option>
                    @endforeach
                    <option value="__custom__">{{ __('Custom class') }}</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label small mb-1">{{ __('Icon CSS class') }}</label>
                <input type="text" name="social_links[__INDEX__][icon_class]"
                    value=""
                    class="form-control social-icon-class-input font-monospace"
                    placeholder="fa-brands fa-facebook-f" autocomplete="off">
            </div>
            <div class="col-md-10">
                <label class="form-label small mb-1">{{ __('URL') }}</label>
                <input type="url" name="social_links[__INDEX__][url]" value=""
                    class="form-control form-control-sm" placeholder="https://…">
            </div>
            <div class="col-md-2">
                <div class="form-check form-switch">
                    <input type="checkbox" name="social_links[__INDEX__][visible]" value="1" id="soc_vis___INDEX__"
                        class="form-check-input" checked>
                    <label class="form-check-label small" for="soc_vis___INDEX__">{{ __('Visible') }}</label>
                </div>
            </div>
            <div class="col-12 d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-sm btn-outline-danger remove-social-row">{{ __('Remove') }}</button>
                <span class="small text-muted">{{ __('Preview') }}:</span>
                <span class="social-preview text-body fs-5"><i class="fa-brands fa-circle-question" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</template>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.contact-field-row').forEach(function(card) {
                var preset = card.querySelector('.contact-preset-select');
                var iconInput = card.querySelector('.contact-icon-class-input');
                var prevI = card.querySelector('.contact-preview i');

                function syncContactIcon() {
                    if (!prevI || !iconInput) return;
                    var cls = (iconInput.value || '').trim() || 'fa-solid fa-circle-question';
                    prevI.className = cls;
                }

                if (preset && iconInput) {
                    preset.addEventListener('change', function() {
                        if (this.value && this.value !== '__custom__') {
                            iconInput.value = this.value;
                        }
                        syncContactIcon();
                    });
                }
                if (iconInput) {
                    iconInput.addEventListener('input', syncContactIcon);
                }
                syncContactIcon();
            });

            function reindexSocialRows() {
                var container = document.getElementById('social-links-repeater');
                if (!container) return;
                var rows = container.querySelectorAll('.social-link-row');
                rows.forEach(function(row, index) {
                    row.querySelectorAll('[name]').forEach(function(el) {
                        el.name = el.name.replace(/social_links\[\d+\]/, 'social_links[' + index + ']');
                    });
                    var cb = row.querySelector('input.form-check-input[type="checkbox"]');
                    var id = 'soc_vis_' + index;
                    if (cb) cb.id = id;
                    var lbl = row.querySelector('label.form-check-label[for^="soc_vis_"]');
                    if (lbl) lbl.setAttribute('for', id);
                });
            }

            function bindRow(row) {
                var preset = row.querySelector('.social-preset-select');
                var input = row.querySelector('.social-icon-class-input');
                var prevIcon = row.querySelector('.social-preview i');

                function syncPreview() {
                    if (!prevIcon || !input) return;
                    var cls = (input.value || '').trim() || 'fa-brands fa-circle-question';
                    prevIcon.className = cls;
                }

                if (preset && input) {
                    preset.addEventListener('change', function() {
                        if (this.value && this.value !== '__custom__') {
                            input.value = this.value;
                        }
                        syncPreview();
                    });
                }
                if (input) input.addEventListener('input', syncPreview);

                row.querySelector('.remove-social-row')?.addEventListener('click', function() {
                    var container = document.getElementById('social-links-repeater');
                    if (container.querySelectorAll('.social-link-row').length <= 1) return;
                    row.remove();
                    reindexSocialRows();
                });
                syncPreview();
            }

            document.querySelectorAll('#social-links-repeater .social-link-row').forEach(bindRow);

            document.getElementById('add-social-link')?.addEventListener('click', function() {
                var tpl = document.getElementById('social-link-row-template');
                var container = document.getElementById('social-links-repeater');
                var btn = document.getElementById('add-social-link');
                if (!tpl || !container || !btn) return;
                var idx = container.querySelectorAll('.social-link-row').length;
                var html = tpl.innerHTML.replace(/__INDEX__/g, String(idx));
                var wrap = document.createElement('div');
                wrap.innerHTML = html.trim();
                var row = wrap.firstElementChild;
                container.insertBefore(row, btn);
                reindexSocialRows();
                bindRow(row);
            });
        });
    </script>
@endpush
