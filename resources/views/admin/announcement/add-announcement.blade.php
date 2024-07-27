<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Add Announcement</title>
    <!-- [Meta] -->
    @include('admin-partials.admin-header')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->


<body>

    @include('admin-partials.admin-sidebar')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0"><a
                                        href="{{ route('admin.announcement.admin-announcement') }}">
                                        ANNOUNCEMENT</a></li>
                                <li class="breadcrumb-item mb-0"><a
                                        href="{{ route('admin.announcement.add-announcement') }}">
                                        Add Announcement</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="col-xl-12 mt-4">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <div class="tab-content pt-2">
                            <form method="POST" action="{{ route('admin.announcement.save-announcement') }}"
                                id="announcementForm">
                                @csrf
                                <div class="tab-pane active" id="announcement">
                                    <br>
                                    <div class="form-group">
                                        <label for="announcement_subject" class="mt-0">Subject</label>
                                        <input type="text" class="form-control" id="announcement_subject"
                                            placeholder="Enter subject" name="announcement_subject" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="announcement_message">Message</label>
                                        <textarea id="announcement-editor" name="announcement_message"></textarea>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div><!-- End Bordered Tabs -->

                    <!-- Toast Container -->
                    <div class="toast-container position-fixed p-3 end-0 bottom-0">

                        <div class="toast-container position-fixed p-3 end-0 bottom-0">
                            <div class="toast align-items-center text-white bg-danger border-0" id="errorToast"
                                role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body" data-message="{{ $errors->first() }}"
                                        style="text-align: center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- [ Main Content ] end -->
                    @include('admin-partials.admin-footer')

</body>
<!-- [Body] end -->

</html>
<script>
    ClassicEditor
        .create(document.querySelector('#announcement-editor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', '|',
                'uploadImage', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
                ]
            },
        })
        .catch(error => {
            console.error(error);
        });
</script>
