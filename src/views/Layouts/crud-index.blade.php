@extends('zamb::Layouts.admin')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="iframe-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <iframe src="" style="border: 0; width: 100%;height: 100%"></iframe>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent

    <script>
        function confirmClosing() {
            var answer = confirm("Are you sure?");
            if (answer) {
                $('#iframe-modal').off('hide.bs.modal', confirmClosing);
            }
            return answer;
        }

        $('#iframe-modal').on('shown.bs.modal', function (e) {
            $('#iframe-modal').on('hide.bs.modal', confirmClosing);
        });
    </script>
@stop