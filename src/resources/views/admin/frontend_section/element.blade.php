@extends('admin.layouts.app')
@section('panel')
@push('style-include')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard/css/iconpicker/fontawesome-iconpicker.css')}}">
@endpush
    <section class="mt-3 rounded_box">
        <div class="container-fluid p-0 pb-2">
            <div class="row d-flex align--center rounded">
                    <div class="col-xl-12 col-xl">
                        <form action="{{route('admin.frontend.sections.save.content', $section_key)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="content_type" value="element_content">
                            @if(@$frontendSectionElement)
                                <input type="hidden" name="id" value="{{$frontendSectionElement->id}}">
                            @endif

                            <div class="card mb-3">
                                <h6 class="card-header">{{ translate($title) }}</h6>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($sectionData['element_content'] ?? [] as $key => $item)
                                            @if($key === 'images')
                                                @foreach($item as $image_key => $file)
                                                    <div class="col-md-6 mb-2">
                                                        <div class="mb-3">
                                                            <label for="{{ $image_key }}" class="form-label">{{ __(setInputLabel($image_key)) }} <sup class="text--danger">*</sup></label>
                                                            <input type="file" class="form-control" id="{{ $image_key }}" name="images[{{ @$image_key }}]" value="{{ @$frontendSectionElement->section_value[$image_key] ?? '' }}" placeholder="{{ __(setInputLabel($key)) }}">
                                                            <small>{{translate('File formats supported: jpeg, jpg, png. The image will be resized to')}} {{$file['size'] ?? ''}} {{translate('pixels')}}.
                                                                <a href="{{showImage(filePath()['frontend']['path'].'/'. @$frontendSectionElement->section_value[$image_key],$file['size'])}}" target="__blank">{{translate('view image')}}</a>
                                                            </small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else

                                                <div class="col-md-6 mb-2">
                                                    <div class="mb-3 position-relative">
                                                        <label for="{{ $key }}" class="form-label">{{ __(setInputLabel($key)) }} <sup class="text--danger">*</sup></label>
                                                        @switch($item)
                                                            @case('icon')
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control iconpicker icon" autocomplete="off" name="{{ $key }}" required>
                                                                    <span class="input-group-text input-group-addon" role="iconpicker"></span>
                                                                </div>
                                                                @break
                                                            @case('text')
                                                                <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ $frontendSectionElement->section_value[$key] ?? '' }}" placeholder="{{ __(setInputLabel($key)) }}" required>
                                                                @break
                                                            @case('textarea')
                                                                <textarea class="form-control" id="{{ $key }}" name="{{ $key }}" placeholder="{{ __(setInputLabel($key)) }}" required>{{ $frontendSectionElement->section_value[$key] ?? '' }}</textarea>
                                                                @break
                                                        @endswitch
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-sm-3 me-1 w-100">
                                {{translate("Submit")}}
                            </button>
                        </form>
                    </div>
            </div>
        </div>
    </section>
@endsection

@push('script-include')
    <script src="{{ asset('assets/dashboard/js/iconpicker/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('scriptpush')
    <script>
        $(document).ready(function() {
            "use strict";

            const iconPicker = document.querySelector('.iconpicker');

            iconPicker.addEventListener('click', function() {
                const iconPopover = document.querySelector('.iconpicker-popover');
                iconPopover.style.display = 'contents';
            });


            $('.iconpicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.input-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
            });
        });

    </script>
@endpush
