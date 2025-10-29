$(function(){
  function onlyDigits(str){ return (str||'').replace(/\D+/g,''); }
  function formatMoneyBRFromDigits(digits){
    // digits: string only numbers, interpret as cents
    if(!digits) return 'R$ 0,00';
    const cents = parseInt(digits,10);
    const value = (cents/100).toFixed(2);
    return 'R$ ' + value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }
  function applyMoneyMask($input){
    $input.on('input', function(){
      const digits = onlyDigits($(this).val());
      $(this).val(formatMoneyBRFromDigits(digits));
    });
    // initialize if empty
    if(!$input.val()) $input.val('');
    // focus behavior: place caret at end
    $input.on('focus', function(){ const el=this; setTimeout(()=>{ el.selectionStart=el.selectionEnd=el.value.length; },0);});
  }
  function parseMoneyToNumber(str){
    if(!str) return '';
    // Accept inputs like "R$ 1.234,56" or "1.234,56" or "1234,56"
    const cleaned = (str+'').replace(/[^\d,.-]/g,'').replace(/\./g,'').replace(',', '.');
    const n = parseFloat(cleaned);
    return isNaN(n)? '': n;
  }
  const table = $('#tabela-dashboard').DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    searching: false,
    info: true,
    ajax: {
      url: window.routes && window.routes.produtosDatatable ? window.routes.produtosDatatable : '/gerenciador/produtos/datatable',
      data: function (d) {
        d.q = $('input[name="q"]').val();
        d.preco_min = parseMoneyToNumber($('input[name="preco_min"]').val());
        d.preco_max = parseMoneyToNumber($('input[name="preco_max"]').val());
        d.estoque_min = $('input[name="estoque_min"]').val();
        d.estoque_max = $('input[name="estoque_max"]').val();
      }
    },
    columns: [
      { data: 'nome', name: 'nome' },
      { data: 'preco', name: 'preco', className: 'text-end' },
      { data: 'quantidade_estoque', name: 'quantidade_estoque', className: 'text-end' },
      { data: 'acoes', name: 'acoes', orderable: false, searchable: false, className: 'text-end' },
    ],
    order: []
  });

  // Only handle the filter form (GET). Do not block other forms (e.g., logout)
  $('form[method="GET"]').on('submit', function(e){
    e.preventDefault();
    // normalize masked price filters before reload
    const $min = $("input[name='preco_min']");
    const $max = $("input[name='preco_max']");
    const vmin = parseMoneyToNumber($min.val());
    const vmax = parseMoneyToNumber($max.val());
    if ($min.val()) $min.val(vmin === '' ? '' : ('R$ ' + vmin.toFixed(2).replace('.', ',')));
    if ($max.val()) $max.val(vmax === '' ? '' : ('R$ ' + vmax.toFixed(2).replace('.', ',')));
    table.ajax.reload();
  });

  // Apply money masks
  applyMoneyMask($("input[name='preco']"));
  applyMoneyMask($("input[name='preco_min']"));
  applyMoneyMask($("input[name='preco_max']"));

  $('#formNovoProduto').on('submit', async function(e){
    e.preventDefault();
    const $form = $(this);
    const $errors = $('#novoProdutoErrors');
    $errors.addClass('d-none').empty();
    try {
      // Convert masked price to numeric before submit
      const precoMasked = $form.find("input[name='preco']").val();
      const precoNumber = parseMoneyToNumber(precoMasked);
      const payload = $form.serializeArray().reduce((acc, it)=>{ acc[it.name]=it.value; return acc; }, {});
      payload.preco = precoNumber;
      await $.ajax({ url: $form.attr('action'), method: 'POST', data: payload });
      const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNovoProduto'));
      modal.hide();
      $form[0].reset();
      table.ajax.reload();
    } catch (xhr) {
      const data = xhr.responseJSON || {};
      let msgs = [];
      if (data.errors) { Object.values(data.errors).forEach(a=>msgs.push(...a)); }
      else if (data.message) { msgs.push(data.message); }
      else { msgs.push('Falha ao salvar.'); }
      $errors.html(msgs.map(m=>`<div>${m}</div>`).join('')).removeClass('d-none');
    }
  });
});
