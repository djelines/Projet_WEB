// sweetalert-loader.js

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formConfirm');

    if (form) {
        form.addEventListener('submit', function (e) {
            Swal.fire({
                title: 'Génération du QCM en cours...',
                html: 'Cela peut prendre quelques secondes. Merci de patienter.',
                allowOutsideClick: false,
                background: '#fff',
                customClass: {
                    popup: '!border !border-pink-300 !rounded-xl !shadow-md',
                    title: '!text-pink-400 !text-2xl !font-bold',
                    htmlContainer: '!text-gray-700 !text-base !mt-2',
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }
});
