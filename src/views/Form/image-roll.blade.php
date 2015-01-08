<div class="image-roll">
    <ul>
        @foreach($images as $image)
        <li data-id="{{ $image->id }}">
                <img src="{{ \Helpers\ImageHelper::getImageUrl($image, 'thumbnail') }}" alt="{{ $image->caption }}">
                <div class="delete-icon"><i class="fa fa-trash"></i></div>
        </li>
        @endforeach
    </ul>
</div>
<input type="hidden" id="imagesToDelete" name="imagesToDelete" value="[]">