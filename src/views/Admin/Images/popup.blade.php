@extends('zamb::Layouts.admin')

@section('stylesheets')
    @parent
    <style>
        body{padding: 15px;}
    </style>
@stop

@section('content')
    <div>
        <div class="image-roll">
            <ul>
                @foreach($images as $image)
                <li data-id="{{ $image->id }}" data-name="{{ $image->title }}">
                    <a href="javascript:void(0);" onclick="window.opener.selectImage({{ $image->id }}, '{{ $image->title }}');window.close();">
                        <img src="{{ \Helpers\ImageHelper::getImageUrl($image, 'thumbnail') }}" alt="{{ $image->caption }}">
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop