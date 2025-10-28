$(function () {
  const $btnRegistrar = $('#btnRegistrar');
  const $form = $('#registerForm');
  const $errorsBox = $('#registerErrors');
  const $signinAlert = $('#signinAlert');
  const $modal = $('#modalRegistrar');

  function clearErrors() {
    $errorsBox.addClass('d-none').empty();
  }

  function resetForm() {
    $form.trigger('reset');
  }

  async function registrar() {
    clearErrors();

    const payload = {
      name: $('#reg_nome').val()?.trim() || '',
      email: ($('#reg_email').val() || '').toString().trim().toLowerCase(),
      password: $('#reg_password').val() || '',
      password_confirmation: $('#reg_password_confirmation').val() || '',
    };

    try {
      const resp = await $.ajax({
        url: '/api/v1/registrar',
        method: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify(payload),
      });

      // Sucesso: fechar modal, preencher email e alertar
      const modalInstance = bootstrap.Modal.getOrCreateInstance($modal[0]);
      modalInstance.hide();
      clearErrors();
      resetForm();

      const $emailInput = $('#email');
      $emailInput.val(payload.email).trigger('focus');

      $signinAlert.text('Usuário criado com sucesso. Faça login para continuar.')
                  .removeClass('d-none');
      setTimeout(() => $signinAlert.addClass('d-none'), 5000);
    } catch (xhr) {
      let messages = [];
      const data = xhr.responseJSON || {};
      if (data.errors) {
        Object.values(data.errors).forEach(arr => messages.push(...arr));
      } else if (data.message) {
        messages.push(data.message);
      } else {
        messages.push('Falha ao registrar.');
      }
      $errorsBox.html(messages.map(m => `<div>${m}</div>`).join('')).removeClass('d-none');
    }
  }

  $btnRegistrar.on('click', registrar);
  $modal.on('show.bs.modal', clearErrors);
  $modal.on('hidden.bs.modal', function () { clearErrors(); resetForm(); });
});
