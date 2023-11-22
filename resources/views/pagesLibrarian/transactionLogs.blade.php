@extends('layouts.app')

@section('content')
<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        Attendance Logs
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        In this page, the librarian can scan students' QR codes
                    </p>
                </div>
            </div>
            <div class="container-fluid py-4 mt-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Borrower Information</p>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col">
                                                    @if (session('success'))
                                                    <div class="alert-success alert-dismissible fade show" role="alert">
                                                        <p class="text-center text-white">
                                                            {{ session('success') }}
                                                        </p>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close">x</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <!-- Button to open the camera modal -->
                                                    <button class="btn btn-primary form-control" data-bs-toggle="modal"
                                                        data-bs-target="#cameraStudentModal">Scan Student QR Code</button>
                                                </div>
                                                <form method="POST" action="{{ route('recordLogins') }}" id="form-borrow">
                                                    @csrf
                                                    <div class="col">
                                                        <input type="text" id="search-book-toborrow" name="qr_code"
                                                            placeholder="Type the ID number or Scan" class="form-control">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <button type="button" id="submitBtn" class="btn btn-success mt-3"
                                                    onclick="submitForm()" data-bs-toggle="modal"
                                                    data-bs-target="#cameraStudentModal">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Attendace Logs</p>
                                <div class="row">
                                    <div class="col">
                                                @foreach ($records as $record)
                                               <p class="text-secondary">{{ $record->id_number }} &ensp;{{   $record->name;}} &ensp; {{ $record->created_at }}</p>


                                                @endforeach


                                                {{-- {{ $reach  }} --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <!-- Camera Student modal -->
            <div class="modal fade" id="cameraStudentModal" tabindex="-1" aria-labelledby="cameraModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cameraModalLabel">Scan Student QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <video id="scanner1"></video>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
            <script>
                // STUDENT SCANNER:
                // Get the scanner video element
                const scanner1 = document.getElementById('scanner1');
                // Create a new Instascan scanner object
                const instascanScanner1 = new Instascan.Scanner({
                    video: scanner1
                });
                // Attach an event listener for the scan event
                instascanScanner1.addListener('scan', function (content) {
                    // Update the input field with the scanned result
                    $('#search-book-toborrow').val(content);
                    // Hide the camera modal
                    $('#cameraStudentModal').modal('hide');
                    // Submit the form immediately after the scan is complete
                    submitForm();
                });
                // Start the scanner when the camera modal is shown
                $('#cameraStudentModal').on('shown.bs.modal', function () {
                    Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                            // Use the rear camera by default
                            const selectedCamera = cameras[0];
                            // Start the scanner with the selected camera
                            instascanScanner1.start(selectedCamera);
                        } else {
                            // No cameras found, show an error message
                            alert('No cameras found.');
                        }
                    }).catch(function (error) {
                        // Failed to access the camera, show an error message
                        alert('Failed to access the camera: ' + error);
                    });
                });
                // Stop the scanner when the camera modal is hidden
                $('#cameraStudentModal').on('hidden.bs.modal', function () {
                    instascanScanner1.stop();
                });

                // Function to submit the form
                function submitForm() {
                    $('#form-borrow').submit();
                }
            </script>
        </div>
        @endsection


        {{-- <h1>jhsagd</h1> --}}
