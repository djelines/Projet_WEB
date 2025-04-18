// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Get the form element by its ID
    const form = document.getElementById('formConfirm');

    // If the form exists on the page
    if (form) {
        // Listen for the form submission event
        form.addEventListener('submit', function (e) {
            // Show a SweetAlert modal when the form is submitted
            Swal.fire({
                title: 'Génération du quiz...',
                html: 'Cela peut prendre quelques secondes. Veuillez patienter.',
                allowOutsideClick: false, // Prevent the user from closing the alert by clicking outside
                background: '#fff', // Set background color
                customClass: {
                    popup: '!border !border-pink-300 !rounded-xl !shadow-md', // Custom popup styling
                    title: '!text-pink-400 !text-2xl !font-bold', // Custom title styling
                    htmlContainer: '!text-gray-700 !text-base !mt-2', // Custom content text styling
                },
                didOpen: () => {
                    // Show a loading spinner while the modal is open
                    Swal.showLoading();
                }
            });
        });
    }
});

// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Get the download button element by its ID
    const downloadBtn = document.getElementById('download-pdf');

    // If the download button exists on the page
    if (downloadBtn) {
        // Listen for the click event on the download button
        downloadBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior

            // Show a SweetAlert modal during the PDF generation
            Swal.fire({
                title: 'Téléchargement...',
                text: "Le PDF est en train d'être généré. Cela peut prendre quelques secondes.",
                icon: 'info', // Info icon for user feedback
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000, // Auto-close the alert after 2 seconds
                customClass: {
                    popup: 'border-[3px] border-indigo-600 shadow-lg rounded-xl bg-white', // Custom popup style
                    title: 'text-indigo-700 font-semibold text-lg', // Custom title style
                    htmlContainer: 'text-gray-600 text-sm', // Custom content text style
                    icon: 'text-indigo-500', // Custom icon color
                },
                didOpen: () => {
                    // Add a glowing shadow effect to the modal
                    const popup = document.querySelector('.swal2-popup');
                    popup.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.4)';
                },
                willClose: () => {
                    // Redirect the user to the PDF download URL after the alert closes
                    window.location.href = downloadBtn.getAttribute('href');
                }
            });
        });
    }
});
