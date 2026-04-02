// main.js - Global utilities for QuizMaster

$(document).ready(function () {
  // Flash success message if redirected after save
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('saved') === '1') {
    Swal.fire({
      title: 'Berhasil!',
      text: 'Data berhasil disimpan.',
      icon: 'success',
      background: '#1a1a35',
      color: '#fff',
      timer: 1800,
      showConfirmButton: false
    });
  }

  // Highlight active nav link by current path
  const path = window.location.pathname;
  $('.nav-link-custom').each(function () {
    const href = $(this).attr('href');
    if (href && href !== '/' && path.startsWith(href)) {
      $(this).addClass('active');
    }
  });
});
