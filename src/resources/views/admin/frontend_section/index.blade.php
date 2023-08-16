@extends('admin.layouts.app')
@section('panel')
    <section class="mt-3 rounded_box">
        <div class="container-fluid p-0 pb-2">
            <div class="row d-flex align--center rounded">
                @if(isset($sectionData['fixed_content']))
                    <div class="col-xl-12 col-xl">
                    <form action="{{route('admin.frontend.sections.save.content', $section_key)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="content_type" value="fixed_content">
                        <div class="card mb-3">
                            <h6 class="card-header">{{ translate($title)}}</h6>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($sectionData['fixed_content'] as $key => $item)
                                        @if($key === 'images')
                                            @foreach($item as $image_key => $file)
                                                <div class="col-md-6 mb-2">
                                                    <div class="mb-3">
                                                        <label for="{{ $image_key }}" class="form-label">{{ __(setInputLabel($image_key)) }} <sup class="text--danger">*</sup></label>
                                                        <input type="file" class="form-control" id="{{ $image_key }}" name="images[{{ @$image_key }}]" value="{{ @$sectionFixedContent->section_value[$image_key] ?? '' }}" placeholder="{{ __(setInputLabel($key)) }}">
                                                        <small>{{translate('File formats supported: jpeg, jpg, png. The image will be resized to')}} {{$file['size'] ?? ''}} {{translate('pixels')}}.
                                                            <a href="{{showImage(filePath()['frontend']['path'].'/'. @$sectionFixedContent->section_value[$image_key],$file['size'])}}" target="__blank">{{translate('view image')}}</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-6 mb-2">
                                                <div class="mb-3">
                                                    <label for="{{ $key }}" class="form-label">{{ __(setInputLabel($key)) }} <sup class="text--danger">*</sup></label>
                                                    @switch($item)
                                                        @case('icon')
                                                            <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ $sectionFixedContent->section_value[$key] ?? '' }}" placeholder="{{ __(setInputLabel($key)) }}" required>
                                                            @break
                                                        @case('text')
                                                            <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ $sectionFixedContent->section_value[$key] ?? '' }}" placeholder="{{ __(setInputLabel($key)) }}" required>
                                                            @break
                                                        @case('textarea')
                                                            <textarea class="form-control" id="{{ $key }}" name="{{ $key }}" placeholder="{{ __(setInputLabel($key)) }}" required>{{ $sectionFixedContent->section_value[$key] ?? '' }}</textarea>
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
                @endif

                @if(isset($sectionData['element_content']))
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="responsive-table">
                                        <table class="m-0 text-center table--light">
                                            <thead>
                                                <tr>
                                                    <th>{{ translate('#') }}</th>
                                                    @if (Illuminate\Support\Arr::has($sectionData, 'element_content.images'))
                                                        <th>{{translate('Image')}}</th>
                                                    @endif

                                                    @foreach ($sectionData['element_content'] as $key => $typeItem)
                                                        @if (in_array($typeItem, ['text', 'icon']))
                                                            <th>{{ __(setInputLabel($key)) }}</th>
                                                        @endif
                                                    @endforeach

                                                    <th>{{ translate('Action') }}</th>
                                                </tr>
                                            </thead>

                                            @forelse ($elementContents as $element)
                                                <tr class="@if ($loop->even)@endif">
                                                    <td data-label="{{ translate('Name') }}">{{ $loop->iteration }}</td>

                                                    @if (Illuminate\Support\Arr::has($sectionData, 'element_content.images'))

                                                        <td data-label="{{ translate('Image') }}">
                                                            <img src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$element->section_value, 'card_image'),'100x80')}}" class="w-100px">
                                                        </td>
                                                    @endif

                                                    @foreach ($sectionData['element_content'] as $key => $typeItem)
                                                        @if (in_array($typeItem, ['text', 'icon']))
                                                            <td data-label="{{__(setInputLabel($key)) }}">
                                                                @if ($typeItem == 'icon')
                                                                    @php echo $element->section_value[$key] ?? '' @endphp
                                                                @else
                                                                    {{ $element->section_value[$key] ?? '' }}
                                                                @endif
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td data-label="{{ translate('Action') }}">
                                                        <a href="{{route('admin.frontend.sections.element.content',[$section_key,$element->id])}}" class="btn--primary text--light"><i class="la la-pencil-alt"></i></a>
                                                        <a href="javascript:void(0)" class="btn--danger text--light remove-element"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#delete-element"
                                                               data-delete_id="{{$element->id}}"
                                                            ><i class="las la-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-muted text-center" colspan="100%">{{ translate('No Data Found') }}</td>
                                                </tr>
                                            @endforelse
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>


    @if(isset($sectionData['element_content']))
        <a href="{{route('admin.frontend.sections.element.content',$section_key)}}" class="support-ticket-float-btn">
            <i class="fa fa-plus ticket-float"></i>
        </a>
    @endif


    <div class="modal fade" id="delete-element" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.frontend.sections.element.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="element_id" value="">
                    <div class="modal_body2">
                        <div class="modal_icon2">
                            <i class="las la-trash"></i>
                        </div>
                        <div class="modal_text2 mt-3">
                            <h6>{{ translate('Are you sure to delete this section element')}}</h6>
                        </div>
                    </div>
                    <div class="modal_button2">
                        <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="submit" class="bg--danger">{{ translate('Delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scriptpush')
    <script>
        "use strict";
        $('.remove-element').on('click', function(){
            var modal = $('#delete-element');
            modal.find('input[name=element_id]').val($(this).data('delete_id'));
            modal.modal('show');
        });
    </script>
@endpush



