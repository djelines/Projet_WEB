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


document.addEventListener('DOMContentLoaded', function () {
    const downloadBtn = document.getElementById('download-pdf');

    if (downloadBtn) {
        downloadBtn.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Téléchargement en cours...',
                text: "Le PDF est en cours de génération. Cela peut prendre quelques secondes.",
                icon: 'info',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'border-[3px] border-indigo-600 shadow-lg rounded-xl bg-white',
                    title: 'text-indigo-700 font-semibold text-lg',
                    htmlContainer: 'text-gray-600 text-sm',
                    icon: 'text-indigo-500',
                },
                didOpen: () => {
                    const popup = document.querySelector('.swal2-popup');
                    popup.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.4)';
                },
                willClose: () => {
                    window.location.href = downloadBtn.getAttribute('href');
                }
            });
        });
    }
});
