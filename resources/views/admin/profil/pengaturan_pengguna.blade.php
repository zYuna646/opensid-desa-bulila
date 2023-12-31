<div class="modal fade in" id="profil_pengguna">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pengaturan Pengguna</h4>
            </div>
            @include('admin.profil.form')
        </div>
    </div>
</div>
@include('admin.layouts.components.sweetalert2')
@push('scripts')
    <script src="{{ asset('js/validasi.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('.reveal-lama').on('click', function() {
                var $pwd = $("#password-lama");
                if ($pwd.attr('type') === 'password') {
                    $pwd.attr('type', 'text');

                    $(".reveal-lama i").removeClass("fa-eye-slash");
                    $(".reveal-lama i").addClass("fa-eye");
                } else {
                    $pwd.attr('type', 'password');

                    $(".reveal-lama i").addClass("fa-eye-slash");
                    $(".reveal-lama i").removeClass("fa-eye");
                }
            });

            $('.reveal-baru').on('click', function() {
                var $pwd = $("#password-baru");
                if ($pwd.attr('type') === 'password') {
                    $pwd.attr('type', 'text');

                    $(".reveal-baru i").removeClass("fa-eye-slash");
                    $(".reveal-baru i").addClass("fa-eye");
                } else {
                    $pwd.attr('type', 'password');

                    $(".reveal-baru i").addClass("fa-eye-slash");
                    $(".reveal-baru i").removeClass("fa-eye");
                }
            });

            $('.reveal-ulangi').on('click', function() {
                var $pwd = $("#password-ulangi");
                if ($pwd.attr('type') === 'password') {
                    $pwd.attr('type', 'text');

                    $(".reveal-ulangi i").removeClass("fa-eye-slash");
                    $(".reveal-ulangi i").addClass("fa-eye");
                } else {
                    $pwd.attr('type', 'password');

                    $(".reveal-ulangi i").addClass("fa-eye-slash");
                    $(".reveal-ulangi i").removeClass("fa-eye");
                }
            });

            $("#validate_user").validate();

            setTimeout(function() {
                $('#pass_baru1').rules('add', {
                    equalTo: '#pass_baru'
                })
            }, 500);

            $('#file_browser_user').click(function(e) {
                e.preventDefault();
                $('#file_user').click();
            });

            $('#file_user').change(function() {
                $('#file_path_user').val($(this).val());
            });

            $('#file_path_user').click(function() {
                $('#file_browser_user').click();
            });

            $('#verif_telegram').click(function() {
                Swal.fire({
                    title: 'Mengirim OTP',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                $.ajax({
                        url: '{{ route('user_setting.kirim_otp_telegram') }}',
                        type: 'Post',
                        data: {
                            'sidcsrf': getCsrfToken(),
                            'id_telegram': $('#id_telegram').val()
                        },
                    })
                    .done(function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                title: 'Masukan Kode OTP',
                                input: 'text',
                                inputPlaceholder: 'Masukan Kode OTP',
                                inputValidator: (value) => {
                                    if (isNaN(value)) {
                                        return 'Kode OTP harus berupa angka'
                                    }
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Kirim',
                                cancelButtonText: 'Tutup',
                                showLoaderOnConfirm: true,
                                preConfirm: (otp) => {
                                    const formData = new FormData();
                                    formData.append('sidcsrf', getCsrfToken());
                                    formData.append('id_telegram', response.data);
                                    formData.append('otp', otp);

                                    return fetch(
                                            `{{ route('user_setting.verifikasi_telegram') }}`, {
                                                method: 'POST',
                                                body: formData,
                                            }).then(response => {
                                            if (!response.ok) {
                                                throw new Error(response.statusText)
                                            }
                                            return response.json()
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (result.value.status == true) {
                                        $('.close').trigger("click"); //close modal
                                        Swal.fire({
                                            icon: 'success',
                                            title: result.value.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: result.value.message
                                        })
                                    }
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.messages,
                            })
                        }
                    })
                    .fail(function(e) {
                        Swal.fire({
                            icon: 'error',
                            text: e.statusText,
                        })
                    });
            });

            $('#id_telegram').change(function(event) {
                $('input[name="telegram_verified_at"]').val('')
            });
        });
    </script>
@endpush
